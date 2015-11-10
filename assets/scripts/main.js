/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.

//Function to initialize our noUi sliders
function initNoUiSliders(){
  //Currency Format Function
  var moneyFormat = wNumb({
    decimals: 2,
    thousand: ',',
    //prefix: '$'
  });
  
  var integerFormat = wNumb({
    decimals: 0
  });
  var bigIntegerFormat = wNumb({
    decimals: 0,
    thousand: ','
  });
  
  jQuery(".slider_th input").on('focus', function() {
    var $this = jQuery(this);
        $this.one('mouseup.mouseupSelect', function() {
            $this.select();
            return false;
        })
        .one('mousedown', function() {
            // compensate for untriggered 'mouseup' caused by focus via tab
            $this.off('mouseup.mouseupSelect');
        })
        .select();
  })
  .keypress(function(e) {
    //prevent letters and more than one decimal from being typed here
    // 46 is a period
    if (e.which != 46 && (e.which < 48 || e.which > 57)) {
        return(false);
    }
    if (e.which == 46 && this.value.indexOf(".") != -1) {
        return(false);   // only one decimal allowed
    }
  }).on('change', function(){
    jQuery("#search_button").addClass('nag');
  });

  
  //Guard variable is used later to allow text inputs to be edited
  //without snapping the sliders to the closest input
  guard = false;
    
  var used_price_slider = document.getElementById('used_price_slider');
    var used_price_max = document.getElementById('used_price_max');
    var used_price_min = document.getElementById('used_price_min');
  var new_price_slider = document.getElementById('new_price_slider');
    var new_price_max = document.getElementById('new_price_max');
    var new_price_min = document.getElementById('new_price_min');
  var amazon_price_slider = document.getElementById('amazon_price_slider');
    var amazon_price_max = document.getElementById('amazon_price_max');
    var amazon_price_min = document.getElementById('amazon_price_min');
  var total_used_slider = document.getElementById('total_used_slider');
    var total_used_max = document.getElementById('total_used_max');
    var total_used_min = document.getElementById('total_used_min');
  var total_new_slider = document.getElementById('total_new_slider');
    var total_new_max = document.getElementById('total_new_max');
    var total_new_min = document.getElementById('total_new_min');
  var sales_rank_slider = document.getElementById('sales_rank_slider');
    var sales_rank_max = document.getElementById('sales_rank_max');
    var sales_rank_min = document.getElementById('sales_rank_min');
  var publication_date_slider = document.getElementById('publication_date_slider');
    var publication_date_max = document.getElementById('publication_date_max');
    var publication_date_min = document.getElementById('publication_date_min');

  noUiSlider.create(used_price_slider, {
    start: [0, 100],
    connect: true,
    orientation: 'vertical',
    snap: true,
    direction: 'rtl',
    range: {
      'min': 0,
      '6.5%':  0.01,
      '13%': 0.10,
      '19.5%': 0.25,
      '26%': 0.50,
      '32.5%': 1,
      '39%': 2,
      '45.5%': 3,
      '52%': 4,
      '58.5%': 5,
      '65%': 10,
      '71.5%': 20,
      '78%': 30,
      '86.5%': 40,
      '93%': 50,
      'max': 100
    },format: moneyFormat
  }).on('update', function( values, handle ) {
    jQuery("#search_button").addClass('nag');
    if(guard) return;
    if ( handle ) {
      if(parseFloat(values[handle].replace("$","")) >= 100){
        used_price_max.value = "No Limit";
      }else{
        used_price_max.value = values[handle];
      }
    } else {
      used_price_min.value = values[handle];
    }
  });
  
  // When the input changes, set the slider value
  used_price_max.addEventListener('change', function(){
    guard = true;
    used_price_slider.noUiSlider.set([null, this.value]);
    jQuery(used_price_max).val(moneyFormat.to(parseFloat(this.value)));
    guard = false;
  });
  used_price_min.addEventListener('change', function(){
    guard = true;
    used_price_slider.noUiSlider.set([this.value, null]);
    jQuery(used_price_min).val(moneyFormat.to(parseFloat(this.value)));
    guard = false;
  });
  
  
  noUiSlider.create(new_price_slider, {
    start: [0, 250],
    connect: true,
    orientation: 'vertical',
    snap: true,
    direction: 'rtl',
    range: {
      'min': 0,
      '6.5%':  10,
      '13%': 20,
      '19.5%': 30,
      '26%': 40,
      '32.5%': 50,
      '39%': 60,
      '45.5%': 70,
      '52%': 80,
      '58.5%': 90,
      '65%': 100,
      '71.5%': 125,
      '78%': 150,
      '86.5%': 175,
      '93%': 200,
      'max': 250
    },format: moneyFormat
  }).on('update', function( values, handle ) {
    jQuery("#search_button").addClass('nag');
    if(guard) return;
    if ( handle ) {
      if(parseFloat(values[handle].replace("$","")) >= 250){
        new_price_max.value = "No Limit";
      }else{
        new_price_max.value = values[handle];
      }
    } else {
      new_price_min.value = values[handle];
    }
  });
  
  // When the input changes, set the slider value
  new_price_max.addEventListener('change', function(){
    guard = true;
    new_price_slider.noUiSlider.set([null, this.value]);
    jQuery(new_price_max).val(moneyFormat.to(parseFloat(this.value)));
    guard = false;
  });
  new_price_min.addEventListener('change', function(){
    guard = true;
    new_price_slider.noUiSlider.set([this.value, null]);
    jQuery(new_price_min).val(moneyFormat.to(parseFloat(this.value)));
    guard = false;
  });

  //Amazon Price Slider
  noUiSlider.create(amazon_price_slider, {
    start: [0, 250],
    connect: true,
    orientation: 'vertical',
    snap: true,
    direction: 'rtl',
    range: {
      'min': 0,
      '6.5%':  10,
      '13%': 20,
      '19.5%': 30,
      '26%': 40,
      '32.5%': 50,
      '39%': 60,
      '45.5%': 70,
      '52%': 80,
      '58.5%': 90,
      '65%': 100,
      '71.5%': 125,
      '78%': 150,
      '86.5%': 175,
      '93%': 200,
      'max': 250
    },format: moneyFormat
  }).on('update', function( values, handle ) {
    jQuery("#search_button").addClass('nag');
    if(guard) return;
    if ( handle ) {
      if(parseFloat(values[handle].replace("$","")) >= 250){
        amazon_price_max.value = "No Limit";
      }else{
        amazon_price_max.value = values[handle];
      }
    } else {
      amazon_price_min.value = values[handle];
    }
  });
  
  // When the input changes, set the slider value
  amazon_price_max.addEventListener('change', function(){
    guard = true;
    amazon_price_slider.noUiSlider.set([null, this.value]);
    jQuery(amazon_price_max).val(moneyFormat.to(parseFloat(this.value)));
    guard = false;
  });
  amazon_price_min.addEventListener('change', function(){
    guard = true;
    amazon_price_slider.noUiSlider.set([this.value, null]);
    jQuery(amazon_price_min).val(moneyFormat.to(parseFloat(this.value)));
    guard = false;
  });
  
  //Total Used Slider
  noUiSlider.create(total_used_slider, {
    start: [0, 200],
    connect: true,
    orientation: 'vertical',
    snap: true,
    direction: 'rtl',
    range: {
      'min': 0,
      '6.5%':  5,
      '13%': 10,
      '19.5%': 15,
      '26%': 20,
      '32.5%': 25,
      '39%': 30,
      '45.5%': 40,
      '52%': 50,
      '58.5%': 60,
      '65%': 70,
      '71.5%': 80,
      '78%': 90,
      '86.5%': 100,
      '93%': 150,
      'max': 200
    },format: integerFormat
  }).on('update', function( values, handle ) {
    jQuery("#search_button").addClass('nag');
    if(guard) return;
    if ( handle ) {
      if(parseInt(values[handle]) >= 200){
        total_used_max.value = "No Limit";
      }else{
        total_used_max.value = values[handle];
      }
    } else {
      total_used_min.value = values[handle];
    }
  });
  
  // When the input changes, set the slider value
  total_used_max.addEventListener('change', function(){
    guard = true;
    total_used_slider.noUiSlider.set([null, this.value]);
    jQuery(total_used_max).val(integerFormat.to(parseFloat(this.value)));
    guard = false;
  });
  total_used_min.addEventListener('change', function(){
    guard = true;
    total_used_slider.noUiSlider.set([this.value, null]);
    jQuery(total_used_min).val(integerFormat.to(parseFloat(this.value)));
    guard = false;
  });
  
  //Total New Slider
  noUiSlider.create(total_new_slider, {
    start: [0, 200],
    connect: true,
    orientation: 'vertical',
    snap: true,
    direction: 'rtl',
    range: {
      'min': 0,
      '6.5%':  5,
      '13%': 10,
      '19.5%': 15,
      '26%': 20,
      '32.5%': 25,
      '39%': 30,
      '45.5%': 40,
      '52%': 50,
      '58.5%': 60,
      '65%': 70,
      '71.5%': 80,
      '78%': 90,
      '86.5%': 100,
      '93%': 150,
      'max': 200
    },format: integerFormat
  }).on('update', function( values, handle ) {
    jQuery("#search_button").addClass('nag');
    if(guard) return;
    if ( handle ) {
      if(parseInt(values[handle]) >= 200){
        total_new_max.value = "No Limit";
      }else{
        total_new_max.value = values[handle];
      }
    } else {
      total_new_min.value = values[handle];
    }
  });
  
  // When the input changes, set the slider value
  total_new_max.addEventListener('change', function(){
    guard = true;
    total_new_slider.noUiSlider.set([null, this.value]);
    jQuery(total_new_max).val(integerFormat.to(parseFloat(this.value)));
    guard = false;
  });
  total_new_min.addEventListener('change', function(){
    guard = true;
    total_new_slider.noUiSlider.set([this.value, null]);
    jQuery(total_new_min).val(integerFormat.to(parseFloat(this.value)));
    guard = false;
  });
  
  //Sales Rank Slider
  noUiSlider.create(sales_rank_slider, {
    start: [0, 200000],
    connect: true,
    orientation: 'vertical',
    snap: true,
    direction: 'rtl',
    range: {
      'min': 0,
      '6.5%':  1000,
      '13%': 5000,
      '19.5%': 10000,
      '26%': 25000,
      '32.5%': 50000,
      '39%': 75000,
      '45.5%': 100000,
      '52%': 250000,
      '58.5%': 500000,
      '65%': 750000,
      '71.5%': 1000000,
      '78%':  1500000,
      '86.5%': 2000000,
      '93%': 2500000,
      'max': 3000000
    },format: bigIntegerFormat
  }).on('update', function( values, handle ) {
    jQuery("#search_button").addClass('nag');
    if(guard) return;
    if ( handle ) {
      if(parseInt(values[handle].split(",").join("")) >= 3000000){
        sales_rank_max.value = "No Limit";
      }else{
        sales_rank_max.value = values[handle];
      }
    } else {
      sales_rank_min.value = values[handle];
    }
  });
  
  // When the input changes, set the slider value
  sales_rank_max.addEventListener('change', function(){
    guard = true;
    sales_rank_slider.noUiSlider.set([null, this.value]);
    jQuery(sales_rank_max).val(bigIntegerFormat.to(parseFloat(this.value)));
    guard = false;
  });
  sales_rank_min.addEventListener('change', function(){
    guard = true;
    sales_rank_slider.noUiSlider.set([this.value, null]);
    jQuery(sales_rank_min).val(bigIntegerFormat.to(parseFloat(this.value)));
    guard = false;
  });
  
  
  //Sales Rank Slider
  noUiSlider.create(publication_date_slider, {
    start: [1980, 2016],
    connect: true,
    orientation: 'vertical',
    snap: true,
    direction: 'rtl',
    range: {
      'min': 1980,
      '6.5%':  1985,
      '13%': 1990,
      '19.5%': 1995,
      '26%': 2000,
      '32.5%': 2002,
      '39%': 2004,
      '45.5%': 2006,
      '52%': 2008,
      '58.5%': 2010,
      '65%': 2011,
      '71.5%': 2012,
      '78%':  2013,
      '86.5%': 2014,
      '93%': 2015,
      'max': 2016
    },format: integerFormat
  }).on('update', function( values, handle ) {
    jQuery("#search_button").addClass('nag');
    if(guard) return;
    if ( handle ) {
      publication_date_max.value = values[handle];
    } else {
      if(parseInt(values[handle]) <= 1980){
        publication_date_min.value = "No Limit";
      }else{
        publication_date_min.value = values[handle];
      }
    }
  });
  
  // When the input changes, set the slider value
  publication_date_max.addEventListener('change', function(){
    guard = true;
    publication_date_slider.noUiSlider.set([null, this.value]);
    jQuery(publication_date_max).val(integerFormat.to(parseFloat(this.value)));
    guard = false;
  });
  publication_date_min.addEventListener('change', function(){
    guard = true;
    publication_date_slider.noUiSlider.set([this.value, null]);
    jQuery(publication_date_min).val(integerFormat.to(parseFloat(this.value)));
    guard = false;
  });
}

