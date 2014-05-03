$(document).ready(function()
{
	setupPage();
	
	$( window ).resize(function() {
		setupPage();
	});
});

function setupPage(){
	var marBottom = 2;
	var overflow = 6;

	/* Push text to the bottom of div */
	// Push temperature
    var difference = $("#temperature").height() - $("#temperature p").height();
	$("#temperature p").css({top: difference - marBottom});

	// Push fact-title
	difference = $("#title-fact").height() - $("#title-fact p").height();
	$("#title-fact p").css({top: difference - marBottom});

	// Push second-line down
	difference = $("#second-line").height() - $("#second-line p").height();
	$("#second-line p").css({top: difference - marBottom - overflow});

	// Push third-line down
	difference = $("#third-line").height() - $("#third-line p").height();
	$("#third-line p").css({top: difference - marBottom});

	/* Push fact-title and fact a bit left */
	var marLeft = $("#fact").width() - $("#fact p").width();
		marLeft /= 2;
		$("#title-fact p").css({marginLeft: marLeft});
		$("#fact p").css({marginLeft: marLeft});
}

