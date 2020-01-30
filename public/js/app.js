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