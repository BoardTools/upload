;var upload_ext = {};

(function($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	/*****************
	 * Helper object *
	 *****************/
	// Main elements
	upload_ext.elem = {};
	upload_ext.elem.main = $("#upload_main");
	upload_ext.elem.modal = $("#upload_modal_box");
	upload_ext.elem.modal_wrapper = $("#upload_modal_box_wrapper");
	upload_ext.elem.wrapper = $("#upload_main_wrapper");

	// Global functions
	upload_ext.fn = {};
	upload_ext.fn.main_attr = function(attr) {
		return upload_ext.elem.main.attr(attr);
	};

	/*********************
	 * General functions *
	 *********************/
	$(".upload_details_link").click(function(event) {
		event.preventDefault();
		load_page("details", "boardtools/upload");
	});

	$(".upload_faq_link").click(function(event) {
		event.preventDefault();
		load_page("faq");
	});

	$("#upload_extensions_title").click(function(event) {
		event.preventDefault();
		load_page("main");
	});

	$("#upload_extensions_links_show_slider").click(function() {
		var $title_links = $("#upload_extensions_title_links");
		$title_links.css("margin-" + direction_left, ($title_links.css("margin-" + direction_left) == "-100px") ? "-15px" : "");
	});

	upload_ext.elem.wrapper.css("overflow", "hidden");
	upload_ext.elem.modal.click(function(e) {
		e.stopPropagation();
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
	phpbb.addAjaxCallback('rows_delete', function(res) {
		if (res.SUCCESS !== false) {
			$("input[name='mark[]']:checkbox:checked").parents('tr').remove();
		}
	});

	/**
	 * The function that removes the marked rows of the language packages form that triggered the callback.
	 */
	phpbb.addAjaxCallback('language_rows_delete', function(res) {
		if (res.SUCCESS !== false) {
			$("input[name='mark[]']:checkbox:checked").parents('.ext_language_row').remove();
		}
	});

	// From ajax.js. We need to call this function after loading another page
	function add_ajax() {
		$('[data-ajax]').each(function() {
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
		return text.replace(/[&<>"']/g, function(m) {
			return map[m];
		});
	}

	/**
	 * http://stackoverflow.com/a/4373037
	 * http://www.davekoelle.com/alphanum.html
	 * @copyright (C) Brian Huisman, based on the Alphanum Algorithm by David Koelle
	 * @license LGPL-2.1+
	 * @param caseInsensitive
	 */
	Array.prototype.alphanumSort = function(caseInsensitive) {
		for (var z = 0, t; t = this[z]; z++) {
			this[z] = [];
			var x = 0, y = -1, n = 0, i, j;

			while (i = (j = t.charAt(x++)).charCodeAt(0)) {
				var m = (i == 46 || (i >=48 && i <= 57));
				if (m !== n) {
					this[z][++y] = "";
					n = m;
				}
				this[z][y] += j;
			}
		}

		this.sort(function(a, b) {
			for (var x = 0, aa, bb; (aa = a[x]) && (bb = b[x]); x++) {
				if (caseInsensitive) {
					aa = aa.toLowerCase();
					bb = bb.toLowerCase();
				}
				if (aa !== bb) {
					var c = Number(aa), d = Number(bb);
					if (c == aa && d == bb) {
						return c - d;
					} else {
						return (aa > bb) ? 1 : -1;
					}
				}
			}
			return a.length - b.length;
		});

		for (var z = 0; z < this.length; z++) {
			this[z] = this[z].join("");
		}
	};

	function show_error_box(e, text, ee) {
		var error_status = e.status || e;
		prepare_error_wrapper();
		if (text == "timeout" || ee == "timeout") {
			$("#upload_loading_timeout").css("display", "inline-block");
		} else {
			if (typeof ee !== "undefined" && ee != "") {
				var $errorbox = $("#upload_loading_error_status");
				$errorbox.html(escape_html(error_status + " - " + ee));
				// Detect whether we need to show solutions.
				if (typeof e.status !== "undefined") {
					upload_ext.elem.main.html('<div class="ext_solution_notice"><h1><i class="fa fa-lightbulb-o fa-fw"></i> ' + $errorbox.attr("data-load-error-solutions-title") + '</h1><span>' + $errorbox.attr("data-load-error-solutions") + '</span></div>');
					upload_ext.elem.wrapper.stop().slideUp(100, function() {
						upload_ext.elem.wrapper.attr("style", "display:none;").slideDown(700, "linear", function() {
							$("#upload_main_wrapper, #upload_main").removeClass("main_transformation");
						});
					});
				}
				$errorbox.css("display", "inline-block");
			} else {
				$("#upload_loading_error").css("display", "inline-block");
			}
		}
		$("#upload_loading_error_wrapper").slideDown(700);
		loading_errors = true;
	}

	function show_refresh_notice() {
		$("#upload_refresh_notice_wrapper").show();
		$("#upload_refresh_notice").slideDown(500, function() {
			$("[data-hasqtip]").each(function() {
				$(this).qtip('api').reposition();
			});
		});
	}

	$("#upload_refresh_notice_wrapper").prependTo("body");
	$(".page_refresh_link").click(function(e) {
		e.preventDefault();
		window.location.reload();
	});
	$(".upload_refresh_notice_close").click(function() {
		$("#upload_refresh_notice").slideUp(500, function() {
			$("#upload_refresh_notice_wrapper").hide();
		});
	});

	function enable_result_success(element, attr_text) {
		if (element.parent(".upload_ext_list_content").length > 0) {
			element.parent(".upload_ext_list_content").addClass("upload_ext_update_success");
			var $wrapper = element.siblings(".upload_ext_list_update_success_wrapper");
			$wrapper.children(".upload_ext_list_update_success").html(
				$wrapper.attr(attr_text));
			$wrapper.stop().slideDown(700);
			setTimeout(function() {
				$wrapper.slideUp(700, function() {
					element.parent(".upload_ext_list_content").removeClass("upload_ext_update_success");
				});
			}, 3000);
		} else {
			element.parent().qtip({
				content: {
					text: function(event, api) {
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
					hidden: function(event, api) {
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
					hidden: function(event, api) {
						api.destroy(true);
					}
				}
			});
		}
	}

	function get_enable_result(result, element) {
		element.removeClass("locked_toggle");
		var isListPage = element.parent(".upload_ext_list_content").length > 0,
			$data_wrapper = (isListPage) ? element.siblings(".upload_ext_list_update_error_wrapper") : element.parent(); // Detect the list/details page.
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
					if (result.error === "timeout" || result.message === "timeout") {
						enable_result_error(element, $data_wrapper.attr("data-ext-update-timeout"));
					} else {
						var error_status = '';
						if (typeof result.message !== "undefined" && result.message != "") {
							var status_divider = (isListPage) ? ' ' : '<br />';
							error_status = status_divider + escape_html(result.code + " - " + result.message);
						}
						enable_result_error(element, $data_wrapper.attr("data-ext-update-error") + error_status);
					}
					break;
			}
			if (result.refresh) {
				show_refresh_notice();
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
			error: function(e, text, ee) {
				get_enable_result({
					ext_name: element.parent().attr("data-ext-name"),
					status: 'load_error',
					error: text,
					code: e.status,
					message: ee
				}, element.siblings(".extension_toggle_wrapper"));
			},
			success: function(s, x) {
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
			$("#ext_purge_confirm .ext_update_ok").bind("click", function(event) {
				element.siblings(".extension_toggle_wrapper").toggleClass("locked_toggle");
				element.qtip('api').destroy();
				get_purge_result(result, element);
			});
			$("#ext_purge_confirm .ext_update_cancel").bind("click", function(event) {
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
		$("#upload_main .extension_toggle_wrapper").bind("click", function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(".extension_toggle_wrapper[data-hasqtip], [data-ext-name][data-hasqtip]").qtip('destroy');
			if ($(this).hasClass("locked_toggle")) {
				return;
			}
			var process = ($(this).hasClass("extension_toggle_enabled")) ? "disable" : "enable";
			if ($(this).parent(".upload_ext_list_content").hasClass("upload_ext_update_error")) {
				$(this).siblings(".upload_ext_list_update_error_wrapper").slideUp(300, function() {
					$(this).parent(".upload_ext_list_content").removeClass("upload_ext_update_error");
				});
			}
			$(this).toggleClass("locked_toggle");
			load_page(process, $(this).parent().attr("data-ext-name"), get_enable_result, $(this));
		});
		$(".extension_remove_data_button").bind("click", function(event) {
			event.preventDefault();
			event.stopPropagation();
			$(".extension_toggle_wrapper[data-hasqtip], [data-ext-name][data-hasqtip]").qtip('destroy');
			if ($(this).siblings(".extension_toggle_wrapper").hasClass("locked_toggle")) {
				return;
			}
			$(this).qtip({
				content: {
					text: function(event, api) {
						load_page('purge', $(this).parent().attr("data-ext-name"), get_purge_confirm, $(this));
						return "<div id='ext_purge_text'><i class=\"fa fa-spinner fa-3x fa-spin loading_spinner\"></i></div><div id='ext_purge_confirm'><span class='ext_update_ok'></span><span class='ext_update_cancel'></span></div>";
					},
					title: function(event, api) {
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
					hidden: function(event, api) {
						api.destroy(true);
					}
				}
			});
		});
	}

	function add_enable_tip() {
		upload_ext.elem.main.one("loaded", function(event) {
			$(".extension_toggle_wrapper").qtip({
				content: {
					text: function(event, api) {
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
					hidden: function(event, api) {
						api.destroy(true);
					}
				}
			});
			$("#ext_details_filetree_tab").qtip({
				content: {
					text: function(event, api) {
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
					hidden: function(event, api) {
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

	function add_language_tip() {
		upload_ext.elem.main.one("loaded", function(event) {
			$("#ext_details_filetree_tab").qtip({
				content: {
					text: function(event, api) {
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
					hidden: function(event, api) {
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

	var $modalDataContainer = false;

	function restore_modal_data_container() {
		var $modal = upload_ext.elem.modal;
		if ($modalDataContainer) {
			$modal.find(".alert_close").remove();
			$modalDataContainer.html($modal.contents());
			$modalDataContainer = false;
		}
	}

	function show_modal_box(content, bigModalBox, dataContainer) {
		var $modalBox = upload_ext.elem.modal_wrapper, $modal = upload_ext.elem.modal;
		restore_modal_data_container();
		phpbb.clearLoadingTimeout();
		$(document).on('keydown.phpbb.alert', function(e) {
			if (e.keyCode === 13 || e.keyCode === 27) {
				phpbb.alert.close($modalBox, true);
				e.preventDefault();
				e.stopPropagation();
			}
		});
		$modalBox.one('click', function(e) {
			phpbb.alert.close($modalBox, true);
			e.preventDefault();
			e.stopPropagation();
		});
		$modal.html(content);
		$modal.removeClass("big_modal_box huge_modal_box");
		if (bigModalBox === 2) {
			$modal.addClass("huge_modal_box");
		} else if (bigModalBox) {
			$modal.addClass("big_modal_box");
		}
		if (dataContainer) {
			$modalDataContainer = dataContainer;
		}
		$modal.prepend('<a href="#" class="alert_close">&times;</a>');
		phpbb.alert.open($modalBox);
	}

	function hide_modal_box() {
		var $modalBox = upload_ext.elem.modal_wrapper;
		phpbb.alert.close($modalBox, true);
		restore_modal_data_container();
	}

	function show_error_modal_box(error) {
		if (error.substr(0, 9) == "<!DOCTYPE") {
			var $frame = $('<iframe id="error_frame">');
			$(".upload_ext_error_show").off("click").click(function() {
				show_modal_box($frame, 2);
				$frame[0].contentWindow.document.open();
				$frame[0].contentWindow.document.write(error);
				$($frame[0].contentWindow.document).find("a").click(function(e) {
					$(this).attr("target", "_blank");
				});
				$frame[0].contentWindow.document.close();
			}).show();
		} else {
			$(".upload_ext_error_show").off("click").click(function() {
				show_modal_box(error);
			}).show();
		}
		upload_ext.elem.main.one("loading", function() {
			$(".upload_ext_error_show").hide();
		});
	}

	function prepare_error_wrapper() {
		$("#upload_loading_error_wrapper").finish();
		$("#upload_loading_error, #upload_loading_timeout, #upload_loading_error_status").css("display", "none");
	}

	function close_error_wrapper() {
		if (loading_errors) {
			$("#upload_loading_error_wrapper").slideUp(700);
			loading_errors = false;
		}
	}

	function set_ext_requirement($extRow, $requirementRow, $requireType) {
		if ($extRow.attr('data-ext-require-' + $requireType + '-status') == "1") {
			$requirementRow.removeClass("requirements_value_not_met");
		} else {
			$requirementRow.addClass("requirements_value_not_met");
		}
		$requirementRow.text($extRow.attr('data-ext-require-' + $requireType) || $('#upload_valid_ext_description').attr("data-not-available"));
	}

	function display_ext_description($extRow) {
		var $extDescContainer = $('#upload_valid_ext_description');
		$extDescContainer
			.find('.ext_details_name')
				.text($extRow.find('.upload_valid_ext_name').text())
			.end()
			.find('.ext_details_version')
				.text($extRow.find('.upload_valid_ext_version').text())
			.end()
			.find('.ext_details_description')
				.text($extRow.attr('data-ext-description') || $extDescContainer.attr("data-not-available"))
			.end()
			.find('.ext_details_actions')
				.html($extRow.find('a').clone())
			.end();
		set_ext_requirement($extRow, $extDescContainer.find('.ext_details_require_phpbb'), 'phpbb');
		set_ext_requirement($extRow, $extDescContainer.find('.ext_details_require_php'), 'php');
		show_modal_box($extDescContainer.html());
		upload_ext.elem.modal.find('.upload_valid_ext_download_link').click(function(event) {
			event.preventDefault();
			$extRow.find('.upload_valid_ext_download_link').click();
			hide_modal_box();
		});
	}

	function get_versioncheck_result(result, element) {
		if (typeof result.status !== "undefined" && result.status === "success") {
			switch (result.versioncheck) {
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
					$error_box.stop().slideUp(100, function() {
						if (result.versioncheck === "error_timeout") {
							$error_box.children(".ext_versioncheck_error_box_title, .ext_versioncheck_error_box_link").show();
						} else {
							$error_box.children(".ext_versioncheck_error_box_title, .ext_versioncheck_error_box_link").hide();
						}
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

	function get_force_unstable_result(result) {
		var data = $('<form>' + result.S_HIDDEN_FIELDS + '</form>').serialize();
		$.ajax({
			url: result.S_CONFIRM_ACTION,
			type: 'POST',
			data: data + "&confirm=" + result.YES_VALUE,
			error: function(e, text, ee) {
				$().upload_loading_end();
				show_error_box(e, text, ee);
			},
			success: function(s, x) {
				$().upload_loading_end();
				if (typeof s.status !== "undefined" && s.status === "success") {
					$("#force_unstable_updated").stop().slideDown(700);
					setTimeout(function() {
						$("#force_unstable_updated").slideUp(700);
					}, 3000);
				}
				else {
					show_error_box();
				}
			},
			cache: false
		});
	}

	function get_force_unstable_confirm(result, element) {
		if (typeof result.S_CONFIRM_ACTION !== "undefined" && result.YES_VALUE) {
			$("#ext_force_unstable_confirm").children(".ext_update_ok").html(result.YES_VALUE).siblings(".ext_update_cancel").html(result.NO_VALUE).parent().show();
			$("#ext_force_unstable_text").html(result.MESSAGE_TEXT);
			element.qtip('api').reposition();
			$("#ext_force_unstable_confirm .ext_update_ok").bind("click", function(event) {
				$().upload_loading_start();
				close_error_wrapper();
				element.qtip('api').destroy();
				get_force_unstable_result(result);
			});
			$("#ext_force_unstable_confirm .ext_update_cancel").bind("click", function(event) {
				element.qtip('api').destroy();
			});
		} else if (typeof result.status !== "undefined" && result.status === "success") {
			$().upload_loading_end();
			$("#force_unstable_updated").stop().slideDown(700);
			setTimeout(function() {
				$("#force_unstable_updated").slideUp(700);
			}, 3000);
		} else {
			element.qtip('api').destroy();
			$().upload_loading_end();
			show_error_box(result.code, result.error, result.message);
		}
	}

	function add_set_force_unstable_toggle() {
		$("#set_force_unstable_link").click(function(event) {
			event.preventDefault();
			$("#version_check_settings").slideToggle(700);
		});
		$("#version_check_settings").bind("submit", function(event) {
			event.preventDefault();
			$("#version_check_settings").slideToggle(700);
			$(".extension_toggle_wrapper[data-hasqtip], [data-ext-name][data-hasqtip]").qtip('destroy');
			var force_unstable = ($("#force_unstable").is(":checked")) ? 1 : 0;
			if (force_unstable) {
				$(".upload_ext_list").qtip({
					content: {
						text: function(event, api) {
							load_page('set_config_force_unstable', force_unstable, get_force_unstable_confirm, $(this));
							return "<div id='ext_force_unstable_text'><i class=\"fa fa-spinner fa-3x fa-spin loading_spinner\"></i></div><div id='ext_force_unstable_confirm'><span class='ext_update_ok'></span><span class='ext_update_cancel'></span></div>";
						},
						title: function(event, api) {
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
						hidden: function(event, api) {
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

	// Determine extension status
	function get_ext_status($toggle, determinePurged) {
		return ($toggle.hasClass("extension_toggle_enabled")) ? 'Enabled' : ((!determinePurged || !$toggle.hasClass("extension_toggle_purged")) ? 'Disabled' : 'Uninstalled');
	}

	function update_ext_list() {
		var $downloadListWrapper = $("#download_ext_list_wrapper"),
			fullList = [], resultList = '',
			listShow = parseInt($("#download_ext_list_show").val(), 10),
			listGroup = parseInt($("#download_ext_list_group").val(), 10),
			useEnglish = $("#download_ext_list_english").is(':checked'),
			statusTypes = (listGroup == 0) ? ['Uploaded', 'Broken'] : (
				(listGroup == 1) ? ['Enabled', 'Disabled', 'Broken'] :
					['Enabled', 'Disabled', 'Uninstalled', 'Broken']
			);
		var i = statusTypes.length;
		while (i--) {
			fullList[statusTypes[i]] = [];
		}
		$(".upload_ext_list_content").each(function() {
			var $this = $(this), listRow = '', extStatus = get_ext_status($this.find(".extension_toggle_wrapper"), true).toLowerCase();
			// Include display name
			if (listShow != 1) {
				listRow += $this.find(".upload_ext_list_name").text() + ' ';
			}
			// Include clean name
			if (listShow != 2) {
				listRow += '[' + $this.attr("data-ext-name") + '] ';
			}
			listRow += $this.find(".ext_version_bubble .description_value").text();
			switch (listGroup) {
				case 0:
					fullList['Uploaded'].push(listRow + ' (' +
						((useEnglish) ? extStatus : $downloadListWrapper.attr("data-ext-" + extStatus))
					+ ')');
					break;
				case 1:
					fullList[get_ext_status($this.find(".extension_toggle_wrapper"))].push(listRow +
						((extStatus == 'uninstalled') ? ' (' + ((useEnglish) ? extStatus : $downloadListWrapper.attr("data-ext-uninstalled")) + ')' : '')
					);
					break;
				case 2:
					fullList[get_ext_status($this.find(".extension_toggle_wrapper"), true)].push(listRow);
					break;
			}
		});
		$(".upload_ext_list_unavailable").each(function() {
			var $this = $(this), extStatus = (useEnglish) ? $this.attr("data-ext-status") : $downloadListWrapper.attr("data-ext-" + $this.attr("data-ext-status"));
			fullList['Broken'].push($this.attr("data-ext-name") + ' (' + extStatus + ')');
		});
		i = statusTypes.length;
		while (i--) {
			if (!fullList[statusTypes[i]].length) {
				continue;
			}
			fullList[statusTypes[i]].alphanumSort(true);
			resultList = ((useEnglish) ? statusTypes[i] + ':' : $downloadListWrapper.attr("data-exts-" + statusTypes[i].toLowerCase())) + '\r\n' + fullList[statusTypes[i]].join('\r\n') + '\r\n\r\n' + resultList;
		}
		resultList = $downloadListWrapper.attr("data-ext-list-title") + '\r\n\r\n' + resultList + $downloadListWrapper.attr("data-ext-list-footer");
		$("#download_ext_list").val(resultList);
	}

	/**************************
	 * Page prepare functions *
	 **************************/
	function load_main_page() {
		/* For noscript compatibility we do it here instead of css file */
		$("#extupload").css("display", "none");
		$("#button_upload").css("display", "inline-block");

		function upload_loading_indicator() {
			$("#ext_upload_content").css("display", "none");
			$("#upload").css("display", "block");
			upload_ext.elem.main.one("loading", function() {
				$("#ext_upload_content").css("display", "block");
				$("#upload").css("display", "none");
			});
		}

		$("#submit, .unpack_zip").click(function() {
			upload_loading_indicator();
		});

		$("#load_valid_phpbb_extensions").click(function(event) {
			event.preventDefault();
			load_page("list_from_cdb");
		});

		$(".upload_valid_ext_download_link").click(function(event) {
			event.preventDefault();
			upload_loading_indicator();
			$("#remote_upload").attr("value", $(this).attr("data-ext-source"));
			$("#ext_checksum_type_sha1").prop("checked", true);
			$("#ext_checksum").attr("value", $(this).attr("data-ext-checksum"));
			load_page("upload");
		});
	}

	function load_cdb_list_page() {
		$(".upload_valid_ext_row").click(function(event) {
			event.preventDefault();
			display_ext_description($(this));
		}).attr("title", $("#upload_valid_ext_description").attr("data-show-description"));

		$(".upload_valid_ext_row a").click(function(event) {
			event.stopPropagation();
		});
	}

	function load_list_page() {
		if ($(".upload_ext_list_content").length > 0) {
			var $download_ext_wrapper = $("#download_ext_list_wrapper");
			update_ext_list();
			$("#download_ext_list_link").click(function(event) {
				event.preventDefault();
				restore_modal_data_container();
				update_ext_list();
				show_modal_box($download_ext_wrapper.contents(), true, $download_ext_wrapper);
			}).show();
			$("#download_ext_list_form").change(function() {
				update_ext_list();
			}).find(".select_all_content").click(function() {
				$("#download_ext_list").select();
			});
		}
	}

	function load_details_page() {
		/* For noscript compatibility we do it here instead of css file */
		$("#extupload").css("display", "none");
		$("#button_upload").css("display", "inline-block");
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
					effect: function(offset) {
						$(this).fadeIn(500); // "this" refers to the tooltip
					}
				},
				hide: {
					event: 'click unfocus',
					effect: function(offset) {
						$(this).fadeOut(500); // "this" refers to the tooltip
					}
				}
			});
			$(".extension_update_link").bind("click", function() {
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
					effect: function(offset) {
						$(this).fadeIn(500); // "this" refers to the tooltip
					}
				},
				hide: {
					event: 'unfocus',
					effect: function(offset) {
						$(this).fadeOut(500); // "this" refers to the tooltip
					}
				}
			});
			upload_ext.elem.main.one("loading", function() {
				$(".extension_update_link").qtip('hide').qtip('destroy', true);
				$(".show_ext_updates[data-hasqtip]").qtip('hide').qtip('destroy', true);
			})
		}
		/* Responsive tabs */
		upload_ext.elem.main.find('.ext_details_tabs').not('[data-skip-responsive]').each(function() {
			var $this = $(this),
				$body = upload_ext.elem.main,
				ul = $this.children(),
				tabs = ul.children().not('[data-skip-responsive]'),
				links = tabs.children('a'),
				maxHeight = 29,
				lastWidth = false,
				responsive = false;

			links.each(function() {
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

				links.each(function() {
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
					if ($this.height() <= maxHeight) {
						return;
					}
				}
				// If the space is really short.
				tab = tabs.filter('.activetab');
				var link = tab.children('a');
				link.attr("title", link.attr("data-link-name"));
				link.html('<i class="' + link.attr("data-link-image") + '"></i>');
			}

			check(true);
			$(window).resize(check);
			upload_ext.elem.main.one("loaded", check);
			$this.on("tab_changed", check);
		});
		$(".ext_details_tabs .tab").click(function(event) {
			var current_tab = $(this),
				details_block = $(".ext_details_block");
			event.preventDefault();
			details_block.finish();
			details_block.parent().stop().css("height", details_block.parent().height() + "px");
			details_block.slideUp(700, function() {
				$(".ext_details_tabs .activetab").toggleClass("activetab");
				switch (current_tab.attr("id")) {
					case 'ext_details_main_tab':
						$(".ext_details_markdown, #ext_details_faq, #filetree, #ext_languages, #ext_details_tools").css("display", "none");
						$("#ext_details_content").css("display", "block");
						break;
					case 'ext_details_readme_tab':
						$("#filetree, .ext_details_markdown, #ext_details_faq, #ext_details_content, #ext_languages, #ext_details_tools").css("display", "none");
						$("#ext_details_readme").css("display", "block");
						break;
					case 'ext_details_changelog_tab':
						$("#filetree, .ext_details_markdown, #ext_details_faq, #ext_details_content, #ext_languages, #ext_details_tools").css("display", "none");
						$("#ext_details_changelog").css("display", "block");
						break;
					case 'ext_details_faq_tab':
						$("#filetree, .ext_details_markdown, #ext_details_content, #ext_languages, #ext_details_tools").css("display", "none");
						$("#ext_details_faq").css("display", "block");
						break;
					case 'ext_details_languages_tab':
						$(".ext_details_markdown, #ext_details_faq, #filetree, #ext_details_content, #ext_details_tools").css("display", "none");
						$("#ext_languages").css("display", "block");
						break;
					case 'ext_details_filetree_tab':
						$(".ext_details_markdown, #ext_details_faq, #ext_details_content, #ext_languages, #ext_details_tools").css("display", "none");
						$("#filetree").css("display", "block");
						break;
					case 'ext_details_tools_tab':
						$(".ext_details_markdown, #ext_details_faq, #filetree, #ext_details_content, #ext_languages").css("display", "none");
						$("#ext_details_tools").css("display", "block");
						break;
				}
				current_tab.toggleClass("activetab");
				var restored = false;
				details_block.slideDown({
					duration: 700,
					progress: function(an, progress, ms) {
						if (!restored && details_block.height() >= details_block.parent().height()) {
							details_block.parent().css("height", "");
							restored = true;
						}
					},
					complete: function() {
						if (!restored) {
							details_block.parent().animate({
								height: details_block.parent().children(".ext_details_tabs").outerHeight() + details_block.outerHeight()
							}, 500, function() {
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
		// Detect the request to load the languages tab.
		if ($("#ext_languages").attr("data-ext-show-languages") === "true") {
			$(".ext_details_tabs .activetab").toggleClass("activetab");
			$("#ext_details_languages_tab").addClass("activetab");
			$("#filetree, .ext_details_markdown, #ext_details_content, #ext_details_tools, #ext_details_faq").css("display", "none");
			$("#ext_languages").css("display", "block");
		}
		if ($("#ext_details_faq").length) {
			// Detect the request to load the FAQ tab.
			if ($("#ext_details_faq").attr("data-ext-show-faq") === "true") {
				$(".ext_details_tabs .activetab, #ext_details_faq_tab").toggleClass("activetab");
				$("#filetree, .ext_details_markdown, #ext_details_content, #ext_details_tools, #ext_languages").css("display", "none");
				$("#ext_details_faq").css("display", "block");
			}
			$(".upload_ext_faq_answer").hide();
			var show_upload_ext_faq_element = function(event) {
					var $element = $(this);
					$(".upload_ext_faq_question").not(".grey_question").not(this).unbind("click").bind("click", show_upload_ext_faq_element).addClass("grey_question").next(".upload_ext_faq_answer").slideUp();
					$element.unbind("click", show_upload_ext_faq_element).removeClass("grey_question").next(".upload_ext_faq_answer").slideDown(function() {
						$element.bind("click", hide_upload_ext_faq_element);
					});
				},
				hide_upload_ext_faq_element = function(event) {
					var $element = $(this);
					$element.unbind("click", hide_upload_ext_faq_element).next(".upload_ext_faq_answer").slideUp(function() {
						$element.bind("click", show_upload_ext_faq_element);
					});
					$(".upload_ext_faq_question").not(this).removeClass("grey_question");
				};
			$(".upload_ext_faq_question").css("cursor", "pointer").bind("click", show_upload_ext_faq_element);
		}
		$(".ext_versioncheck_force_link").click(function(event) {
			event.preventDefault();
			$().upload_loading_start();
			close_error_wrapper();
			$("#ext_versioncheck_error_box").slideUp(700);
			$("#meta_version").removeClass("description_value_ok description_value_old").attr("title", "");
			load_page("versioncheck_force", $("h1.ExtensionName span").attr("data-ext-name"), get_versioncheck_result, $(this));
		});
		$(".ext_restore_languages").click(function(event) {
			event.preventDefault();
			load_page("restore_languages", $(this).attr("data-ext-restore"));
		});
	}

	function check_details_page() {
		var $detailsBlock = $(".ext_details_block"), $reloadLink = $(".ext_reload_link");
		// Reload the details page if this was not an ajax request and if not the full page has been loaded (we do not need it if we load languages for Upload Extensions).
		if (($detailsBlock.length > 0) && ($detailsBlock.attr("data-load-full-page") != "1") && (typeof $reloadLink.attr("data-upload-ext") === "undefined" || $("#ext_languages").attr("data-ext-show-languages") !== "true")) { // This is needed because filetree, readme and changelog are downloaded together if JavaScript is used.
			load_page("details", $reloadLink.attr("data-ext-name"));
		}
	}

	function load_zip_packages_page() {
		$(".unpack_zip").click(function(event) {
			event.preventDefault();
			load_page("local_upload", $(this).attr("data-upload-link"));
		});
		$("#upload_pagination li a").click(function(event) {
			event.preventDefault();
			load_page("zip_packages", $(this).attr("href"));
		});
	}

	/*****************************
	 * Server response functions *
	 *****************************/
	function check_response(res) {
		if (typeof res.FORCE_UPDATE !== "undefined") {
			load_page("force_update");
			return false;
		} else if (typeof res !== "object") {
			if (res.match(/<input/im)) {
				// Reload the page after logout.
				window.location.href = upload_ext.fn.main_attr("data-page-action");
			} else {
				// Show result error.
				$().upload_loading_end();
				show_error_box();
				// Blank page is an error, but without text.
				if (res.trim() !== '') {
					show_error_modal_box(res);
				}
				return false;
			}
		}
		return true;
	}

	function parse_response(element, res) {
		var $temp_container = $("#upload_temp_container");

		element.html(res.result);

		if (res.status == "error") {
			$("#upload_link_back").click(function(e) {
				e.preventDefault();
				$("#upload_main_wrapper, #upload_main").addClass("main_transformation");
				upload_ext.elem.wrapper.slideUp(500, function() {
					upload_ext.elem.main.empty().append($temp_container.contents());
					$temp_container.empty();
					upload_ext.elem.wrapper.attr("style", "display:none;").slideDown(700, "linear", function() {
						$("#upload_main_wrapper, #upload_main").removeClass("main_transformation");
					});
				});
			});
		} else {
			$temp_container.empty();
		}

		// Display debug errors in the modal box.
		if (res.output) {
			show_error_modal_box(res.output);
		}
	}

	function load_page(action, id, local, element) {
		if (typeof (local) === "undefined") {
			$().upload_loading_start();
			close_error_wrapper();
			$("#upload_main_wrapper, #upload_main").addClass("main_transformation");
			upload_ext.elem.wrapper.slideUp(500, function() {
				load_page_process(action, id, local, element);
			});
		} else {
			load_page_process(action, id, local, element);
		}
	}

	function load_page_process(action, id, local, element) {
		var getExtension = ["details", "enable", "disable", "purge", "versioncheck_force", "restore_languages"];
		var page_url = upload_ext.fn.main_attr("data-page-action"), data = {}, method = 'GET';
		var $temp_container = $("#upload_temp_container");

		function page_loaded($this, s) {
			parse_response($this, s);
			parse_document(upload_ext.elem.wrapper);
			add_ajax();
			if (s.status != "error") {
				bind_load_events(action);
				if ($.inArray(action, ["upload", "upload_language"]) > -1) {
					action = s.action = "details";
					id = $("h1.ExtensionName span").attr("data-ext-name");
				}
			}
			if (upload_replace_history) {
				upload_replace_history = false;
				phpbb.history.replaceUrl(upload_ext.fn.main_attr("data-page-url") + "&action=" + s.action + generate_get_request() + "&ajax=1", document.title, {
					action: action,
					id: id,
					replaced: true
				});
			} else if (upload_stop_history) {
				upload_stop_history = false;
			} else {
				phpbb.history.pushUrl(upload_ext.fn.main_attr("data-page-url") + "&action=" + s.action + generate_get_request() + "&ajax=1", document.title, {
					action: action,
					id: id
				});
			}
			$().upload_loading_end();
			upload_ext.elem.wrapper.finish().attr("style", "display:none;").slideDown(700, "linear", function() {
				$("#upload_main_wrapper, #upload_main").removeClass("main_transformation");
				upload_ext.elem.main.trigger("loaded");
			});
		}

		function generate_get_request() {
			if ($.inArray(action, getExtension) > -1) {
				return "&ext_name=" + encodeURIComponent(id);
			}
			switch (action) {
				case "local_upload":
					return "&local_upload=" + id;
				case "set_config_force_unstable":
					return "&force_unstable=" + id;
				case "list":
					return (typeof id !== "undefined" && id === "versioncheck_force") ? "&versioncheck_force=1" : "";
			}
			return "";
		}

		if (typeof local === "undefined") {
			$temp_container.append(upload_ext.elem.main.contents());
		}

		if (action === "upload" || action === "upload_update" || action === "upload_language") {
			var $this = $("#ext_upload");
			if (action === "upload_update") {
				$this = $("#upload_ext_update");
				action = "upload"; // The common action for the server.
			}
			data = $this.serializeArray();
			method = $this.attr('method') || 'GET';
			$this.ajaxSubmit({
				url: page_url + "&ajax_action=" + action, // window.location.href
				target: upload_ext.elem.main,
				uploadProgress: function(e, pos, total, percentComplete) {
					if (percentComplete) {
						$().upload_loading_progress(percentComplete);
					}
				},
				error: function(e, text, ee) {
					show_error_modal_box(e.responseText);
					if (upload_stop_history) {
						upload_stop_history = false;
					}
					$().upload_loading_end();
					show_error_box(e, text, ee);
				},
				success: function(s, x) {
					if (action === "upload_language" && typeof s === "object" && typeof s.REFRESH !== "undefined") {
						// Reload the page after installing current language package.
						window.location.href = upload_ext.fn.main_attr("data-page-action") + "&action=details&ext_show=languages&result=language_uploaded&ajax=1&lang=" + s.LANGUAGE;
					}
					else if (check_response(s)) {
						page_loaded($(this), s);
					}
				}
			});
		}
		else {
			$.ajax({
				url: ((action === "zip_packages" && typeof id !== "undefined") ? id : page_url) + "&ajax_action=" + action + generate_get_request(),
				context: upload_ext.elem.main,
				error: function(e, text, ee) {
					show_error_modal_box(e.responseText);
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
					if (upload_stop_history) {
						upload_stop_history = false;
					}
					$().upload_loading_end();
					show_error_box(e, text, ee);
				},
				success: function(s, x) {
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
		}
		if (typeof local === "undefined") {
			upload_ext.elem.main.trigger("loading");
		}
	}

	// Bind load_page events
	function bind_load_events(action) {
		$(".upload_load_zip").click(function(event) {
			event.preventDefault();
			load_page("zip_packages");
		});

		$(".upload_load_uninstalled").click(function(event) {
			event.preventDefault();
			load_page("uninstalled");
		});

		$(".upload_load_list").click(function(event) {
			event.preventDefault();
			load_page("list");
		});

		$("#upload_load_main").click(function(event) {
			event.preventDefault();
			load_page("main");
		});

		$("#upload_load_main_list").click(function(event) {
			event.preventDefault();
			load_page("list");
		});

		$("#versioncheck_force_update_all").click(function(event) {
			event.preventDefault();
			load_page("list", "versioncheck_force");
		});

		$(".upload-main-content #ext_upload").submit(function(event) {
			event.preventDefault();
			load_page("upload");
		});

		$(".ext_details_block #ext_upload").submit(function(event) {
			event.preventDefault();
			load_page("upload_language");
		});

		$("#upload_ext_update").submit(function(event) {
			event.preventDefault();
			load_page("upload_update");
		});

		$(".upload_get_details_link").click(function(event) {
			event.preventDefault();
			load_page("details", $(this).attr("data-ext-name"));
		});

		switch (action) {
			case "list_from_cdb":
				load_cdb_list_page();
			case "main":
				load_main_page();
				break;
			case "upload_language":
				add_language_tip();
				load_details_page();
				break;
			case "upload":
			case "local_upload":
			case "force_update":
			case "restore_languages":
				add_enable_tip();
			case "faq":
			case "details":
				load_details_page();
				break;
			case "list":
				add_enable_toggle();
				add_set_force_unstable_toggle();
				load_list_page();
				break;
			case "zip_packages":
				load_zip_packages_page();
				break;
		}
	}

	/* Work with browser's history. */
	var upload_stop_history = false, upload_replace_history = false;
	$(window).on("popstate", function(e) {
		var current_state = e.originalEvent.state;
		if (current_state.first) {
			window.location.reload();
		} else {
			upload_stop_history = true;
			load_page(current_state.action, current_state.id);
		}
	});

	/* Workaround for browser's cache. */
	if (phpbb.history.isSupported("state")) {
		$(window).on("unload", function() {
			var current_state = history.state, d = new Date();
			if (current_state !== null) {
				phpbb.history.replaceUrl(window.location.href + '&ajax_time=' + d.getTime(), document.title, current_state);
			}
		});

		var current_state = history.state;
		if (current_state !== null) {
			phpbb.history.replaceUrl(window.location.href.replace(/&ajax_time=\d*/i, ''), document.title, current_state);
		} else {
			phpbb.history.replaceUrl(window.location.href, document.title, {
				action: upload_ext.fn.main_attr("data-page-action"),
				id: null,
				first: true
			});
		}
	}

	/* Initialize loaded page. */
	bind_load_events(upload_ext.fn.main_attr("data-load-action"));
	check_details_page();
})(jQuery, window, document);

function browseFile() {
	document.getElementById('extupload').click();
}

function setFileName() {
	document.getElementById('remote_upload').value = document.getElementById("extupload").files[0].name;
}
