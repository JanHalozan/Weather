$(document).ready(function()
{
    $("select").change(function()
    {
    	document.cookie = "city_id=" + decodeURIComponent(this.value) + "; expires=Thu, 18 Dec 2030 12:00:00 GMT";
        window.location.replace("/");
    });
});