$(document).ready(function(){
	
	$("#addButton").click(function(){

		$.ajax(
		{

            type: "POST",
            url: "tasks",
            data: { "task": $("#comboBox").val() }

        }).done(function(data){

        	if (data == "0")
        	{
            	alert("Error");
        	} 
        	else 
        	{
        		$("#monday").append("<li>" + $("#comboBox option:selected").text() + "</li>");     		
        	}

    	});
	});
});