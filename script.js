jQuery(document).ready(function($) {
	$("form#evanesco button").bind("click", function() {
		var id = "#" + $(this).attr("id") + "-input";

		if ($(this).hasClass("hide")) {
			$(this).removeClass("hide");
			$(id).val("show");
		} else {
			$(this).addClass("hide");
			$(id).val("hide");
		}
		
	});
});