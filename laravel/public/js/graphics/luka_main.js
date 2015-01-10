function luka_init()
{
	//TODO SPLIT STUFF INTO MORE FILES, THEN CALL FROM main.js
	//Create text HUD
	/*
	var city_name_span = document.createElement("span");
	var city_name_hud = document.createTextNode(data_blob.city_name);
	city_name_span.appendChild(city_name_hud);
	city_name_span.style.color = "#FFFFFF";
	city_name_span.style.position = "fixed";
	city_name_span.style.left = renderer.domElement.style.left;
	document.getElementById("main_view").appendChild(city_name_span);
	*/

	//Create basic cube
	var geometry = new THREE.BoxGeometry( 1, 1, 1 );
	var material = new THREE.MeshPhongMaterial( { color: 0x00ff00 } );
	var cube = new THREE.Mesh( geometry, material );

	scene.add(cube);

	//Move camera
	camera.position.z = 5;
}

function luka_update()
{
	camera.position.z += 0.001;
}

//TODO PROJEKT RG
//Add texture loading (easy, three.js has)
//Add .obj loading (For objects, duhhh, buildin)
//Add HUD, to show weather data
//Construct balkon with forest or w/e
//Basic moving around
//Add some fancy effects