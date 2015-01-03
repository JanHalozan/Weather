//TODO SPLIT STUFF INTO MORE FILES, THEN CALL FROM main.js

var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera( 75, (window.innerWidth/2) / (window.innerHeight / 1.5), 0.1, 1000 );

//Create the renderer and add him a canvas to page
var renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth / 2, window.innerHeight / 1.5 );
document.getElementById("main_view").appendChild( renderer.domElement );

//Create ambient and point light, good nuff
var ambient_light = new THREE.AmbientLight(0x333333)
var point_light = new THREE.PointLight(0xFFFFFF);
point_light.position.x = 50;
point_light.position.y = 50;
point_light.position.z = 50;
scene.add(point_light);
scene.add(ambient_light);

//Create basic cube
var geometry = new THREE.BoxGeometry( 1, 1, 1 );
var material = new THREE.MeshPhongMaterial( { color: 0x00ff00 } );
var cube = new THREE.Mesh( geometry, material );

//TODO PROJEKT RG
//Add texture loading (easy, three.js has)
//Add .obj loading (For objects, duhhh, buildin)
//Add HUD, to show weather data
//Construct balkon with forest or w/e
//Basic moving around
//Add some fancy effects

scene.add( cube );

camera.position.z = 5;

//Main render function, called at 60FPS
var render = function () {
	requestAnimationFrame( render );

	cube.rotation.x += 0.05;
	cube.rotation.y += 0.05;

	renderer.render(scene, camera);
};	

render();