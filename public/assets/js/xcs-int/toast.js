(function($) {
  addedMemberToast = function() {
    'use strict';
    resetToastPosition();
    $.toast({
      heading: 'New Member Added',
      text: 'A new member has been added to Antelope, please provide them with the selected password and username.',
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: '#f96868',
      position: 'top-right'
    })
  };
  resetToastPosition = function() {
    $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
    $(".jq-toast-wrap").css({
      "top": "",
      "left": "",
      "bottom": "",
      "right": ""
    }); //to remove previous position style
  }
})(jQuery);