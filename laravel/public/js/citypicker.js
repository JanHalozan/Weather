$(document).ready(function()
{
    $("select").change(function()
    {
        window.location.replace("/city/" + this.value);
    });
});