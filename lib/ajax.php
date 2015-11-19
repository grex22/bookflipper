<?php

//This line makes sure this page is being requested via ajax
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
  return false;
}
//Require WordPress Core for user meta updates
require_once( "../../../../wp-load.php" );

$current_user = wp_get_current_user();
if(!$current_user){
  //Not logged in!
  return false;
  die();
}
//Need to add in some sort of permission check here too once permission plugin is worked out



/**
 * Our Ajax function for searching the main book database
*/
error_reporting(E_ERROR);

function numerify($string){
  return preg_replace('@[^0-9\.]+@', '', $string);
}

$servername = "testeflip.cljbdifkztiw.us-west-2.rds.amazonaws.com";
$username = "root";
$password = "efliptest";
$table = "test_books";
$dbname = "eflip";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//limit, offset, search, sort, order
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : false;
$order = (isset($_GET['order']) && in_array($_GET['order'],array('asc','desc'))) ? $_GET['order'] : 'asc';
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($conn, $_GET['sort']) : 'title';
$offset = (isset($_GET['offset']) && is_numeric($_GET['offset'])) ? $_GET['offset'] : 0;
$limit = (isset($_GET['limit']) && is_numeric($_GET['limit'])) ? $_GET['limit'] : 20;

//known textbooks search
$textbook = (isset($_GET['is_textbook']) && is_numeric($_GET['is_textbook'])) ? $_GET['is_textbook'] : false;


if(isset($_GET['used_price_max'])) $used_price_max = numerify(mysqli_real_escape_string($conn, $_GET['used_price_max']));
if(isset($_GET['used_price_min'])) $used_price_min = numerify(mysqli_real_escape_string($conn, $_GET['used_price_min']));
if(isset($_GET['new_price_max'])) $new_price_max = numerify(mysqli_real_escape_string($conn, $_GET['new_price_max']));
if(isset($_GET['new_price_min'])) $new_price_min = numerify(mysqli_real_escape_string($conn, $_GET['new_price_min']));
if(isset($_GET['amazon_price_max'])) $amazon_price_max = numerify(mysqli_real_escape_string($conn, $_GET['amazon_price_max']));
if(isset($_GET['amazon_price_min'])) $amazon_price_min = numerify(mysqli_real_escape_string($conn, $_GET['amazon_price_min']));
if(isset($_GET['total_used_max'])) $total_used_max = numerify(mysqli_real_escape_string($conn, $_GET['total_used_max']));
if(isset($_GET['total_used_min'])) $total_used_min = numerify(mysqli_real_escape_string($conn, $_GET['total_used_min']));
if(isset($_GET['total_new_max'])) $total_new_max = numerify(mysqli_real_escape_string($conn, $_GET['total_new_max']));
if(isset($_GET['total_new_min'])) $total_new_min = numerify(mysqli_real_escape_string($conn, $_GET['total_new_min']));
if(isset($_GET['sales_rank_max'])){
  $sales_rank_max = numerify(mysqli_real_escape_string($conn, $_GET['sales_rank_max']));
}else{
  $sales_rank_max = 250000;
}
if(isset($_GET['sales_rank_min'])) $sales_rank_min = numerify(mysqli_real_escape_string($conn, $_GET['sales_rank_min']));
if(isset($_GET['publication_date_max'])) $publication_date_max = numerify(mysqli_real_escape_string($conn, $_GET['publication_date_max']));
if(isset($_GET['publication_date_min'])) $publication_date_min = numerify(mysqli_real_escape_string($conn, $_GET['publication_date_min']));


$query =  "SELECT SQL_CALC_FOUND_ROWS * FROM $table ";

if($search){
  $query .= "WHERE (title LIKE '%$search%' OR asin LIKE '%$search%') ";
}else{
  $query .= "WHERE 1 = 1 "; //gets all records, gets our first 'where' clause in there
}

if(isset($textbook) && $textbook == 1){
  $query .= "AND is_textbook = 1 ";
}

if($used_price_max || $used_price_min){
  if($used_price_max && $used_price_min){
    $query .= "AND used_price BETWEEN $used_price_min and $used_price_max ";
  }elseif($used_price_max){
    $query .= "AND used_price <= $used_price_max ";
  }elseif($used_price_min){
    $query .= "AND used_price >= $used_price_min ";
  }
}
if($new_price_max || $new_price_min){
  if($new_price_max && $new_price_min){
    $query .= "AND new_price BETWEEN $new_price_min and $new_price_max ";
  }elseif($new_price_max){
    $query .= "AND new_price <= $new_price_max ";
  }elseif($new_price_min){
    $query .= "AND new_price >= $new_price_min ";
  }
}
if($amazon_price_max || $amazon_price_min){
  if($amazon_price_max && $amazon_price_min){
    $query .= "AND amazon_price BETWEEN $amazon_price_min and $amazon_price_max ";
  }elseif($amazon_price_max){
    $query .= "AND amazon_price <= $amazon_price_max ";
  }elseif($amazon_price_min){
    $query .= "AND amazon_price >= $amazon_price_min ";
  }
}
if($total_used_max || $total_used_min){
  if($total_used_max && $total_used_min){
    $query .= "AND total_used BETWEEN $total_used_min and $total_used_max ";
  }elseif($total_used_max){
    $query .= "AND total_used <= $total_used_max ";
  }elseif($total_used_min){
    $query .= "AND total_used >= $total_used_min ";
  }
}
if($total_new_max || $total_new_min){
  if($total_new_max && $total_new_min){
    $query .= "AND total_new BETWEEN $total_new_min and $total_new_max ";
  }elseif($total_new_max){
    $query .= "AND total_new <= $total_new_max ";
  }elseif($total_new_min){
    $query .= "AND total_new >= $total_new_min ";
  }
}
if($sales_rank_max || $sales_rank_min){
  if($sales_rank_max && $sales_rank_min){
    $query .= "AND sales_rank BETWEEN $sales_rank_min and $sales_rank_max ";
  }elseif($sales_rank_max){
    $query .= "AND sales_rank <= $sales_rank_max ";
  }elseif($sales_rank_min){
    $query .= "AND sales_rank >= $sales_rank_min ";
  }
}
if($publication_date_max || $publication_date_min){
  if($publication_date_max && $publication_date_min){
    $query .= "AND publication_date BETWEEN $publication_date_min and $publication_date_max ";
  }elseif($publication_date_max){
    $query .= "AND publication_date <= $publication_date_max ";
  }elseif($publication_date_min){
    $query .= "AND publication_date >= $publication_date_min ";
  }
}
$query .= "
  ORDER BY $sort $order
  LIMIT $limit OFFSET $offset";

if ($res = $conn->query($query)) {

  $totalrows = $conn->query("SELECT FOUND_ROWS()");
  $json_array = array("total"=>$totalrows->fetch_row(),"rows"=>array());
  while ($row = $res->fetch_assoc()) {
    $json_array['rows'][] = $row;
  }

  //Increment our user's search count for reporting
  $old = intval(get_user_meta($current_user->ID,'search_count',true));
  update_user_meta($current_user->ID, 'search_count', $old+1);

}
if($json_array){
  echo json_encode($json_array);
}


/* free result set */
$res->free();
die();
