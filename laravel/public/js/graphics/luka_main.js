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
	//var material = new THREE.MeshLambertMaterial( { color: 0x00ff00 } );
	

	//Create floor
	var floor_geometry = new THREE.PlaneGeometry( 10, 5, 20, 20);
	var floor_texture = THREE.ImageUtils.loadTexture("images/textures/floor_texture.jpg");
	floor_texture.wrapS = floor_texture.wrapT = THREE.RepeatWrapping;
	floor_texture.repeat.set(10, 5);
	var floor_material = new THREE.MeshLambertMaterial({map: floor_texture, side: THREE.DoubleSide});
	var floor = new THREE.Mesh( floor_geometry, floor_material );
	floor.rotation.x = 90;

	scene.add(floor);
}

function luka_update()
{
	//camera.rotation.y += 0.01;
}

//TODO PROJEKT RG
//Add texture loading (easy, three.js has)
//Add .obj loading (For objects, duhhh, buildin)
//Add HUD, to show weather data
//Construct balkon with forest or w/e
//Basic moving around
//Add some fancy effects