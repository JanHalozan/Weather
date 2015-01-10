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
	//var geometry = new THREE.BoxGeometry( 1, 1, 1 );
	//var material = new THREE.MeshLambertMaterial( { color: 0x00ff00 } );
	

	//Create balcon floor
	var floor_geometry = new THREE.BoxGeometry( 5, 2.5, 0.2);
	var floor_texture = THREE.ImageUtils.loadTexture("images/textures/floor_texture.jpg");
	floor_texture.wrapS = floor_texture.wrapT = THREE.RepeatWrapping;
	floor_texture.repeat.set(10, 5);
	var floor_material = new THREE.MeshLambertMaterial({map: floor_texture, side: THREE.DoubleSide});
	var floor_mesh = new THREE.Mesh( floor_geometry, floor_material );
	floor_mesh.rotation.x = 90;
	floor_mesh.position.y = 0.1;

	//Create outside grass
	var grass_geometry = new THREE.PlaneGeometry( 10, 20, 20, 20);
	var grass_texture = THREE.ImageUtils.loadTexture("images/textures/grass_texture.jpg");
	grass_texture.wrapS = grass_texture.wrapT = THREE.RepeatWrapping;
	grass_texture.repeat.set(10, 20);
	var grass_material = new THREE.MeshLambertMaterial({map: grass_texture, side: THREE.DoubleSide});
	var grass_mesh = new THREE.Mesh( grass_geometry, grass_material );
	grass_mesh.rotation.x = 90;

	scene.add(floor_mesh);
	scene.add(grass_mesh);
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