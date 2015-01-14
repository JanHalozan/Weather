

var rockMesh;
var treeMesh;
var houseMesh;

function jan_init() 
{
	var loader = new THREE.ObjectLoader();

	loader.load("models/tree.obj", function(object, materials){

		var texture = THREE.ImageUtils.loadTexture("images/textures/tree_tex.png");
		texture.wrapS = texture.wrapT = THREE.RepeatWrapping;
		texture.repeat.set(50, 50);

		var material = new THREE.MeshLambertMaterial({map: texture, side: THREE.DoubleSide});

		object.traverse(function(child){
			if (child instanceof THREE.Mesh)
				child.material = material;
		});

		object.position.x = 5;
		object.position.y = 0;
		object.position.z = 5;

		scene.add(object);
	});
}

function jan_update()
{

}