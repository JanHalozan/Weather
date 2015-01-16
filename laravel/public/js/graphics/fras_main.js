var oblaki = [];
// za sledenje kamere
var tempX = camera.position.x;
var tempY = camera.position.y;
var tempZ = camera.position.z;


function initDelnaOblacnost()
{

    //geometrija in textura   
    var cloud1_texture = THREE.ImageUtils.loadTexture("images/textures/cloud1.png");
    var cloud1_geometry = new THREE.PlaneGeometry( 8, 2);
    var cloud2_texture = THREE.ImageUtils.loadTexture("images/textures/cloud2.png");
    var cloud2_geometry = new THREE.PlaneGeometry( 6, 2);
    var cloud3_texture = THREE.ImageUtils.loadTexture("images/textures/cloud4.png");
    var cloud3_geometry = new THREE.PlaneGeometry( 10, 4);
    var cloud4_texture = THREE.ImageUtils.loadTexture("images/textures/cloud4.png");
    var cloud4_geometry = new THREE.PlaneGeometry( 8, 3);



    //material
    var cloud1_material = new THREE.MeshBasicMaterial({
        map:cloud1_texture,
        transparent:true,
        opacity:0.7
    });

    var cloud2_material = new THREE.MeshBasicMaterial({
        map:cloud2_texture,
        transparent:true,
        opacity:0.5
    });
    var cloud3_material = new THREE.MeshBasicMaterial({
        map:cloud3_texture,
        transparent:true,
        opacity:0.9
    });
    var cloud4_material = new THREE.MeshBasicMaterial({
        map:cloud4_texture,
        transparent:true,
        opacity:0.9
    });


    oblaki[0]= new THREE.Mesh( cloud1_geometry, cloud1_material );
    oblaki[1] = new THREE.Mesh( cloud2_geometry, cloud2_material );
    oblaki[2]= new THREE.Mesh( cloud3_geometry, cloud3_material );
    oblaki[3] = new THREE.Mesh( cloud4_geometry, cloud4_material );

    //pozicija
    oblaki[0].position.x = -2;
    oblaki[0].position.y = 15;
    oblaki[0].position.z = -15;
    oblaki[0].rotation.x = Math.PI/2;

    oblaki[1].position.x = 10;
    oblaki[1].position.y = 13;
    oblaki[1].position.z = -8;
    oblaki[1].rotation.x = Math.PI/2;


    oblaki[2].position.x = -10;
    oblaki[2].position.y = 14;
    oblaki[2].position.z = -9;
    oblaki[2].rotation.x = Math.PI/2;

    oblaki[3].position.x = 10;
    oblaki[3].position.y = 14;
    oblaki[3].position.z = -1;
    oblaki[3].rotation.x = Math.PI/2;
    oblaki[3].rotation.z = Math.PI/32;

    //scene.add(oblaki[0]);
}

var sonce;
var directionalLight;

function initSonce()
{
    var sun_size = 4;


    //geometrija in textura   
    var sun_texture = THREE.ImageUtils.loadTexture("images/textures/sun6.png");
    var sun_geometry = new THREE.CircleGeometry( 5, 32 );

    //material
    var sun_material = new THREE.MeshBasicMaterial({
        map:sun_texture,
        transparent:true
    });

    sonce = new THREE.Mesh( sun_geometry, sun_material );

    //pozicija
    sonce.position.x = 7;
    sonce.position.y = 15;
    sonce.position.z = -10;
    sonce.rotation.x = Math.PI/4;
    sonce.rotation.z = 2*Math.PI/3
/*
    JE ZE V MAINU
    directionalLight = new THREE.PointLight( 0xffffff, 1, 100);
    directionalLight.position.set( 14, 15, -10 );
    scene.add( directionalLight );
*/
}

var oblacnoNebo;

function initOblacnost()
{
    var skyTexture = THREE.ImageUtils.loadTexture("images/textures/cloud2.png");
    var sky_geometry = new THREE.PlaneGeometry(50, 40);

    var sky_material = new THREE.MeshBasicMaterial({
        map:skyTexture,
        transparent:true,
        opacity:0.5
    });

    oblacnoNebo = new THREE.Mesh( sky_geometry, sky_material);

    oblacnoNebo.position.z = -2 ;
    oblacnoNebo.position.y = 14.9;

    oblacnoNebo.rotation.x = Math.PI/2;
    oblacnoNebo.rotation.z = Math.PI;

    scene.add(oblacnoNebo);

}

/*
NI POTREBE PO PREMIKU
function updateObPremiku()
{

   sonce.translateX(camera.position.x - tempX);

      tempX = camera.position.x;
      tempY = camera.position.y;
}*/




function fras_init() 
{
    initSonce();

    initDelnaOblacnost();

    //initOblacnost();
}


var isOKeyPressed = false;
var jeOblacno = false;
var isSKeyPressed = false;
var jeSoncno = false;

function fras_update()
{  
    sonce.lookAt(camera.position);
    //updateObPremiku();

// oblaki
if (keyboard.pressed('o')) 
    {
        if(!isOKeyPressed) 
        {   
            if(!jeOblacno)
            {
                for(var i=0;i<4;i++)
                {
                    scene.add(oblaki[i]);
                }
            }
            else
            {
                for(var i=0;i<4;i++)
                {
                    scene.remove(oblaki[i]);
                }
                
            }

            jeOblacno = !jeOblacno;
        
        }
        
        isOKeyPressed = true;
    } 
    else  
        isOKeyPressed = false;

    // sonce
    if (keyboard.pressed('8')) 
    {
        if(!is8KeyPressed) 
        {   
            if(!jeSoncno)
            {
                for(var i=0;i<4;i++)
                {
                    scene.add(sonce);
                }
            }
            else
            {
                for(var i=0;i<4;i++)
                {
                    scene.remove(sonce);
                }
                
            }

            jeSoncno = !jeSoncno;
        
        }
        
        is8KeyPressed = true;
    } 
    else  
        is8KeyPressed = false;

   
    //oblak1.lookAt(camera.position);
    //updateSonce();
}