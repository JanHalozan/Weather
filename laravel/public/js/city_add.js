$(document).ready(function(){

    //Searching function
    $('#search_button').click(function(){
        //We require input to be City, Country
        var regex_text = new RegExp("[A-zČčŽžŠš]+,\\s?[A-zČčŽžŠš]+");
        if (!$("#search").val().match(regex_text))
        {
            $("#input_warning").text(warning_text).show('medium');
            return;
        }
        $("#search_button").text(searching_text);
        $.ajax({
            type: "POST",
            url: "city-add",
            data: { "search_text": $("#search").val()}
        })
            .done(function(data){
                if (data !== "NULL")
                {
                    json = JSON.parse(data);
                    $("#city_name").text(json.name + ", " + json.country);
                    $('#data').val(data);
                    $("#input_div").hide('medium');
                    $("#show_div").show('medium');
                    $("#add_button").show();
                    $("#search_button").hide();
                }
                else
                {
                    $("#input_warning").text(no_find_text).show('medium');
                    $("#search_button").text(search_text);
                }
            });
    });

    //City add function
    $('#add_button').click(function(){
        $('#add_button').text(adding_text);
        $.ajax({
            type: 'PUT',
            url: 'city-add',
            data: { 'data': $('#data').val() }
        })
            .done(function(data){
                $("#found_city").text(complete_text);
                $("#add_button").hide('medium');
            });
    });

    //Save
    $('#save-button').click(function(){

    var e = document.getElementById("selected-city");
    var val = e.options[e.selectedIndex].value;

        $.ajax({
            type: "POST",
            url: "me",
            data: { 'city_id': val }
        }).done(function(data){
            if (data == "OK")
            {
                location.reload();
            }
            else
            {
                alert(data);
            }
        });
     });
});