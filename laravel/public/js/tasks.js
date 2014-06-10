$(document).ready(function(){
	
	$("#addButton").click(function(){

        // Get size of list, in order to limit 5 tasks per day
        var c0Size = $(".c1 li").length;
        var c1Size = $(".c2 li").length;
        var c2Size = $(".c3 li").length;
        var c3Size = $(".c4 li").length;
        var c4Size = $(".c5 li").length;

		$.ajax(
		{
            type: "POST",
            url: "tasks",
            data: { 
                "taskType": $("#comboBox").val(), 
                "c0Size": c0Size, 
                "c1Size": c1Size,
                "c2Size": c2Size,
                "c3Size": c3Size,
                "c4Size": c4Size 
            }

        }).done(function(data){

        	switch (data) {

                case '0':
                    $(".c1").append("<li>" + $("#comboBox option:selected").text() + "</li>");
                break;

                case '1':
                    $(".c2").append("<li>" + $("#comboBox option:selected").text() + "</li>");
                break;

                case '2':
                    $(".c3").append("<li>" + $("#comboBox option:selected").text() + "</li>");
                break;

                case '3':
                    $(".c4").append("<li>" + $("#comboBox option:selected").text() + "</li>");
                break;

                case '4':
                    $(".c5").append("<li>" + $("#comboBox option:selected").text() + "</li>");
                break;

                case '5':
                    $("#info").text("Ne priporočamo");
                break;

                default:
                    $("#info").text("Napaka");
                break;

            }

    	});
	});
});