<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
    ?>
    <?php
      if(is_front_page()):
      get_template_part('templates/header');
    ?>
        <div id="subnav">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <ul class="list-unstyled">
                  <li class="active"><a href="#">FBA Arbitrage</a></li>
                  <li><a href="#">Known Textbooks</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <table id='main_results_table' class='results_table table-striped table'
          data-toggle='table'
          data-url='<?php echo get_stylesheet_directory_uri();?>/lib/ajax.php'
          data-pagination-h-align='right'
          data-pagination-detail-h-align='left'
          data-pagination='true'
          data-query-params='checkFilters'
          data-page-size='20'
          data-page-list='[20, 50, 100]' 
          data-side-pagination='server'>
          <thead>
            <tr id='filter_row'>
              <th colspan='3' class='search_th'>
                <form id="search_form" action="" method="get" onsubmit="submitSearch()">
                  <input type="text" class="input-lg" placeholder="TITLE / ASIN Search" id="search_field"><br>
                  <button type="submit" href="#" id="search_button" class="btn btn-primary">Search</button>
                  <a href="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" id="reset_search" class="btn btn-secondary">Clear</a>
                </form>
              </th>
              <th class="slider_th">
                <div class="input_label">Max Price<br>Used</div>
                <input id='used_price_max' type='text' class='form-control input-sm'>
                <div id='used_price_slider' class='filter_slider'></div>
                <input id='used_price_min' type='text' class='form-control input-sm'>
                <div class="input_label">Min Price<br>Used</div>
              </th>
              <th class="slider_th">
                <div class="input_label">Max New<br>Price</div>
                <input id='new_price_max' type='text' class='form-control input-sm'>
                <div id='new_price_slider' class='filter_slider'></div>
                <input id='new_price_min' type='text' class='form-control input-sm'>
                <div class="input_label">Min New<br>Price</div>
              </th>
              <th class="slider_th">
                <div class="input_label">Max Amazon<br>Price</div>
                <input id='amazon_price_max' type='text' class='form-control input-sm'>
                <div id='amazon_price_slider' class='filter_slider'></div>
                <input id='amazon_price_min' type='text' class='form-control input-sm'>
                <div class="input_label">Min Amazon<br>Price</div>
              </th>
              <th class="slider_th">
                <div class="input_label">Max Used<br>Offers</div>
                <input id='total_used_max' type='text' class='form-control input-sm'>
                <div id='total_used_slider' class='filter_slider'></div>
                <input id='total_used_min' type='text' class='form-control input-sm'>
                <div class="input_label">Min Used<br>Offers</div>
              </th>
              <th class="slider_th">
                <div class="input_label">Max New<br>Offers</div>
                <input id='total_new_max' type='text' class='form-control input-sm'>
                <div id='total_new_slider' class='filter_slider'></div>
                <input id='total_new_min' type='text' class='form-control input-sm'>
                <div class="input_label">Min New<br>Offers</div>
              </th>
              <th class="slider_th">
                <div class="input_label">Max<br>Rank</div>
                <input id='sales_rank_max' type='text' class='form-control input-sm'>
                <div id='sales_rank_slider' class='filter_slider'></div>
                <input id='sales_rank_min' type='text' class='form-control input-sm'>
                <div class="input_label">Min<br>Rank</div>
              </th>
              <th class="slider_th">
                <div class="input_label">Max Pub<br>Date</div>
                <input id='publication_date_max' type='text' class='form-control input-sm'>
                <div id='publication_date_slider' class='filter_slider'></div>
                <input id='publication_date_min' type='text' class='form-control input-sm'>
                <div class="input_label">Min Pub<br>Date</div>
              </th>
            </tr>
            <tr>
              <th data-sortable='true' data-field='asin' data-formatter='amazonLinkFormatter'>ASIN</th>
              <th data-sortable='true' data-field='title' data-formatter='amazonLinkFormatter'>Title</th>
              <th data-formatter='camelImageFormatter'>Rank History</th>
              <th data-sortable='true' data-field='used_price'>$ Used</th>
              <th data-sortable='true' data-field='new_price'>$ New</th>
              <th data-sortable='true' data-field='amazon_price'>$ Amazon</th>
              <th data-sortable='true' data-field='total_used'>#Used</th>
              <th data-sortable='true' data-field='total_new'>#New</th>
              <th data-formatter='commaFormatter' data-sortable='true' data-field='sales_rank'>#Rank</th>
              <th data-sortable='true' data-field='publication_date'>Pub Date</th>
            </tr>
          </thead>
        </table>

        <script type="text/javascript">
          //placeholder for our query variables object used in refreshing the table
          var queryObject = new Object();
          
          function justNumbers(value){
            return value.replace(/[^\d.]/g, '');
          }
          function checkFilters(params) {
            
            console.log(queryObject);
            for(var key in queryObject){
              if (queryObject.hasOwnProperty(key)) {
                params[key] = queryObject[key];
              }
            }
            return params;
          }
          function submitSearch(){
            event.preventDefault();
            jQuery("#search_field").blur();
            jQuery("#search_button").removeClass('nag');
            parseFilters();
          }
          function parseFilters() {
            
            queryObject.search = jQuery("#search_field").val();
            queryObject.used_price_max = jQuery("#used_price_max").val();
            queryObject.used_price_min = jQuery("#used_price_min").val();
            queryObject.new_price_max = jQuery("#new_price_max").val();
            queryObject.new_price_min = jQuery("#new_price_min").val();
            queryObject.amazon_price_max = jQuery("#amazon_price_max").val();
            queryObject.amazon_price_min = jQuery("#amazon_price_min").val();
            queryObject.total_used_max = jQuery("#total_used_max").val();
            queryObject.total_used_min = jQuery("#total_used_min").val();
            queryObject.total_new_max = jQuery("#total_new_max").val();
            queryObject.total_new_min = jQuery("#total_new_min").val();
            queryObject.sales_rank_max = jQuery("#sales_rank_max").val();
            queryObject.sales_rank_min = jQuery("#sales_rank_min").val();
            queryObject.publication_date_max = jQuery("#publication_date_max").val();
            queryObject.publication_date_min = jQuery("#publication_date_min").val();
            for (var key in queryObject) {
              if (queryObject.hasOwnProperty(key)) {
                if(queryObject[key] == "No Limit"){
                queryObject[key] = 0;
                }
              }
            }
            jQuery("#main_results_table").bootstrapTable('refresh',{query: queryObject});
          }
          
          //Bootstrap Table formatting functions
          function amazonLinkFormatter(value, row, index) {
            if(value.length > 25){
              value = value.substring(0,25)+"&hellip;"
            }
            return '<a href="http://www.amazon.com/dp/'+row.asin+'" target="_blank">'+value+'</a>';
          }
          function camelImageFormatter(value, row, index) {
            return '<a href="http://camelcamelcamel.com/product/'+row.asin+'" target="_blank"><img alt="CamelCamelCamel" src="wp-content/themes/bookflipper/dist/images/camel.png"></a> <a href="#" rel="popover" data-img="http://charts.camelcamelcamel.com/us/'+row.asin+'/amazon.png?force=1&zero=0&w=330&h=180&desired=false&legend=0&ilt=1&tp=6m&fo=0&lang=en"><i class="glyphicon glyphicon-eye-open"></i></a>';
          }
          function commaFormatter(value, row, index) {
            return parseInt(value).toLocaleString();
          }
          jQuery(function($){
            $table = $('#main_results_table');
            
            $table.on('post-body.bs.table',function(e){
              jQuery("a[rel=popover]").popover({
                html: true,
                trigger: "hover",
                container: "body",
                placement: "bottom",
                content: function () {
                  return '<img src="'+jQuery(this).data('img') + '" />';
                }
              }).click(function(e){e.preventDefault();});
            });

            
            jQuery("a[rel=popover]").popover({
              html: true,
              trigger: "hover",
              container: "body",
              placement: "bottom",
              content: function () {
                return '<img src="'+jQuery(this).data('img') + '" />';
              }
            }).click(function(e){e.preventDefault();});
                        
            setTimeout(function () {
              $table.bootstrapTable('resetView');
              jQuery("#search_button").removeClass('nag');
              initNoUiSliders();
              
            }, 500);
                       
          });
        </script>

      <section class="home_section masthead">
        <div class="container">
          <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center">
              <h1>YOUR HOME FOR SOURCING BOOKS ONLINE...FROM HOME. </h1>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text-center">
              <div class="row masthead_steps">
                <div class="col-sm-3 col-xs-6 text-center">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-filter.png">
                  Filter
                </div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-search.png">
                  &nbsp;&nbsp;Research
                </div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-calculate.png">
                  Calculate
                </div>
                <div class="col-sm-3 col-xs-6 text-center">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-cart.png">
                  Buy
                </div>
              </div>
              <div class="row">
                <form class="home_login form-inline">
                  <input type="text" name="username" placeholder="USERNAME">
                  <input type="password" name="password" placeholder="PASSWORD">
                  <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <a href="#">Forgot Password?</a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center">
              <a href="#" class="btn btn-primary btn-lg">Sign Up <em>Now.</em></a>
              <div class="spacer clearfix"></div>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius libero dolor, at ornare diam commodo vitae. Nam eget urna sapien. Sed dignissim placerat purus nec sodales. Ut eu orci vitae purus gravida varius.</p>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section alt">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center">
              <h2 class="no_margin_top">Refer a Friend.</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius libero dolor, at ornare diam commodo vitae. Nam eget urna sapien. Sed dignissim placerat purus nec sodales. Ut eu orci vitae purus gravida varius.</p>
              <a href="#" class="btn btn-primary btn-lg">Sign Up <em>Now.</em></a>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <div class="row big_margin_bottom">
                <div class="col-sm-3 col-xs-3 text-center big_steps">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-filter-b.png">
                  01
                </div>
                <div class="col-sm-9 col-xs-9">
                  <h2 class="green no_margin_top">Filter</h2>
                  <p>eFLIP has filters that can crank through Amazon’s data so quickly and efficiently, it makes the filtering process of reverse osmosis look elementary in comparison!  By controlling variables such as price, number of offers available, sales rank, and even using keywords, you can hone in quickly on books that have the greatest opportunity for profit.  eFLIP will help you find books that can be purchased cheaply from Merchant Fulfilled sellers and flipped profitably through Amazon's FBA program.</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row big_margin_bottom">
                <div class="col-sm-3 col-xs-3 text-center big_steps">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-search-b.png">
                  02
                </div>
                <div class="col-sm-9 col-xs-9">
                  <h2 class="green no_margin_top">Research</h2>
                  <p>Once you've filtered the data, your skills as a historian will come into play.  By taking a quick peek at the book's sales rank history, you can make an informed decision about if the book sells often enough to justify adding it to your inventory.  You can also figure out if the book's sales history identifies it as a "likely textbook" with popularity twice a year – in August and January.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="row big_margin_bottom">
                <div class="col-sm-3 col-xs-3 text-center big_steps">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-calculate-b.png">
                  03
                </div>
                <div class="col-sm-9 col-xs-9">
                  <h2 class="green no_margin_top">CALCULATE</h2>
                  <p>Once you've found a potentially flippable book, you'll need to determine if it meets your profitability requirements.  An integrated calculator will take into account the book's weight and will spit out list prices for your desired profit margins of 25%, 50%, 100%, 200%, or 300%.  Simply input your purchase price (including shipping) and the calculator will take care of the rest!</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row big_margin_bottom">
                <div class="col-sm-3 col-xs-3 text-center big_steps">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/step-cart-b.png">
                  04
                </div>
                <div class="col-sm-9 col-xs-9">
                  <h2 class="green no_margin_top">BUY</h2>
                  <p>In this business, you make money when you buy, not when you sell.  eFLIP will give you the tools that you need to ensure that you purchase books with the greatest chance of hitting your profit margins.  Once you pull the trigger, simply wait for the books to show up on your front porch and then flip them around back into your FBA inventory and wait for the sales to roll in!  Commit to purchasing 5 books a day, 5 days a week, and you'll wind up with 100 quality books every month!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="home_section alt video_section">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 text-center">
              <img src="http://placehold.it/650x350">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center">
              <h2 class="green">WATCH OUR VIDEO TO SEE HOW THE BOOKFLIPPER WORKS.</h2>
              <p>Lorem ipsum dolor sit ante. Duis nec elit purus. Nulla vitae lorem tristique, facilisis magna sit amet, iaculis urna. In hac habitasse platea dictumst. Morbi in placerat elit. Nam eu felis eget ipsum porta pellentesque. </p>
            </div>
          </div>
        </div>
      </section>
    <?php 
      else: // else is NOT home page
      get_template_part('templates/header');
    ?>
    <div class="wrap container" role="document">
      <div class="content row">
        <main class="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <?php if (Setup\display_sidebar()) : ?>
          <aside class="sidebar">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php
      endif; //endif if isn't home page
      
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
