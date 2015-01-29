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
    var cloud3_geometry = new THREE.PlaneGeometry( 11, 5);
    var cloud4_texture = THREE.ImageUtils.loadTexture("images/textures/cloud4.png");
    var cloud4_geometry = new THREE.PlaneGeometry( 9, 4);



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
    oblaki[0].position.y = 12;
    oblaki[0].position.z = -15;
    oblaki[0].rotation.x = Math.PI/2;

    oblaki[1].position.x = 10;
    oblaki[1].position.y = 12;
    oblaki[1].position.z = -8;
    oblaki[1].rotation.x = Math.PI/2;


    oblaki[2].position.x = -10;
    oblaki[2].position.y = 17;
    oblaki[2].position.z = -9;
    oblaki[2].rotation.x = Math.PI/2;

    oblaki[3].position.x = 10;
    oblaki[3].position.y = 17;
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

var cloud_big;
var cloud_big2;

function initOblacnost()
{
    var Cloud2Texture = THREE.ImageUtils.loadTexture("images/textures/cloud4.png");
    var cloud2_geometry = new THREE.PlaneGeometry(40, 30);

    var CloudTexture = THREE.ImageUtils.loadTexture("images/textures/cloud2.png");
    var cloud_geometry = new THREE.PlaneGeometry(40, 30);


    var cloud_material = new THREE.MeshBasicMaterial({
        map:CloudTexture,
        transparent:true,
        opacity:0.6
    });

    var cloud2_material = new THREE.MeshBasicMaterial({
        map:Cloud2Texture,
        transparent:true,
        opacity:0.8
    });


    cloud_big2 = new THREE.Mesh( cloud2_geometry, cloud2_material);
    cloud_big = new THREE.Mesh( cloud_geometry, cloud_material);

    cloud_big2.position.y = 16;
    cloud_big2.rotation.x = Math.PI/2;
    cloud_big2.position.z = 0;
    cloud_big2.position.x = -10;

    cloud_big.position.y = 18;
    cloud_big.rotation.x = Math.PI/2;
    cloud_big.position.z = -15;
    cloud_big.position.x = 10;


    

}

/*
NI POTREBE PO PREMIKU
function updateObPremiku()
{

   sonce.translateX(camera.position.x - tempX);

      tempX = camera.position.x;
      tempY = camera.position.y;
}*/
var premik = 1;


function updateDelnaOblacnost()
{
    if( premik > 0){
        
        oblaki[0].translateX(0.00025);
        oblaki[1].translateX(-0.00025);
        oblaki[2].translateX(0.0005);
        oblaki[3].translateX(-0.001);
        premik += 1;
        if(premik == 1000)
            premik = -1000;

    }else
    {  

        oblaki[0].translateX(-0.00025);
        oblaki[1].translateX(0.00025);
        oblaki[2].translateX(-0.0005);
        oblaki[3].translateX(0.001);
        
        premik += 1;
    }
}

function moveCloudsWithKeys()
{
    var speed = 0.01;
    if (keyboard.pressed('left'))
    {
        for (var i = 0; i < 4; ++i)
        {
            oblaki[i].translateX(-speed);
        }
        cloud_big.translateX(-speed);
        cloud_big2.translateX(-speed);
    }
    else if (keyboard.pressed('right'))
    {
        for (var i = 0; i < 4; ++i)
        {
            oblaki[i].translateX(speed);
        }
        cloud_big.translateX(speed);
        cloud_big2.translateX(speed);
    }

    if (keyboard.pressed('up'))
    {
        for (var i = 0; i < 4; ++i)
        {
            oblaki[i].translateY(-speed);
        }
        cloud_big.translateY(-speed);
        cloud_big2.translateY(-speed);
    }
    else if (keyboard.pressed('down'))
    {
        for (var i = 0; i < 4; ++i)
        {
            oblaki[i].translateY(speed);
        }
        cloud_big.trtanslateY(speed);
        cloud_big2.tttranslateY(speed);
    }
}

var isOKeyPressed = false;
var is7KeyPressed = false;
var jeDelnoOblacno = false
var jeOblacno = false;
var isSKeyPressed = false;
var jeSoncno = false;

function fras_init() 
{
    initSonce();

    initDelnaOblacnost();

    initOblacnost();

    if(data_blob.condition_code == "clear_sky")
    {
        scene.add(sonce);
    }
    if(data_blob.condition_code == "few_clouds" || data_blob.condition_code == "scattered_clouds" )
    {
        scene.add(sonce);
         for(var i=0;i<4;i++)
         {
            scene.add(oblaki[i]);
         }
         jeDelnoOblacno = true;
    }
    if(data_blob.condition_code == "broken_clouds")
    {
        scene.add(cloud_big);
        scene.add(cloud_big2);

        for(var i=0;i<4;i++)
        {
            scene.add(oblaki[i]);
        }

        jeOblacno = true;
    }

}

function fras_update()
{  
    sonce.lookAt(camera.position);
    //updateObPremiku();
    updateDelnaOblacnost();
    moveCloudsWithKeys();
// oblaki
if (keyboard.pressed('o')) 
    {
        if(!isOKeyPressed)
        {   
            if(!jeDelnoOblacno)
            {
                for(var i=0;i<4;i++)
                {
                    scene.add(oblaki[i]);
                }
                scene.add(sonce);
            }
            else
            {
                for(var i=0;i<4;i++)
                {
                    scene.remove(oblaki[i]);
                }
                scene.remove(sonce);
                
            }

            jeDelnoOblacno = !jeDelnoOblacno;
        
        }
        
        isOKeyPressed = true;
    } 
    else  
        isOKeyPressed = false;

    // sonce
    if (keyboard.pressed('p')) 
    {
        if(!is8KeyPressed) 
        {   
            if(!jeSoncno)
            {
                    scene.add(sonce);
                
            }
            else
            {
                    scene.remove(sonce);
                   
            }

            jeSoncno = !jeSoncno;
        
        }
        
        is8KeyPressed = true;
    } 
    else  
        is8KeyPressed = false;

    //Oblacnost
    if (keyboard.pressed('i')) 
    {
        if(!is7KeyPressed) 
        {   
            if(!jeOblacno)
            {
               // scene.add(oblacnoNebo);
                scene.add(cloud_big);
                scene.add(cloud_big2);

                        for(var i=0;i<4;i++)
                    {
                        scene.add(oblaki[i]);
                    }

            }
            else
            {
                //scene.remove(oblacnoNebo);
                scene.remove(cloud_big);
                scene.remove(cloud_big2);

                for(var i=0;i<4;i++)
                {
                    scene.remove(oblaki[i]);
                }
                
            }

            jeOblacno = !jeOblacno;
        
        }
        
        is7KeyPressed = true;
    } 
    else  
        is7KeyPressed = false;

   
    //oblak1.lookAt(camera.position);
    //updateSonce();
}