var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera( 75, (window.innerWidth/2) / (window.innerHeight / 1.5), 0.1, 1000 );

//Create the renderer and add him a canvas to page
var renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth / 2, window.innerHeight / 1.5 );
document.getElementById("main_view").appendChild( renderer.domElement );

var geometry = new THREE.BoxGeometry( 1, 1, 1 );
var material = new THREE.MeshBasicMaterial( { color: 0x00ff00 } );
var cube = new THREE.Mesh( geometry, material );
scene.add( cube );

camera.position.z = 5;

var render = function () {
	requestAnimationFrame( render );

	cube.rotation.x += 0.1;
	cube.rotation.y += 0.1;

	renderer.render(scene, camera);
};	

render();