

var rockMesh;
var treeMesh;
var houseMesh;

var seed = 2;
var snowyTrees = false;

var trees = [];
var snowyTexture;
var normalTexture;
var needsTextureUpdate = false;

var grassPresent = true;
var grassMeshes = [];

function random()
{
    var x = Math.sin(seed++) * 10000;
    return x - Math.floor(x);
}

function jan_init() 
{
	var loader = new THREE.OBJLoader();
	var manager = new THREE.LoadingManager();
	var imageLoader = new THREE.ImageLoader(manager);

	loader.load("models/tree.obj", function(object){
		
		normalTexture = new THREE.Texture();
		snowyTexture = new THREE.Texture();

		imageLoader.load( 'images/textures/tree_tex.png', function(image){
    		normalTexture.image = image;
    		normalTexture.needsUpdate = true;
		});

		imageLoader.load('images/textures/tree_snowy_tex.png', function(image){
			snowyTexture.image = image;
			snowyTexture.needsUpdate = true;
		});

		object.traverse(function(child){
        	if (child instanceof THREE.Mesh)
        	{
        		child.castShadow = true;
            	child.material.map = normalTexture;
            }
    	});

		object.castShadow = true;
		for (var i = 0; i < 50; ++i)
		{
			var tree = object.clone();
			tree.scale.set(0.5, 0.5, 0.5);
			tree.position.set(-Math.round(random() * 20) + 10, 0, -Math.round(random() * 40) - 2);
			scene.add(tree);
			trees[trees.length] = tree;
		}
	});

	loader.load("models/house.obj", function(object){
		var texture = new THREE.Texture();
		
		imageLoader.load("images/textures/farm_tex.jpg", function(image){
			texture.image = image;
			texture.needsUpdate = true;
		});
		

		object.traverse(function(child){
			if (child instanceof THREE.Mesh)
			{
				child.castShadow = true;
				child.material.map = texture;
				child.material.side = THREE.DoubleSide;
			}
		})

		object.position.set(13, 0, -12);
		object.scale.set(1.5, 1.5, 1.5);
		object.rotation.set(0, 0, 0);
		scene.add(object);

		var objectCopy = object.clone();
		objectCopy.position.set(-15, 0, -5);
		objectCopy.rotation.set(0, -Math.PI * 0.5, 0);
		scene.add(objectCopy);
	});

	var fenceFrontGeometry = new THREE.PlaneGeometry(5, 0.5);
	var texture = new THREE.ImageUtils.loadTexture("images/textures/fence_tex.jpg");
	var fenceMaterial = new THREE.MeshLambertMaterial( {map: texture, side:THREE.DoubleSide} );
	var plane = new THREE.Mesh(fenceFrontGeometry, fenceMaterial);
	plane.castShadow = true;

	plane.position.set(0, 0.45, -1.25);

	scene.add(plane);

	var fenceSideGeometry = new THREE.PlaneGeometry(2.5, 0.5);
	var leftFence = new THREE.Mesh(fenceSideGeometry, fenceMaterial);
	leftFence.position.set(-2.5, 0.45, 0);
	leftFence.rotation.set(0, Math.PI * 0.5, 0);
	leftFence.castShadow = true;

	scene.add(leftFence);

	var rightFence = new THREE.Mesh(fenceSideGeometry, fenceMaterial);
	rightFence.position.set(2.5, 0.45, 0);
	rightFence.rotation.set(0, -(Math.PI * 0.5), 0);
	rightFence.castShadow = true;

	scene.add(rightFence);

	var backHouseGeometry = new THREE.PlaneGeometry(10, 5);
	var houseTexture = THREE.ImageUtils.loadTexture("images/textures/back_house_tex.jpg");
	var houseMaterial = new THREE.MeshLambertMaterial({map: houseTexture, side: THREE.DoubleSide});
	var housePlane = new THREE.Mesh(backHouseGeometry, houseMaterial);

	housePlane.position.set(-0.55, 2.5, 1.25);
	housePlane.rotation.set(Math.PI, 0, Math.PI);

	scene.add(housePlane);

	var skyboxGeometry = new THREE.BoxGeometry(60, 20, 60);
	var skyboxTexture = new THREE.ImageUtils.loadTexture("images/textures/skybox.jpg");
	var skyboxMaterial = new THREE.MeshBasicMaterial({color: 0x5C97BF, side:THREE.BackSide, map: skyboxTexture});
	var skyboxMesh = new THREE.Mesh(skyboxGeometry, skyboxMaterial);
	skyboxMesh.position.y = 9.5;
	scene.add(skyboxMesh);

	//Hides the top fucked up side of the box
	var skyGeometry = new THREE.PlaneGeometry(75, 75);
	var skyMaterial = new THREE.MeshBasicMaterial({color: 0x2c60a5, side:THREE.DoubleSide});
	var skyMesh = new THREE.Mesh(skyGeometry, skyMaterial);
	skyMesh.position.set(0, 19.4, 0);
	skyMesh.rotation.set(Math.PI * 0.5, 0, 0);
	scene.add(skyMesh);

	var grassGeometry = new THREE.PlaneGeometry(1, 1);
	var grassTexture = new THREE.ImageUtils.loadTexture("images/textures/grass.png");
	var grassMaterial = new THREE.MeshBasicMaterial({side: THREE.DoubleSide, map: grassTexture, transparent: true, opacity: 0.5});
	var grassMesh = new THREE.Mesh(grassGeometry, grassMaterial);
	grassMesh.position.set(0, 0, -5);
	scene.add(grassMesh);
	grassMeshes[grassMeshes.length] = grassMesh;

	for (var i = 0; i < 1000; ++i)
	{
		var obj = grassMesh.clone();
		obj.position.set(random() * 40 - 20, 0, random() * 20 - 22);
		scene.add(obj);
		grassMeshes[grassMeshes.length] = obj;
	}

	for (var i = 0; i < 200; ++i)
	{
		var obj = grassMesh.clone();
		obj.position.set(-random() * 20 - 3, 0, random() * 5 - 5);
		scene.add(obj);
		grassMeshes[grassMeshes.length] = obj;
	}

	for (var i = 0; i < 200; ++i)
	{
		var obj = grassMesh.clone();
		obj.position.set(random() * 20 + 3, 0, random() * 5 - 5);
		scene.add(obj);
		grassMeshes[grassMeshes.length] = obj;
	}
}

function toggleGrass()
{
	if (grassPresent)
	{
		for (var i = 0; i < grassMeshes.length; ++i)
			scene.remove(grassMeshes[i]);

		grassPresent = false;
	}
	else
	{
		for (var i = 0; i < grassMeshes.length; ++i)
			scene.add(grassMeshes[i]);

		grassPresent = true;
	}
}

function jan_update()
{
	if (needsTextureUpdate)
	{
		for (var i = 0; i < trees.length; ++i)
		{
			trees[i].traverse(function(child){
        	if (child instanceof THREE.Mesh)
            	child.material.map = snowyTrees ? snowyTexture : normalTexture;
            	snowyTexture.needsUpdate = true;
    		});
		}

		needsTextureUpdate = false;
	}

	if (zastavica)
	{
		if (grassPresent) toggleGrass();
		if (!snowyTrees)
		{
			snowyTrees = !snowyTrees;
			needsTextureUpdate = true;
		}
	}
	else
	{
		if (!grassPresent) toggleGrass();
		if (snowyTrees)
		{
			snowyTrees = !snowyTrees;
			needsTextureUpdate = true;
		}
	}
}