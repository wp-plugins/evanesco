jQuery(document).ready(function($){$("form#form-evanesco button").bind("click",function(){var i="#"+$(this).attr("id")+"-input";$(this).hasClass("hide")?($(this).removeClass("hide"),$(i).val("show")):($(this).addClass("hide"),$(i).val("hide"))})});