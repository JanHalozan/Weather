$(document).ready(function()
{
    $("select").change(function()
    {
        $.ajax({
            type: "PUT",
            url: "city",
            data: { "city_id": this.value }
        })
            .done(function(){
                window.location.replace("/");
            });
    });
});