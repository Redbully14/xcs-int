function clearAllNotifications() {
	$.ajax({
	  type: 'POST',
	  url: $url_clear_notifications,
	  success: function(data) {
	    $("#notificationAlert").hide();
	  },
	  error: function() {
	    var toast_heading = "You broke it!";
	    var toast_text = "idk what you did but you broke it.";
	    var toast_icon = "error";
	    var toast_color = "#f2a654";
	    globalToast(toast_heading, toast_text, toast_icon, toast_color);
	  }
	});
}