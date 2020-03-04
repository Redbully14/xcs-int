var getURL = window.location;
const baseURL = getURL .protocol + "//" + getURL.host + "/" + getURL.pathname.split('/')[1];

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

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
  
(function($) {
  'use strict';

  if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2();
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2();
  }
})(jQuery);

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