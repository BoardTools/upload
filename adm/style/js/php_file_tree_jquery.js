function setFileTree() {
	// Hide all subfolders at startup
	$(".php-file-tree").find("UL").hide();

	// Expand/collapse on click
	$(".pft-directory span").click(function() {
		$(this).parent().find("UL:first").slideToggle("medium");
		if ($(this).parent().attr('className') == "pft-directory") {
			return false;
		}
	});

	$(".php-file-tree [data-file-link]").click(function(event) {
		event.preventDefault();
		var $this = $(this);
		$(".pft-active").removeClass("pft-active");
		$this.addClass("pft-active");
		$("#filecontent_wrapper").fadeOut(500, function() {
			$("#filecontent").load($this.attr("data-file-link"), function() {
				$("#filecontent_wrapper").fadeIn(500);
			});
		});
	});

	$(".php-file-tree > li[title='composer.json']").addClass("pft-active");

	$(".select_all_code").css("display", "inline-block").click(function(event) {
		event.preventDefault();
		selectCode(this);
	})
}

function selectCode(a) {
	// Get ID of code block
	var e = a.parentNode.parentNode.getElementsByTagName('CODE')[0];
	var s, r;

	// Not IE and IE9+
	if (window.getSelection) {
		s = window.getSelection();
		// Safari and Chrome
		if (s.setBaseAndExtent) {
			var l = (e.innerText.length > 1) ? e.innerText.length - 1 : 1;
			s.setBaseAndExtent(e, 0, e, l);
		}
		// Firefox and Opera
		else {
			// workaround for bug # 42885
			if (window.opera && e.innerHTML.substring(e.innerHTML.length - 4) === '<BR>') {
				e.innerHTML = e.innerHTML + '&nbsp;';
			}

			r = document.createRange();
			r.selectNodeContents(e);
			s.removeAllRanges();
			s.addRange(r);
		}
	}
	// Some older browsers
	else if (document.getSelection) {
		s = document.getSelection();
		r = document.createRange();
		r.selectNodeContents(e);
		s.removeAllRanges();
		s.addRange(r);
	}
	// IE
	else if (document.selection) {
		r = document.body.createTextRange();
		r.moveToElementText(e);
		r.select();
	}
}
