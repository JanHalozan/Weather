//Create render and add canvas to scene
var renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth, window.innerHeight-74);
var canvas = renderer.domElement;
canvas.style.position = "fixed";
canvas.style.top = "50px";
canvas.style.left = "0px";
document.getElementById("main_view").appendChild( canvas );

//Create the scene and camera
var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera( 75, (window.innerWidth - 200) / (window.innerHeight - 160), 0.1, 1000 );
camera.up = new THREE.Vector3( 0, 1, 0 );
camera.position.y = 1;
camera.position.z = 1;
camera.position.x = 0;
scene.add(camera);

//Add temporary orbit controls
//var controls = new THREE.OrbitControls( camera );
var keyboard = new THREEx.KeyboardState();

//Add basic lights to the scene
var ambient_light = new THREE.AmbientLight(0x111111)
var point_light = new THREE.PointLight(0xffffff, 1, 100);
point_light.position.x = -3;
point_light.position.y = 5;
point_light.position.z = -3;
scene.add(point_light);
scene.add(ambient_light);

//Create a resize event for the cavas to scale
window.addEventListener( 'resize', onWindowResize, false );

function onWindowResize()
{
    camera.aspect = (window.innerWidth) / (window.innerHeight - 74);
    camera.updateProjectionMatrix();
    renderer.setSize( window.innerWidth, window.innerHeight - 74 );
}

