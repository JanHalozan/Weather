//Create render and add canvas to scene
var zastavica = 0; //Smark stuff - Jan needs it

var renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth, window.innerHeight-74);
renderer.shadowMapEnabled = true;
renderer.shadowMapType = THREE.PCFSoftShadowMap;
var canvas = renderer.domElement;
canvas.style.position = "fixed";
canvas.style.top = "50px";
canvas.style.left = "0px";
document.getElementById("main_view").appendChild( canvas );

//Create the scene and camera
var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(50, (window.innerWidth - 200) / (window.innerHeight - 160), 0.1, 1000);
camera.up = new THREE.Vector3(0, 1, 0);
camera.position.y = 1;
camera.position.z = 1;
camera.position.x = 0;
scene.add(camera);

//Add temporary orbit controls
//var controls = new THREE.OrbitControls( camera );
var keyboard = new THREEx.KeyboardState();

//Add basic lights to the scene
var ambient_light = new THREE.AmbientLight(0x333333)
var spot_light = new THREE.SpotLight(0xffffff);
var spot_light2 = new THREE.SpotLight(0x333333);

spot_light2.castShadow = false;
spot_light2.position.set(0, 100, 100);

spot_light.castShadow = true;
spot_light.shadowMapWidth = 1024;
spot_light.shadowMapHeight = 1024;
//spot_light.shadowCameraVisible = true;
spot_light.shadowDarkness = 0.5;
spot_light.position.set(0, 100, -199);//x = 30;

scene.add(spot_light);
scene.add(spot_light2);
scene.add(ambient_light);

//Create a resize event for the cavas to scale
window.addEventListener( 'resize', onWindowResize, false );

function onWindowResize()
{
    camera.aspect = (window.innerWidth) / (window.innerHeight - 74);
    camera.updateProjectionMatrix();
    renderer.setSize( window.innerWidth, window.innerHeight - 74 );
}

