function initOblaki()
{

}

var sonce;

function initSonce()
{
    var sun_size = 40;

    //geometrija in textura   
    var sun_texture = THREE.ImageUtils.loadTexture("images/textures/sun_texture2.png");
    var sun_geometry = new THREE.PlaneGeometry( sun_size, sun_size );

    //material
    var sun_material = new THREE.MeshBasicMaterial({
        map:sun_texture,
        transparent:true,
        opacity:0.7
    });

    sonce = new THREE.Mesh( sun_geometry, sun_material );

    //pozicija
    sonce.position.x = 30;
    sonce.position.y = 100;
    sonce.position.z = -199;

    scene.add(sonce);
    //camera.lookAt(sonce.position);
}

function fras_init() 
{
    initSonce();
}

function fras_update()
{  
    sonce.lookAt(camera.position);
}