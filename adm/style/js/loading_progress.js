/*!
 * Loading Progress Plugin
 * A plugin originally designed for phpBB extension Upload Extensions.
 * version: 1.1.0
 * Copyright (c) 2015 LavIgor
 * Licensed under GPL license version 2 (license.txt file).
 */
; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	$.upload_loading_interval = "";
	$.upload_loading_from = "left";

	$.fn.upload_loading_process = function() {
		$(".upload_loading_element").each(function () {
			var pos = $(this).css($.upload_loading_from);
			pos = pos.substr(0, pos.length - 2);
			if (parseFloat(pos) >= $("#upload_loading").width() + 30) $(this).remove();
			else if (parseFloat(pos) === 30) {
				$(this).css($.upload_loading_from, (parseFloat(pos) + 3) + "px");
				$("<div class=\"upload_loading_element\"></div>").css($.upload_loading_from, "-30px").appendTo("#upload_loading");
			} else $(this).css($.upload_loading_from, (parseFloat(pos) + 3) + "px");
		});
	};

	$.fn.upload_loading_start = function () {
		if ($("#upload_loading").css("display") !== "none") return;
		$.upload_loading_from = ($("body").hasClass("rtl")) ? "right" : "left";
		$("#upload_loading").slideDown(700);
		$("<div class=\"upload_loading_element\"></div>").css($.upload_loading_from, "-30px").appendTo("#upload_loading");
		$.upload_loading_interval = setInterval($.fn.upload_loading_process, 30);
	};

	$.fn.upload_loading_end = function() {
		$("#upload_loading").slideUp(700, function () {
			clearInterval($.upload_loading_interval);
			$("#upload_loading_status").html("");
			$(".upload_loading_element").each(function () {
				$(this).remove();
			});
		});
	};

	$.fn.upload_loading_progress = function(percentComplete) {
		$("#upload_loading_status").html(percentComplete + " %");
	};
})(jQuery, window, document);
