<?php
/**
 * Template Name: Search Page
 */
?>

<?php
  if(is_page(20)) $page = "fba";
  if(is_page(22)) $page = "textbook";
?>

      <div id="subnav">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <ul class="list-unstyled">
                <li<?php if($page == "fba") echo " class='active'"; ?>><a href="<?php echo get_permalink(20); ?>">FBA Arbitrage</a></li>
                <?php if($page == "textbook"): ?>
                <li<?php if($page == "textbook") echo " class='active'"; ?>><a href="<?php echo get_permalink(22); ?>">Known Textbooks</a></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <table id='main_results_table' class='results_table table-striped table'
        data-toggle='table'
        data-url='<?php echo get_stylesheet_directory_uri();?>/lib/ajax.php<?php if($page == "textbook") echo "?is_textbook=1" ?>'
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
                <input type="hidden" id="is_textbook" value="<?php if($page == "textbook"){ echo "1"; }else{echo "0";} ?>">
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
            <th data-formatter='camelImageFormatter'>Pricing</th>
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

      <div class="modal fade" id="calculatorModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Pricing Calculator</h4>
            </div>
            <div class="modal-body">
              <div class="form-inline">
                <div class="well well-sm">
                  <h5 id="book_title" class="green"><i class="glyphicon glyphicon-book"></i> <span></span></h5>
                </div>
                <img id="calc_instructs" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/calc-instructions.png">
                <strong>Weight: </strong> <span id="weight_display"></span> lbs.<br>
                <input type="hidden" id="weight" class="form-control">
                <div class="form-group">
                  <label>Purchase Price</label><br>
                  <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control" id="purchase_price">
                  </div>
                </div>
                <br>
                <br>
                <table class="table table-condensed">
                  <thead>
                    <tr><th>To make this profit margin...</th><th class="text-right">Price your book at:</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>25%</td><td class="text-right">$<span id="price_25"></span></td>
                    </tr>
                    <tr>
                      <td>50%</td><td class="text-right">$<span id="price_50"></span></td>
                    </tr>
                    <tr>
                      <td>100%</td><td class="text-right">$<span id="price_100"></span></td>
                    </tr>
                    <tr>
                      <td>200%</td><td class="text-right">$<span id="price_200"></span></td>
                    </tr>
                    <tr>
                      <td>300%</td><td class="text-right">$<span id="price_300"></span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <a href="#" data-dismiss="modal">Close</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->



<script type="text/javascript">

  jQuery('#calculatorModal').on('show.bs.modal', function (event) {
    jQuery("#purchase_price").val("");
    jQuery("#price_25").html(" -- ");
    jQuery("#price_50").html(" -- ");
    jQuery("#price_100").html(" -- ");
    jQuery("#price_200").html(" -- ");
    jQuery("#price_300").html(" -- ");
    var button = jQuery(event.relatedTarget) // Button that triggered the modal
    var weight = button.data('weight') // Extract info from data-* attributes
    var title = button.data('title') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = jQuery(this)
    modal.find('.modal-body input#weight').val(weight);
    modal.find('.modal-body #weight_display').html(weight / 100);
    modal.find('.modal-body #book_title span').html(title.replace(/\"/g, ""));
  });

  //placeholder for our query variables object used in refreshing the table
  var queryObject = new Object();


  function justNumbers(value){
    return value.replace(/[^\d.]/g, '');
  }

  function calculateMarginPricing(margin){
    var weight = parseFloat(parseFloat(jQuery("#weight").val() / 100).toFixed(2)); // convert to pounds
    var shippingPerPound = 0.3;
    var saleFees = 2.39;
    var weightFee = 1.29; //this is VERY wrong
    /* weight charge */
    var roundedWeight = Math.round( weight * 10 ) / 10;
    if(weight <= 0.5){
      weightFee = 0.50;
    }else if(weight <= 0.9){
      weightFee = 0.63;
    }else{
      weightFee = .88 + .41 * Math.round(roundedWeight - 1);
    }
    var inboundShipping = shippingPerPound * weight;
    var total;
    total = (weightFee + saleFees + inboundShipping + (parseFloat(jQuery("#purchase_price").val()) * (margin + 1))) / .85;
    if(isNaN(total)){
      return " -- ";
    }else{
      return total.toFixed(2);
    }
  }

  //Calculator JS
  jQuery("#purchase_price").keypress(function(e) {
    //prevent letters and more than one decimal from being typed here
    // 46 is a period
    if (e.which != 46 && (e.which < 48 || e.which > 57)) {
        return(false);
    }
    if (e.which == 46 && this.value.indexOf(".") != -1) {
        return(false);   // only one decimal allowed
    }
  }).keyup(function(){
    jQuery("#price_25").html(calculateMarginPricing(.25));
    jQuery("#price_50").html(calculateMarginPricing(.5));
    jQuery("#price_100").html(calculateMarginPricing(1));
    jQuery("#price_200").html(calculateMarginPricing(2));
    jQuery("#price_300").html(calculateMarginPricing(3));
  });

  function checkFilters(params) {
    //uncomment for helpful debugging
    //console.log(queryObject);
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
    queryObject.is_textbook = jQuery("#is_textbook").val();
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
    fullvalue = value.replace(/\"/g, "");
    if(value.length > 30){
      value = value.substring(0,30)+"&hellip;"
    }
    return '<a href="http://www.amazon.com/dp/'+row.asin+'/?tag=bookflipper-20" target="_blank" title="'+fullvalue+'">'+value+'</a>';
  }
  function camelImageFormatter(value, row, index) {
    var escapedtitle = row.title.replace(/\"/g, "");
    return '<a href="http://camelcamelcamel.com/product/'+row.asin+'" target="_blank" title="CamelCamelCamel History"><img alt="CamelCamelCamel" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/camel.png"></a> <a href="#" rel="popover" data-img="http://charts.camelcamelcamel.com/us/'+row.asin+'/amazon.png?force=1&zero=0&w=330&h=180&desired=false&legend=0&ilt=1&tp=6m&fo=0&lang=en"><i class="glyphicon glyphicon glyphicon-stats"></i> <a href="#calculatorModal" title="Calculate Listing Price" data-weight="'+row.weight+'" data-title="'+escapedtitle+'" data-toggle="modal"><img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/calc.png"></a>';
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
