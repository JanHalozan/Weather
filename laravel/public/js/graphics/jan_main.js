

var rockMesh;
var treeMesh;
var houseMesh;

function jan_init() 
{
	var loader = new THREE.OBJLoader();

	loader.load("models/tree.obj", function(object){

		// var texture = THREE.ImageUtils.loadTexture("images/textures/tree_tex.png");
		// texture.wrapS = texture.wrapT = THREE.RepeatWrapping;
		// texture.repeat.set(50, 50);

		var manager = new THREE.LoadingManager();
		manager.onProgress = function ( item, loaded, total ) {
    		console.log( item, loaded, total );
		};
		
		var texture = new THREE.Texture();
		var imageLoader = new THREE.ImageLoader(manager);
		imageLoader.load( 'images/textures/tree_tex.png', function ( image ) {
    		texture.image = image;
    		texture.needsUpdate = true;
		} );

		//var material = new THREE.MeshLambertMaterial({map: texture, side: THREE.DoubleSide});

		// object.traverse(function(child){
		// 	if (child instanceof THREE.Mesh)
		// 	{
		// 		child.material = material;
		// 		console.log(texture);
		// 	}
		// });

		object.traverse(function(child){
        if (child instanceof THREE.Mesh){
            child.material.map = texture;
        }
    });

		object.position.x = 5;
		object.position.y = 0;
		object.position.z = 5;
		object.scale.set(0.01, 0.01, 0.01);

		scene.add(object);
	});
}

function jan_update()
{

}