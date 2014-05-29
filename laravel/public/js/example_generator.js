/**
 * Created by zoran_000 on 29.5.2014.
 */

function onClothChanged(value)
{
    document.getElementById(value + "Img").src = "images/" + document.getElementsByName(value)[0].value + "_" + value + ".png";
}
