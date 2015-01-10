function initOblaki()
{

}


function initSonce()
{
	var sun_size = 7;

	//geometrija in textura   
	var sun_texture = THREE.ImageUtils.loadTexture("images/textures/sun_texture.png");
    var sun_geometry = new THREE.PlaneGeometry( sun_size, sun_size );

    //material
    var sun_material = new THREE.MeshBasicMaterial({
		map:sun_texture,
		transparent:true,
		opacity:0.9
	});

    var sonce = new THREE.Mesh( sun_geometry, sun_material );

    //pozicija
    sonce.position.x = 5;
    sonce.position.y = 15;
    sonce.position.z = -25;

    scene.add(sonce);
    //camera.lookAt(sonce.position);
}

function fras_init() 
{
	initSonce();
}

function fras_update()
{

}