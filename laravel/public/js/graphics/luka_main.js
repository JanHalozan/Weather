function TextElement(text, pos_x, pos_y, pos_z)
{
	//Create text
	var text_geo = new THREE.TextGeometry(String(text), {size: 0.1, height: 0.01} );	
	text_geo.computeBoundingBox();
	var x = text_geo.boundingBox.max.x;
	text_geo.applyMatrix( new THREE.Matrix4().makeTranslation(-text_geo.boundingBox.max.x/2, -text_geo.boundingBox.max.y/2, 0) );
	var mat = new THREE.MeshBasicMaterial( {color: 0xffffff, opacity: 0.7, transparent: true} );
	this.mesh = new THREE.Mesh(text_geo, mat);

	//Create plate
	var floor_geometry = new THREE.BoxGeometry( x + 0.1, text_geo.boundingBox.max.y + 0.1, text_geo.boundingBox.max.z);
	var floor_material = new THREE.MeshBasicMaterial({color: 0x882222, opacity: 0.7, transparent: true});
	this.plate = new THREE.Mesh( floor_geometry, floor_material );

	this.mesh.position.x = pos_x;
	this.mesh.position.y = pos_y;
	this.mesh.position.z = pos_z;

	this.plate.position.x = pos_x;
	this.plate.position.y = pos_y;
	this.plate.position.z = pos_z - 0.001;// + text_geo.boundingBox.max.z/2;

	scene.add(this.mesh);
	scene.add(this.plate);

	this.update = function(){
		this.mesh.lookAt(camera.position);
		this.plate.lookAt(camera.position);
	}
}

var text_elements = new Array();

function luka_init()
{
	var name_hud = document.getElementById("hud_location");
	name_hud.style.left = "20px";
	name_hud.style.top = "50px";

	//Create single color skybox
	var skybox_geometry = new THREE.BoxGeometry(50, 50, 50);
	var skybox_material = new THREE.MeshBasicMaterial( {color: 0x87CEEB, side:THREE.BackSide} );
	var skybox_mesh = new THREE.Mesh(skybox_geometry, skybox_material);
	scene.add(skybox_mesh);

	//Create balcon floor
	var floor_geometry = new THREE.BoxGeometry( 5, 0.2, 2.5);
	var floor_texture = THREE.ImageUtils.loadTexture("images/textures/floor_texture.jpg");
	floor_texture.wrapS = floor_texture.wrapT = THREE.RepeatWrapping;
	floor_texture.repeat.set(10, 5);
	var floor_material = new THREE.MeshLambertMaterial({map: floor_texture, side: THREE.DoubleSide});
	var floor_mesh = new THREE.Mesh( floor_geometry, floor_material );
	floor_mesh.position.y = 0.1;

	//Create outside grass
	var grass_geometry = new THREE.PlaneGeometry(10, 20, 20, 20);
	var grass_texture = THREE.ImageUtils.loadTexture("images/textures/grass_texture.jpg");
	grass_texture.wrapS = grass_texture.wrapT = THREE.RepeatWrapping;
	grass_texture.repeat.set(10, 20);
	var grass_material = new THREE.MeshLambertMaterial({map: grass_texture, side: THREE.DoubleSide});
	var grass_mesh = new THREE.Mesh( grass_geometry, grass_material );
	grass_mesh.rotation.x = Math.PI/2;

	scene.add(floor_mesh);
	scene.add(grass_mesh);

	//Add some elements
	text_elements.push(new TextElement(data_blob.city_name + ', ' + data_blob.country, 1, 1.2, -1));
	text_elements.push(new TextElement(data_blob.condition, 1, 1, -1));
	text_elements.push(new TextElement(data_blob.temperature.toFixed(0) + '°C', 1, 0.8, -1));
	text_elements.push(new TextElement("Much text, so fancy", -1.5, 1, -1));
	text_elements.push(new TextElement("FERIFax™", -1.5, 1.3, -1));

	//Set proper camera position TEMP
	//camera.rotation.x = 0.1;
}

function luka_update()
{
	if (keyboard.pressed('w'))
	{
		camera.position.z += -0.03;
	}
	if (keyboard.pressed('d'))
	{
		camera.position.x += 0.03;
	}
	if (keyboard.pressed('s'))
	{
		camera.position.z += 0.03;
	}
	if (keyboard.pressed('a'))
	{
		camera.position.x += -0.03;
	}

	for (i = 0; i < text_elements.length; ++i)
	{
		text_elements[i].update();
	}

}

//TODO PROJEKT RG
//Add texture loading (easy, three.js has)
//Add .obj loading (For objects, duhhh, buildin)
//Add HUD, to show weather data
//Construct balkon with forest or w/e
//Basic moving around
//Add some fancy effects