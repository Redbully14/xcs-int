/*
|------------------------------------------------------------------------------------
|                           BASEXCS MAIN WEBSITE INFO
|------------------------------------------------------------------------------------
|
| FRAMEWORK NAME: XCS-int
| FRAMEWORK AUTHOR: Oliver G.
| FRAMEWORK CONTACT EMAIL: Redbully14urh@gmail.com
|------------------------------------------------------------------------------------
|                           BASEXCS APPLICATION INFO
|------------------------------------------------------------------------------------
| 
| APPLICATION NAME: AntelopePHP
| APPLICATION AUTHOR: Oliver G.
| APPLICATION CONTACT EMAIL: Redbully14urh@gmail.com
| APPLICATION WEBSITE: /
| APPLICATION GITHUB: https://github.com/Redbully14/xcs-int
| APPLICATION SUBSIDIARIES: + AntelopePHP Base
|                           + 
|                           + 
|                           + 
| 
| CREATED FOR: Department of Justice Roleplay Community (www.dojrp.com)
| 
|-----------------------------------------------------------------------------------
|                           BASEXCS LICENSE INFO
|-----------------------------------------------------------------------------------
| 
|    MIT License
|
|    Copyright (c) 2020 XCS-int
|
|    Permission is hereby granted, free of charge, to any person obtaining a copy
|    of this software and associated documentation files (the "Software"), to deal
|    in the Software without restriction, including without limitation the rights
|    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
|    copies of the Software, and to permit persons to whom the Software is
|    furnished to do so, subject to the following conditions:
|
|    The above copyright notice and this permission notice shall be included in all
|    copies or substantial portions of the Software.
|
|    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
|    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
|    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
|    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
|    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
|    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
|    SOFTWARE.
|
*/

/*
|--------------------------------------------------------------------------
| Application Main Javascript File
|--------------------------------------------------------------------------
|
*/

var getURL = window.location;
const baseURL = getURL .protocol + "//" + getURL.host + "/" + getURL.pathname.split('/')[1];

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

/**
 * Creates a Toast on the top right of the page
 *
 * @author Oliver G.
 * @file app.js
 * @version 1.1.0
 */
globalToast = function(heading, text, icon, color) {
  'use strict';
  $.toast({
    heading: heading,
    text: text,
    showHideTransition: 'slide',
    icon: icon,
    loaderBg: color,
    position: 'top-right'
  })
};

/**
 * Basic select2 on the website
 *
 * @author Oliver G.
 * @file app.js
 * @version 1.1.0
 */  
(function($) {
  'use strict';

  if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2();
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2();
  }
})(jQuery);

/**
 * Bootstrap tooltip
 *
 * @author Oliver G.
 * @file app.js
 * @version 1.1.0
 */  
(function($) {
  'use strict';

  $(function() {
    /* Code for attribute data-custom-class for adding custom class to tooltip */
    if (typeof $.fn.tooltip.Constructor === 'undefined') {
      throw new Error('Bootstrap Tooltip must be included first!');
    }

    var Tooltip = $.fn.tooltip.Constructor;

    // add customClass option to Bootstrap Tooltip
    $.extend(Tooltip.Default, {
      customClass: ''
    });

    var _show = Tooltip.prototype.show;

    Tooltip.prototype.show = function() {

      // invoke parent method
      _show.apply(this, Array.prototype.slice.apply(arguments));

      if (this.config.customClass) {
        var tip = this.getTipElement();
        $(tip).addClass(this.config.customClass);
      }

    };
    $('[data-toggle="tooltip"]').tooltip();

  });
})(jQuery);

/**
 * Rating bar 1-5
 *
 * @author Oliver G.
 * @file app.js
 * @version 1.1.0
 */  
(function($) {
  'use strict';

  $(function() {
    function ratingEnable() {

      $('#antelope-square').barrating('show', {
        theme: 'bars-square',
        showValues: true,
        showSelectedRating: false
      });

    }

    function ratingDisable() {
      $('select').barrating('destroy');
    }

    $('.rating-enable').click(function(event) {
      event.preventDefault();

      ratingEnable();

      $(this).addClass('deactivated');
      $('.rating-disable').removeClass('deactivated');
    });

    $('.rating-disable').click(function(event) {
      event.preventDefault();

      ratingDisable();

      $(this).addClass('deactivated');
      $('.rating-enable').removeClass('deactivated');
    });

    ratingEnable();
  });

})(jQuery);

/**
 * Defining Webpage Elements
 *
 * @author Oliver G.
 * @file app.js
 * @version 1.1.0
 */  
$(".ajax_search_member-class").select2({
    placeholder: "Search by Website ID, Name or Unit Number",
    allowClear: true
});

$("#ajax_search_member-click_redirect").on("select2:select", function (e) {
  window.location.replace(e.params.data.id);
});

$(".antelope_global_select_single").select2({
    placeholder: "Select an Option...",
    allowClear: true
});

$(".antelope_global_select_single-noclear").select2({
    placeholder: "Select an Option...",
});

$(".antelope_global_select_single-noclear-nosearch").select2({
    placeholder: "Select an Option...",
    minimumResultsForSearch: -1,
});