
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
	var snezinkaMaterial05 = new THREE.MeshBasicMaterial({
		map:snezinkaTexture, 
		transparent:true, 
		opacity:0.1});

	var snezinkaMaterial06 = new THREE.MeshBasicMaterial({
		map:snezinkaTexture, 
		transparent:true, 
		opacity:0.3});

	var snezinkaMaterial07 = new THREE.MeshBasicMaterial({
		map:snezinkaTexture,
		transparent:true, 
	 	opacity:0.5});

	var snezinkaMaterial08 = new THREE.MeshBasicMaterial({
		map:snezinkaTexture,
		transparent:true, 
	 	opacity:0.7});
	
	for(var i = 0; i < stSnezink; i++){
		// Različne snežinke
		if(i % 4 == 0)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial08 );
		else if(i % 4 == 1)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial06 );
		else if(i % 4 == 2)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial07 );
		else if(i % 4 == 3)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial05 );	
		
		snezinke[i].position.x = getRandom(-15,15);
		snezinke[i].position.z = getRandom(-10,-15);
		snezinke[i].position.y = getRandom(-15,15);

		scene.add(snezinke[i]);
	}	
}

function padanjeSnezink(stSnezink) {
	for(var i = 0; i < stSnezink; i++){			
		snezinke[i].position.x += getRandom(-0.01,0.01);
		snezinke[i].position.y -= 0.05;
		if(snezinke[i].position.y < -15.0)
			snezinke[i].position.y = 15;
	}
}

/* 
 - GLOBALNE SPREMENLJIVKE IN FUNKCIJE
*/

function saso_init() 
{
	initSnezinke(500);
}

function saso_update()
{
	padanjeSnezink(500);
}