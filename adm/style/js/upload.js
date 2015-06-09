; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	$(".upload_details_link").click(function (event) {
		event.preventDefault();
		load_page("details", "boardtools/upload");
	});

	$(".upload_faq_link").click(function (event) {
		event.preventDefault();
		load_page("details", "boardtools/upload&ext_show=faq");
	});

	var loading_errors = false;

	// Detect the direction.
	// The RTL look is based upon swapping LTR style.
	var direction_rtl = $("body").hasClass("rtl"),
		direction_left = (direction_rtl) ? 'right' : 'left',
		direction_right = (direction_rtl) ? 'left' : 'right';

	/**
	 * The function that removes the marked rows of the form that triggered the callback.
	 */
	phpbb.addAjaxCallback('rows_delete', function (res) {
		if (res.SUCCESS !== false) {
			$("input[name='mark[]']:checkbox:checked").parents('tr').remove();
		}
	});

	// From ajax.js. We need to call this function after loading another page
	function add_ajax() {
		$('[data-ajax]').each(function () {
			var $this = $(this),
				ajax = $this.attr('data-ajax');

			if (ajax !== 'false') {
				var fn = (ajax !== 'true') ? ajax : null;
				phpbb.ajaxify({
					selector: this,
					refresh: $this.attr('data-refresh') !== undefined,
					callback: fn
				});
			}
		});
	}

	// Source: http://stackoverflow.com/a/4835406
	function escape_html(text) {
		var map = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#039;'
		};
		return text.replace(/[&<>"']/g, function (m) { return map[m]; });
	}

	function show_error_box(e, text, ee) {
		var error_status = e.status || e;
		if (text == "timeout" || ee == "timeout") {
			$("#upload_loading_timeout").css("display", "inline-block");
			$("#upload_loading_error_wrapper").slideDown(700);
		} else {
			if (typeof ee !== "undefined" && ee != "") {
				var $errorbox = $("#upload_loading_error_status");
				$errorbox.html(escape_html(error_status + " - " + ee));
				// Detect whether we need to show solutions.
				if (typeof e.status !== "undefined") {
					$("#upload_main").html('<div class="ext_solution_notice"><h1><i class="fa fa-lightbulb-o fa-fw"></i> ' + $errorbox.attr("data-load-error-solutions-title") + '</h1><span>' + $errorbox.attr("data-load-error-solutions") + '</span></div>');
					$("#upload_main_wrapper").stop().slideUp(100, function () {
						$("#upload_main_wrapper").attr("style", "display:none;").slideDown(700, "linear", function () {
							$("#upload_main_wrapper, #upload_main").removeClass("main_transformation");
						});
					});
				}
				$errorbox.css("display", "inline-block");
			}
			else $("#upload_loading_error").css("display", "inline-block");
			$("#upload_loading_error_wrapper").slideDown(700);
		}
		loading_errors = true;
	}

	function enable_result_success(element, attr_text) {
		if (element.parent(".upload_ext_list_content").length > 0) {
			element.parent(".upload_ext_list_content").addClass("upload_ext_update_success");
			var $wrapper = element.siblings(".upload_ext_list_update_success_wrapper");
			$wrapper.children(".upload_ext_list_update_success").html(
				$wrapper.attr(attr_text));
			$wrapper.stop().slideDown(700);
			setTimeout(function () {
				$wrapper.slideUp(700, function () {
					element.parent(".upload_ext_list_content").removeClass("upload_ext_update_success");
				});
			}, 3000);
		} else {
			element.parent().qtip({
				content: {
					text: function (event, api) {
						return $(this).attr(attr_text);
					}
				},
				style: {
					classes: 'qtip-green qtip-shadow qtip-rounded'
				},
				position: {
					my: direction_left + ' center',
					at: direction_right + ' center',
					viewport: true
				},
				show: {
					ready: true
				},
				hide: {
					event: 'click unfocus'
				},
				events: {
					hidden: function (event, api) {
						api.destroy(true);
					}
				}
			});
		}
	}

	function enable_result_error(element, text) {
		if (element.parent(".upload_ext_list_content").length > 0) {
			element.parent(".upload_ext_list_content").addClass("upload_ext_update_error");
			var $wrapper = element.siblings(".upload_ext_list_update_error_wrapper");
			$wrapper.children(".upload_ext_list_update_error").html(text);
			$wrapper.stop().slideDown(700);
			//setTimeout(function () {
			//	$wrapper.slideUp(700, function () {
			//		element.parent(".upload_ext_list_content").removeClass("upload_ext_update_error");
			//	});
			//}, 8000);
		} else {
			element.parent().qtip({
				content: {
					text: text
				},
				style: {
					classes: 'qtip-red qtip-shadow qtip-rounded'
				},
				position: {
					my: direction_left + ' center',
					at: direction_right + ' center',
					viewport: true
				},
				show: {
					ready: true
				},
				hide: {
					event: 'click unfocus'
				},
				events: {
					hidden: function (event, api) {
						api.destroy(true);
					}
				}
			});
		}
	}

	function get_enable_result(result, element) {
		element.removeClass("locked_toggle");
		var $data_wrapper = (element.parent(".upload_ext_list_content").length > 0) ? element.siblings(".upload_ext_list_update_error_wrapper") : element.parent(); // Detect the list/details page.
		if (typeof result.status !== "undefined") {
			switch (result.status) {
				case 'purged':
					element.addClass("extension_toggle_purged");
					enable_result_success(element, "data-ext-update-purged");
					break;
				case 'enabled':
					element.removeClass("extension_toggle_purged");
					element.toggleClass("extension_toggle_enabled extension_toggle_disabled");
					enable_result_success(element, "data-ext-update-enabled");
					break;
				case 'disabled':
					element.toggleClass("extension_toggle_enabled extension_toggle_disabled");
					enable_result_success(element, "data-ext-update-disabled");
					break;
				case 'error':
					enable_result_error(element, result.error);
					break;
				case 'load_error':
					if (result.error === "timeout" || result.message === "timeout")	{
						enable_result_error(element, $data_wrapper.attr("data-ext-update-timeout"));
					} else {
						var error_status = '';
						if (typeof result.message !== "undefined" && result.message != "") {
							var status_divider = (element.parent(".upload_ext_list_content").length > 0) ? ' ' : '<br />';
							error_status = status_divider + escape_html(result.code + " - " + result.message);
						}
						enable_result_error(element, $data_wrapper.attr("data-ext-update-error") + error_status);
					}
					break;
			}
		} else {
			enable_result_error(element, $data_wrapper.attr("data-ext-update-error"));
		}
	}

	function get_purge_result(result, element, hash) {
		var data = $('<form>' + result.S_HIDDEN_FIELDS + '</form>').serialize();
		$.ajax({
			url: result.S_CONFIRM_ACTION,
			type: 'POST',
			data: data + "&confirm=" + result.YES_VALUE + ((typeof hash !== "undefined") ? "&hash=" + hash : ""),
			error: function (e, text, ee) {
				get_enable_result({
					ext_name: element.parent().attr("data-ext-name"),
					status: 'load_error',
					error: text,
					code: e.status,
					message: ee
				}, element.siblings(".extension_toggle_wrapper"));
			},
			success: function (s, x) {
				if (typeof s.status !== "undefined" && s.status === "force_update") {
					if (typeof s.hash !== "undefined") {
						get_purge_result(result, element, s.hash); // Repeat the request.
					} else { // The hash is not specified - this is an error.
						get_enable_result({
							ext_name: element.parent().attr("data-ext-name"),
							status: 'load_error',
							error: '' // Display standard error message.
						}, element.siblings(".extension_toggle_wrapper"));
					}
				} else {
					get_enable_result(s, element.siblings(".extension_toggle_wrapper"));
				}
			},
			cache: false
		});
	}

	function get_purge_confirm(result, element) {
		if (typeof result.S_CONFIRM_ACTION !== "undefined" && result.YES_VALUE) {
			element.qtip('api').set('content.title', result.MESSAGE_TITLE);
			$("#ext_purge_confirm").children(".ext_update_ok").html(result.YES_VALUE).siblings(".ext_update_cancel").html(result.NO_VALUE).parent().show();
			$("#ext_purge_text").html(result.MESSAGE_TEXT);
			element.qtip('api').reposition();
			$("#ext_purge_confirm .ext_update_ok").bind("click", function (event) {
				element.siblings(".extension_toggle_wrapper").toggleClass("locked_toggle");
				element.qtip('api').destroy();
				get_purge_result(result, element);
			});
			$("#ext_purge_confirm .ext_update_cancel").bind("click", function (event) {
				element.qtip('api').destroy();
			});
		} else {
			element.qtip('api').destroy();
			get_enable_result({
				ext_name: element.parent().attr("data-ext-name"),
				status: 'load_error',
				error: result.error,
				code: result.code,
				message: result.message
			}, element.siblings(".extension_toggle_wrapper"));
		}
	}

	function add_enable_toggle() {
		$("#upload_main .extension_toggle_wrapper").bind("click", function (event) {
			event.preventDefault();
			event.stopPropagation();
			$(".extension_toggle_wrapper[data-hasqtip], [data-ext-name][data-hasqtip]").qtip('destroy');
			if ($(this).hasClass("locked_toggle")) {
				return;
			}
			var process = ($(this).hasClass("extension_toggle_enabled")) ? "disable" : "enable";
			if ($(this).parent(".upload_ext_list_content").hasClass("upload_ext_update_error"))
			{
				$(this).siblings(".upload_ext_list_update_error_wrapper").slideUp(300, function () {
					$(this).parent(".upload_ext_list_content").removeClass("upload_ext_update_error");
				});
			}
			$(this).toggleClass("locked_toggle");
			load_page(process, $(this).parent().attr("data-ext-name"), get_enable_result, $(this));
		});
		/*$("#ext_purge_confirm").bind("click", function (event) {
			event.preventDefault();
			event.stopPropagation();
			if ($(this).siblings(".extension_toggle_wrapper").hasClass("locked_toggle")) {
				return;
			}
			$(this).siblings(".extension_toggle_wrapper").toggleClass("locked_toggle");
			load_page("purge", $(this).parent().attr("data-ext-name"), get_enable_result, $(this).siblings(".extension_toggle_wrapper"));
		});*/
		$(".extension_remove_data_button").bind("click", function (event) {
			event.preventDefault();
			event.stopPropagation();
			$(".extension_toggle_wrapper[data-hasqtip], [data-ext-name][data-hasqtip]").qtip('destroy');
			if ($(this).siblings(".extension_toggle_wrapper").hasClass("locked_toggle")) {
				return;
			}
			$(this).qtip({
				content: {
					text: function (event, api) {
						load_page('purge', $(this).parent().attr("data-ext-name"), get_purge_confirm, $(this));
						return "<div id='ext_purge_text'><i class=\"fa fa-spinner fa-3x fa-spin loading_spinner\"></i></div><div id='ext_purge_confirm'><span class='ext_update_ok'></span><span class='ext_update_cancel'></span></div>";
					},
					title: function (event, api) {
						//return $(this).attr("title");
						return $("#upload_loading_text").html();
					}
				},
				style: {
					classes: 'qtip-light qtip-shadow qtip-rounded'
				},
				position: {
					my: direction_left + ' center',
					at: direction_right + ' center',
					viewport: true
				},
				show: {
					modal: {
						on: true
					},
					ready: true
				},
				hide: {
					event: false
				},
				events: {
					hidden: function (event, api) {
						api.destroy(true);
					}
				}
			});
		});
	}

	function add_enable_tip() {
		$("#upload_main").one("loaded", function (event) {
			$(".extension_toggle_wrapper").qtip({
				content: {
					text: function (event, api) {
						return $(this).parent().attr("data-ext-update-enable");
					}
				},
				style: {
					classes: 'qtip-blue qtip-shadow qtip-rounded'
				},
				position: {
					my: 'bottom center',
					at: 'top center',
					viewport: true
				},
				show: {
					ready: true
				},
				hide: {
					event: 'unfocus'
				},
				events: {
					hidden: function (event, api) {
						api.destroy(true);
					}
				}
			});
			$("#ext_details_filetree_tab").qtip({
				content: {
					text: function (event, api) {
						return $(".extension_toggle_wrapper").parent().attr("data-ext-update-check-filetree");
					}
				},
				style: {
					classes: 'qtip-yellow qtip-shadow qtip-rounded'
				},
				position: {
					my: 'top center',
					at: 'bottom center',
					viewport: true
				},
				show: {
					ready: true
				},
				hide: {
					event: 'unfocus'
				},
				events: {
					hidden: function (event, api) {
						api.destroy(true);
					}
				}
			});
		});
		function hide_uploaded_message() {
			$(".ext_uploaded_notice, .ext_updated_notice").slideUp(500);
			$(".extension_toggle_wrapper").unbind("click", hide_uploaded_message);
		}
		$(".extension_toggle_wrapper").bind("click", hide_uploaded_message);
	}

	function get_versioncheck_result(result, element) {
		if (typeof result.status !== "undefined" && result.status === "success") {
			switch (result.versioncheck)
			{
				case "up_to_date":
					$().upload_loading_end();
					$("#meta_version").addClass("description_value_ok").attr("title", result.message);
					break;
				case "not_up_to_date":
					// Reload the details page to show an update button (if needed).
					load_page("details", $("h1.ExtensionName span").attr("data-ext-name"));
					break;
				case "error_timeout":
				case "error":
					$().upload_loading_end();
					var $error_box = $("#ext_versioncheck_error_box");
					$error_box.stop().slideUp(100, function () {
						if (result.versioncheck === "error_timeout") $error_box.children(".ext_versioncheck_error_box_title, .ext_versioncheck_error_box_link").show();
						else $error_box.children(".ext_versioncheck_error_box_title, .ext_versioncheck_error_box_link").hide();
						$error_box.children(".ext_versioncheck_error_box_reason").html(result.reason);
						$error_box.slideDown(700);
					});
					break;
			}
		}
		else {
			$().upload_loading_end();
			show_error_box(result.code, result.error, result.message);
		}
	}

	function load_main_page() {
		/* For noscript compatibility we do it here instead of css file */
		$("#extupload").css("display", "none");
		$("#button_upload").css("display", "inline-block");

		$("#valid_phpbb_ext").bind('change keyup', function () {
			$("#remote_upload").val($(this).val());
		});

		$("#submit, .unpack_zip").click(function () {
			$("#ext_upload_content").css("display", "none");
			$("#upload").css("display", "block");
		});

		$("#load_valid_phpbb_extensions").click(function (event) {
			event.preventDefault();
			load_page("list_from_cdb");
		});

		$(".upload_valid_ext_download_link").click(function (event) {
			event.preventDefault();
			$("#valid_phpbb_ext").attr("value", $(this).attr("data-ext-source"));
			load_page("upload");
		});
	}

	function load_details_page() {
		setFileTree();
		add_enable_toggle();
		if ($("#description_updates").length > 0) {
			$(".ext_version_bubble .show_ext_updates").css("display", "inline-block").qtip({
				content: {
					text: $("#description_updates")
				},
				style: {
					classes: 'qtip-light qtip-shadow qtip-rounded',
					tip: {
						corner: true,
						mimic: 'center',
						width: 10,
						height: 10
					}
				},
				position: {
					at: 'bottom center',
					my: 'top ' + direction_right,
					adjust: {
						x: (direction_rtl) ? -15 : 15
					}
				},
				show: {
					event: 'click',
					effect: function (offset) {
						$(this).fadeIn(500); // "this" refers to the tooltip
					}
				},
				hide: {
					event: 'click unfocus',
					effect: function (offset) {
						$(this).fadeOut(500); // "this" refers to the tooltip
					}
				}
			});
			$(".extension_update_link").bind("click", function () {
				$(".ext_version_bubble .show_ext_updates").qtip().hide();
			}).qtip({
				content: {
					text: $("#update_ext_confirm"),
					title: $("#update_ext_confirm_title")
				},
				style: {
					classes: 'qtip-light qtip-shadow qtip-rounded'
				},
				position: {
					my: direction_right + ' center',
					at: direction_left + ' center',
					target: $(".ext_version_bubble")
				},
				show: {
					modal: {
						on: true
					},
					event: 'click',
					effect: function (offset) {
						$(this).fadeIn(500); // "this" refers to the tooltip
					}
				},
				hide: {
					event: 'unfocus',
					effect: function (offset) {
						$(this).fadeOut(500); // "this" refers to the tooltip
					}
				}
			});
			$("#upload_main").one("loading", function () {
				$(".extension_update_link").qtip('hide').qtip('destroy', true);
				$(".show_ext_updates[data-hasqtip]").qtip('hide').qtip('destroy', true);
			})
		}
		/* Responsive tabs */
		$("#upload_main").find('.ext_details_tabs').not('[data-skip-responsive]').each(function () {
			var $this = $(this),
				$body = $("#upload_main"),
				ul = $this.children(),
				tabs = ul.children().not('[data-skip-responsive]'),
				links = tabs.children('a'),
				maxHeight = 29,
				lastWidth = false,
				responsive = false;

			links.each(function () {
				var link = $(this);
				link.attr("data-link-image", link.children("i").attr("class"));
				link.attr("data-link-name", link.children("span").html());
				//maxHeight = Math.max(maxHeight, Math.max(link.outerHeight(true), link.parent().outerHeight(true)));
			});

			function check() {
				var width = $body.width(),
					height = $this.height();

				if (arguments.length == 0 && (!responsive || width <= lastWidth) && height <= maxHeight) {
					return;
				}

				links.each(function () {
					var link = $(this);
					link.attr("title", "");
					link.html('<i class="' + link.attr("data-link-image") + '"></i> <span>' + link.attr("data-link-name") + '</span>');
				});

				lastWidth = width;
				height = $this.height();
				if (height <= maxHeight) {
					responsive = false;
					return;
				}

				responsive = true;

				var availableTabs = tabs.filter(':not(.activetab, .responsive-tab)'),
					total = availableTabs.length,
					i, tab;

				for (i = total - 1; i >= 0; i--) {
					tab = availableTabs.eq(i);
					var link = tab.children('a');
					link.attr("title", link.attr("data-link-name"));
					link.html('<i class="' + link.attr("data-link-image") + '"></i>');
					if ($this.height() <= maxHeight) return;
				}
				// If the space is really short.
				tab = tabs.filter('.activetab');
				var link = tab.children('a');
				link.attr("title", link.attr("data-link-name"));
				link.html('<i class="' + link.attr("data-link-image") + '"></i>');
			}

			check(true);
			$(window).resize(check);
			$("#upload_main").one("loaded", check);
			$this.on("tab_changed", check);
		});
		$(".ext_details_tabs .tab").click(function (event) {
			var current_tab = $(this),
				details_block = $(".ext_details_block");
			event.preventDefault();
			details_block.finish();
			details_block.parent().stop().css("height", details_block.parent().height() + "px");
			details_block.slideUp(700, function () {
				$(".ext_details_tabs .activetab").toggleClass("activetab");
				switch (current_tab.attr("id")) {
					case 'ext_details_main_tab':
						$(".ext_details_markdown, #ext_details_faq, #filetree, #ext_details_tools").css("display", "none");
						$("#ext_details_content").css("display", "block");
						break;
					case 'ext_details_readme_tab':
						$("#filetree, .ext_details_markdown, #ext_details_faq, #ext_details_content, #ext_details_tools").css("display", "none");
						$("#ext_details_readme").css("display", "block");
						break;
					case 'ext_details_changelog_tab':
						$("#filetree, .ext_details_markdown, #ext_details_faq, #ext_details_content, #ext_details_tools").css("display", "none");
						$("#ext_details_changelog").css("display", "block");
						break;
					case 'ext_details_faq_tab':
						$("#filetree, .ext_details_markdown, #ext_details_content, #ext_details_tools").css("display", "none");
						$("#ext_details_faq").css("display", "block");
						break;
					case 'ext_details_filetree_tab':
						$(".ext_details_markdown, #ext_details_faq, #ext_details_content, #ext_details_tools").css("display", "none");
						$("#filetree").css("display", "block");
						break;
					case 'ext_details_tools_tab':
						$(".ext_details_markdown, #ext_details_faq, #filetree, #ext_details_content").css("display", "none");
						$("#ext_details_tools").css("display", "block");
						break;
				}
				current_tab.toggleClass("activetab");
				var restored = false;
				details_block.slideDown({
					duration: 700,
					progress: function (an, progress, ms) {
						if (!restored && details_block.height() >= details_block.parent().height()) {
							details_block.parent().css("height", "");
							restored = true;
						}
					},
					complete: function () {
						if (!restored) {
							details_block.parent().animate({
								height: details_block.parent().children(".ext_details_tabs").outerHeight() + details_block.outerHeight()
							}, 500, function () {
								details_block.parent().css("height", "");
							});
							restored = true;
						}
						// We do it here because the scrollbar can be not displayed when the tab is not shown.
						current_tab.parent().trigger("tab_changed");
					}
				});
			});
		});
		if ($("#ext_details_faq").length) {
			// Detect the request to load the FAQ tab.
			if ($("#ext_details_faq").attr("data-ext-show-faq") === "true") {
				$(".ext_details_tabs .activetab, #ext_details_faq_tab").toggleClass("activetab");
				$("#filetree, .ext_details_markdown, #ext_details_content, #ext_details_tools").css("display", "none");
				$("#ext_details_faq").css("display", "block");
			}
			$(".upload_ext_faq_answer").hide();
			var show_upload_ext_faq_element = function (event) {
				var $element = $(this);
				$(".upload_ext_faq_question").not(".grey_question").not(this).unbind("click").bind("click", show_upload_ext_faq_element).addClass("grey_question").next(".upload_ext_faq_answer").slideUp();
				$element.unbind("click", show_upload_ext_faq_element).removeClass("grey_question").next(".upload_ext_faq_answer").slideDown(function () {
					$element.bind("click", hide_upload_ext_faq_element);
				});
			},
			hide_upload_ext_faq_element = function (event) {
				var $element = $(this);
				$element.unbind("click", hide_upload_ext_faq_element).next(".upload_ext_faq_answer").slideUp(function () {
					$element.bind("click", show_upload_ext_faq_element);
				});
				$(".upload_ext_faq_question").not(this).removeClass("grey_question");
			};
			$(".upload_ext_faq_question").css("cursor", "pointer").bind("click", show_upload_ext_faq_element);
		}
		$(".ext_versioncheck_force_link").click(function (event) {
			event.preventDefault();
			$().upload_loading_start();
			close_error_wrapper();
			$("#ext_versioncheck_error_box").slideUp(700);
			$("#meta_version").removeClass("description_value_ok description_value_old").attr("title", "");
			load_page("versioncheck_force", $("h1.ExtensionName span").attr("data-ext-name"), get_versioncheck_result, $(this));
		});
	}

	function check_details_page() {
		if ($(".ext_details_block").length > 0) // Reload the details page if this was not an ajax request.
		{ // This is needed because filetree, readme and changelog are downloaded together if JavaScript is used.
			load_page("details", $("h1.ExtensionName span").attr("data-ext-name"));
		}
	}

	function get_force_unstable_result(result) {
		var data = $('<form>' + result.S_HIDDEN_FIELDS + '</form>').serialize();
		$.ajax({
			url: result.S_CONFIRM_ACTION,
			type: 'POST',
			data: data + "&confirm=" + result.YES_VALUE,
			error: function (e, text, ee) {
				$().upload_loading_end();
				show_error_box(e, text, ee);
			},
			success: function (s, x) {
				$().upload_loading_end();
				if (typeof s.status !== "undefined" && s.status === "success") {
					$("#force_unstable_updated").stop().slideDown(700);
					setTimeout(function () {
						$("#force_unstable_updated").slideUp(700);
					}, 3000);
				}
				else {
					$("#upload_loading_error").css("display", "inline-block");
					$("#upload_loading_error_wrapper").slideDown(700);
					loading_errors = true;
				}
			},
			cache: false
		});
	}

	function get_force_unstable_confirm(result, element) {
		if (typeof result.S_CONFIRM_ACTION !== "undefined" && result.YES_VALUE) {
			//element.qtip('api').set('content.title', result.MESSAGE_TITLE);
			$("#ext_force_unstable_confirm").children(".ext_update_ok").html(result.YES_VALUE).siblings(".ext_update_cancel").html(result.NO_VALUE).parent().show();
			$("#ext_force_unstable_text").html(result.MESSAGE_TEXT);
			element.qtip('api').reposition();
			$("#ext_force_unstable_confirm .ext_update_ok").bind("click", function (event) {
				$().upload_loading_start();
				close_error_wrapper();
				element.qtip('api').destroy();
				get_force_unstable_result(result);
			});
			$("#ext_force_unstable_confirm .ext_update_cancel").bind("click", function (event) {
				element.qtip('api').destroy();
			});
		} else if (typeof result.status !== "undefined" && result.status === "success") {
			$().upload_loading_end();
			$("#force_unstable_updated").stop().slideDown(700);
			setTimeout(function () {
				$("#force_unstable_updated").slideUp(700);
			}, 3000);
		} else {
			element.qtip('api').destroy();
			$().upload_loading_end();
			show_error_box(result.code, result.error, result.message);
		}
	}

	function add_set_force_unstable_toggle() {
		$("#set_force_unstable_link").click(function (event) {
			event.preventDefault();
			$("#version_check_settings").slideToggle(700);
		});
		$("#version_check_settings").bind("submit", function (event) {
			event.preventDefault();
			$("#version_check_settings").slideToggle(700);
			$(".extension_toggle_wrapper[data-hasqtip], [data-ext-name][data-hasqtip]").qtip('destroy');
			var force_unstable = ($("#force_unstable").is(":checked")) ? 1 : 0;
			if (force_unstable) {
				$(".upload_ext_list").qtip({
					content: {
						text: function (event, api) {
							load_page('set_config_force_unstable', force_unstable, get_force_unstable_confirm, $(this));
							return "<div id='ext_force_unstable_text'><i class=\"fa fa-spinner fa-3x fa-spin loading_spinner\"></i></div><div id='ext_force_unstable_confirm'><span class='ext_update_ok'></span><span class='ext_update_cancel'></span></div>";
						},
						title: function (event, api) {
							return $("#version_check_settings_title").html();
						}
					},
					style: {
						classes: 'qtip-light qtip-shadow qtip-rounded'
					},
					position: {
						my: 'bottom center',
						at: 'top center',
						viewport: true
					},
					show: {
						modal: {
							on: true
						},
						ready: true
					},
					hide: {
						event: false
					},
					events: {
						hidden: function (event, api) {
							api.destroy(true);
						}
					}
				});
			}
			else {
				$().upload_loading_start();
				close_error_wrapper();
				load_page('set_config_force_unstable', force_unstable, get_force_unstable_confirm, $(this));
			}
		});
	}

	function load_zip_packages_page() {
		$(".unpack_zip").click(function (event) {
			event.preventDefault();
			load_page("local_upload", $(this).attr("href"));
		});
		$("#upload_pagination li a").click(function (event) {
			event.preventDefault();
			load_page("zip_packages", $(this).attr("href"));
		});
	}

	$("#upload_main_wrapper").css("overflow", "hidden");

	function check_response(res) {
		if (typeof res.FORCE_UPDATE !== "undefined") {
			load_page("force_update");
			return false;
		} else if (typeof res !== "object" && res.trim() === '') {
			// Blank page is an error.
			$().upload_loading_end();
			$("#upload_loading_error").css("display", "inline-block");
			$("#upload_loading_error_wrapper").slideDown(700);
			loading_errors = true;
			return false;
		} else if (res.substr(0, 9) == "<!DOCTYPE") {
			// Reload the page after logout.
			window.location.href = $("#upload_main").attr("data-page-action");
		}
		return true;
	}

	function close_error_wrapper() {
		if (loading_errors)
		{
			$("#upload_loading_error_wrapper").slideUp(700, function () {
				$("#upload_loading_error, #upload_loading_timeout, #upload_loading_error_status").css("display", "none");
			});
			loading_errors = false;
		}
	}

	function load_page(action, id, local, element) {
		if (typeof (local) === "undefined") {
			$().upload_loading_start();
			close_error_wrapper();
			$("#upload_main_wrapper, #upload_main").addClass("main_transformation");
			$("#upload_main_wrapper").slideUp(700, load_page_process(action, id, local, element));
		} else {
			load_page_process(action, id, local, element);
		}
	}

	function load_page_process(action, id, local, element) {
		var getExtension = ["details", "enable", "disable", "purge", "versioncheck_force"];
		var page_url = $("#upload_main").attr("data-page-action"), data = {}, method = 'GET';
		function page_loaded($this, s)
		{
			$("#upload_main_wrapper").stop().slideUp(100, function () {
				$this.html(s);
				parse_document($("#upload_main_wrapper"));
				add_ajax();
				bind_load_events(action);
				$().upload_loading_end();
				$("#upload_main_wrapper").attr("style", "display:none;").slideDown(700, "linear", function () {
					$("#upload_main_wrapper, #upload_main").removeClass("main_transformation");
					$("#upload_main").trigger("loaded");
				});
			});
		}
		function generate_get_request() {
			if ($.inArray(action, getExtension) > -1) return "&ext_name=" + id;
			switch (action) {
				case "local_upload": return "&local_upload=" + id;
				case "set_config_force_unstable": return "&force_unstable=" + id;
				case "list": return (typeof id !== "undefined" && id === "versioncheck_force") ? "&versioncheck_force=1" : "";
			}
			return "";
		}
		if (action === "upload" || action === "upload_update") {
			var $this = (action === "upload") ? $("#ext_upload") : $("#upload_ext_update");
			action = "upload"; // The common action for the server.
			data = $this.serializeArray();
			method = $this.attr('method') || 'GET';
			$this.ajaxSubmit({
				url: page_url + "&ajax_action=" + action, // window.location.href
				target: $("#upload_main"),
				uploadProgress: function (e, pos, total, percentComplete) {
					if (percentComplete) {
						$().upload_loading_progress(percentComplete);
					}
				},
				error: function (e, text, ee) {
					$().upload_loading_end();
					show_error_box(e, text, ee);
				},
				success: function (s, x) {
					if (check_response(s)) {
						page_loaded($(this), s);
					}
				}
			});
		}
		else $.ajax({
			url: ((action === "zip_packages" && typeof id !== "undefined") ? id : page_url) + "&ajax_action=" + action + generate_get_request(),
			context: $("#upload_main"),
			/*xhrFields: {
				onprogress: function (e) {
					if (e.lengthComputable) {
						var percentComplete = ((e.position || e.loaded) * 100 / (e.totalSize || e.total)).toFixed();
						$("#upload_loading_status").html(percentComplete + " %");
					}
				}
			},*/
			error: function (e, text, ee) {
				if (typeof local !== "undefined") {
					local({
						ext_name: id,
						status: 'load_error',
						error: text,
						code: e.status,
						message: ee
					}, element);
					return;
				}
				$().upload_loading_end();
				show_error_box(e, text, ee);
			},
			success: function (s, x) {
				if (typeof local !== "undefined") {
					if (typeof s.status !== "undefined" && s.status === "force_update") {
						load_page_process(action, id, local, element); // Repeat the request.
					} else {
						local(s, element);
					}
					return;
				}
				if (check_response(s)) {
					page_loaded($(this), s);
				}
			},
			cache: false
		});
		$("#upload_main").trigger("loading");
	}

	// Bind load_page events
	function bind_load_events(action) {
		$(".upload_load_zip").click(function (event) {
			event.preventDefault();
			load_page("zip_packages");
		});

		$(".upload_load_uninstalled").click(function (event) {
			event.preventDefault();
			load_page("uninstalled");
		});

		$(".upload_load_list").click(function (event) {
			event.preventDefault();
			load_page("list");
		});

		$("#upload_load_main").click(function (event) {
			event.preventDefault();
			load_page("main");
		});

		$("#upload_load_main_list").click(function (event) {
			event.preventDefault();
			load_page("list");
		});

		$("#versioncheck_force_update_all").click(function (event) {
			event.preventDefault();
			load_page("list", "versioncheck_force");
		});

		$("#ext_upload").submit(function (event) {
			event.preventDefault();
			load_page("upload");
		});

		$("#upload_ext_update").submit(function (event) {
			event.preventDefault();
			load_page("upload_update");
		});

		$(".upload_get_details_link").click(function (event) {
			event.preventDefault();
			load_page("details", $(this).attr("data-ext-name"));
		});

		switch (action)
		{
			case "list_from_cdb":
			case "main":
				load_main_page();
				break;
			case "upload":
			case "local_upload":
			case "force_update":
				add_enable_tip();
			case "details":
				load_details_page();
				break;
			case "list":
				add_enable_toggle();
				add_set_force_unstable_toggle();
				break;
			case "zip_packages":
				load_zip_packages_page();
				break;
		}
	}
	$("#upload_extensions_title").click(function (event) {
		event.preventDefault();
		load_page("main");
	});
	$("#upload_extensions_links_show_slider").click(function () {
		$("#upload_extensions_title_links").css("margin-" + direction_left, ($("#upload_extensions_title_links").css("margin-" + direction_left) == "-100px") ? "-15px" : "");
	});
	load_main_page();
	bind_load_events();
	load_details_page();
	add_set_force_unstable_toggle();
	load_zip_packages_page();
	check_details_page();
})(jQuery, window, document);

function browseFile()
{
	document.getElementById('extupload').click();
}

function setFileName()
{
	document.getElementById('remote_upload').value = document.getElementById("extupload").files[0].name;
}

function loadXMLDoc(event, url)
{
	; (function ($, window, document) {
		// do stuff here and use $, window and document safely
		// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
		event.preventDefault();
		$("#filecontent_wrapper").fadeOut(500, function () {
			$("#filecontent").load(url, function () {
				$("#filecontent_wrapper").fadeIn(500);
			});
		});
	})(jQuery, window, document);
}
