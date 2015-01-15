

var rockMesh;
var treeMesh;
var houseMesh;

var seed = 2;
var snowyTrees = false;
var keyDown = false;

var trees = [];
var snowyTexture;
var normalTexture;
var needsTextureUpdate = false;

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
            	child.material.map = normalTexture;
    	});


		for (var i = 0; i < 25; ++i)
		{
			var tree = object.clone();
			tree.scale.set(0.5, 0.5, 0.5);
			tree.position.set(-Math.round(random() * 20) + 10, 0, -Math.round(random() * 20));
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
				child.material.map = texture;
				child.material.side = THREE.DoubleSide;
			}
		})

		object.position.set(3, 0, -10);
		object.scale.set(0.1, 0.1, 0.1);
		object.rotation.set(0, Math.PI, 0);

		scene.add(object);
	});

	var fenceFrontGeometry = new THREE.PlaneGeometry(5, 0.5);
	var plane = new THREE.Mesh(fenceFrontGeometry);
	var texture = new THREE.Texture();
	imageLoader.load("images/textures/fence_tex.jpg", function(image){
		texture.image = image;
		texture.needsUpdate = true;
	});

	plane.material.map = texture;
	plane.position.set(0, 0.45, -1.25);

	scene.add(plane);

	var fenceSideGeometry = new THREE.PlaneGeometry(2.5, 0.5);
	var leftFence = new THREE.Mesh(fenceSideGeometry);
	leftFence.material.map = texture;
	leftFence.position.set(-2.5, 0.45, 0);
	leftFence.rotation.set(0, Math.PI * 0.5, 0);

	scene.add(leftFence);

	var rightFence = new THREE.Mesh(fenceSideGeometry);
	rightFence.material.map = texture;
	rightFence.position.set(2.5, 0.45, 0);
	rightFence.rotation.set(0, -(Math.PI * 0.5), 0);

	scene.add(rightFence);

	var backHouseGeometry = new THREE.PlaneGeometry(10, 10);
	var housePlane = new THREE.Mesh(backHouseGeometry);
	var houseTexture = new THREE.Texture();
	imageLoader.load("images/textures/back_house_tex.jpg", function(image){
		houseTexture.image = image;
		houseTexture.needsUpdate = true;
	});
	housePlane.material.map = houseTexture;
	housePlane.position.set(0, 0, 1.25);
	housePlane.rotation.set(0, Math.PI, 0);

	scene.add(housePlane);
}

function jan_update()
{
	if  (keyboard.pressed('l'))
	{
		if (!keyDown)
		{
			snowyTrees = !snowyTrees;
			needsTextureUpdate = true;
		}

		keyDown = true;
	}
	else
	{
		keyDown = false;
	}

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
}