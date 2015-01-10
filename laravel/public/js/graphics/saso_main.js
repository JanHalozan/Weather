
/* 
 + GLOBALNE SPREMENLJIVKE IN FUNKCIJE
*/

var snezinke = []; 

function getRandom(min, max) {
  return Math.random() * (max - min) + min;
}

function initSnezinke(stSnezink) {

	// Textura in geometry za snežinko
	var snezinkaTexture = THREE.ImageUtils.loadTexture("images/textures/snezinka.png");
	var snezinkaGeometry = new THREE.PlaneGeometry( 0.4, 0.4);

	// Materiali različnih prosojnosti za snežinke
	var snezinkaMaterial05 = new THREE.MeshLambertMaterial({
		map:snezinkaTexture, 
		transparent:true, 
		opacity:0.1});

	var snezinkaMaterial06 = new THREE.MeshLambertMaterial({
		map:snezinkaTexture, 
		transparent:true, 
		opacity:0.3});

	var snezinkaMaterial07 = new THREE.MeshLambertMaterial({
		map:snezinkaTexture,
		transparent:true, 
	 	opacity:0.5});

	var snezinkaMaterial08 = new THREE.MeshLambertMaterial({
		map:snezinkaTexture,
		transparent:true, 
	 	opacity:0.7});
	
	// Različne snežinke
	snezinke[0] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial05 );
	snezinke[1] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial06 );
	snezinke[2] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial07 );
	snezinke[3] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial08 );

	snezinke[0].position.x = getRandom(-10,10);
	snezinke[1].position.x = getRandom(-10,10);
	snezinke[2].position.x = getRandom(-10,10);
	snezinke[3].position.x = getRandom(-10,10);

	scene.add(snezinke[0]);
	scene.add(snezinke[1]);
	scene.add(snezinke[2]);
	scene.add(snezinke[3]);
	
}

/* 
 - GLOBALNE SPREMENLJIVKE IN FUNKCIJE
*/

function saso_init() 
{
	initSnezinke();
}

function saso_update()
{

}