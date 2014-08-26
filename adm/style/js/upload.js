; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	$("a.simpledialog").simpleDialog({
	    opacity: 0.1,
	    width: '650px',
		height: '600px'
	});

	/* For noscript compatibility we do it here instead of css file */
	$("#extupload").css("display", "none");
	$("#button_upload").css("display", "inline-block");

	$("#submit").click(function () {
		$("#ext_upload_content").css("display", "none");
		$("#upload").css("display", "block");
	});

	$("#show_filetree").click(function () {
		$("#show_filetree").css("display", "none");
		$("#hide_filetree").css("display", "block");
		$("#markdown").fadeOut(1000, function () {
			$("#filetree").fadeIn(1000);
		});
	});

	$("#hide_filetree").click(function () {
		$("#hide_filetree").css("display", "none");
		$("#show_filetree").css("display", "block");
		$("#filetree").fadeOut(1000, function () {
			$("#markdown").fadeIn(1000);
		});
	});
})(jQuery, window, document);

function browseFile() 
{
	document.getElementById('extupload').click();
}

function setFileName() 
{
	document.getElementById('remote_upload').value = document.getElementById("extupload").files[0].name;
}

function loadXMLDoc(url)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("filecontent").style.display="block";
			document.getElementById("filecontent").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}
