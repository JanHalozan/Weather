$(document).ready(function()
{
	setupPage();
	
	$( window ).resize(function() {
		setupPage();
	});
});

function setupPage(){

	/* Push whole content box on the midle */
	var contentHeight = $("#content").height();
	var windowHeight = $(window).height();	
	var headerHeight = $("header").height();
	var footerHeight = $("footer").height();
	$("#content").css({marginTop: (windowHeight - contentHeight - headerHeight - footerHeight - 10) / 2});
}