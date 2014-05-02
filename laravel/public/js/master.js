$(document).ready(function()
{
    $("#master-close").click(function()
    {
        $("#master-message").slideUp(400, function()
        {
            $("#master-message").remove();
        });
    });
});