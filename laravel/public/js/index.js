$(document).ready(function(){
	// Push text to the bottom of div
    var difference = $("#temperature").height() - $("#temperature p").height();
	$("#temperature p").css({top: difference});
});

