
/* 
 + GLOBALNE SPREMENLJIVKE IN FUNKCIJE
*/

function getRandom(min, max) {
  return Math.random() * (max - min) + min;
}

function initSnezinke(stSnezink, minX, maxX, minY, maxY, minZ, maxZ) {
	// Textura in geometry za snežinko
	var snezinkaTexture = THREE.ImageUtils.loadTexture("images/textures/snezinka.png");
	var snezinkaGeometry = new THREE.PlaneGeometry(velikostSnezinke, velikostSnezinke);

	// Materiali različnih prosojnosti za snežinke
	var snezinkaMaterial1 = new THREE.MeshBasicMaterial({
		map:snezinkaTexture, 
		transparent:true, 
		opacity:0.2});

	var snezinkaMaterial2 = new THREE.MeshBasicMaterial({
		map:snezinkaTexture, 
		transparent:true, 
		opacity:0.4});

	var snezinkaMaterial3 = new THREE.MeshBasicMaterial({
		map:snezinkaTexture,
		transparent:true, 
	 	opacity:0.6});

	var snezinkaMaterial4 = new THREE.MeshBasicMaterial({
		map:snezinkaTexture,
		transparent:true, 
	 	opacity:0.8});
	
	for(var i = 0; i < stSnezink; i++){
		// Različne snežinke
		if(i % 4 == 0)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial1 );
		else if(i % 4 == 1)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial2 );
		else if(i % 4 == 2)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial3 );
		else if(i % 4 == 3)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial4 );	
		
		snezinke[i].position.x = getRandom(minX, maxX);
		snezinke[i].position.y = getRandom(minY, maxY);
		snezinke[i].position.z = getRandom(minZ, maxZ);

		scene.add(snezinke[i]);
	}	
}

function padanjeSnezink(stSnezink, hitrostPadanja, mocVetra, minY, maxY, minX, maxX) {
	for(var i = 0; i < stSnezink; i++){

		// Padanje dol po y
		snezinke[i].position.y -= hitrostPadanja;

		// Premikanje v desno
		if(i % 4 == 0)
			snezinke[i].position.x += mocVetra;
		else if(i % 4 == 1)
			snezinke[i].position.x += mocVetra - 0.002;
		else if(i % 4 == 2)
			snezinke[i].position.x += mocVetra - 0.004;
		else if(i % 4 == 3)
			snezinke[i].position.x += mocVetra - 0.006;
		
		if(snezinke[i].position.y < minY)
			snezinke[i].position.y = maxY;

		if(snezinke[i].position.x > maxX)
			snezinke[i].position.x = minX;

		else if(snezinke[i].position.x < minX)
			snezinke[i].position.x = maxX;
	}
}

var snezinke = []; 
var stSnezink = 1350;
var velikostSnezinke = 0.13;
var minX = -15, maxX = 15;
var minY = 0, maxY = 10;
var minZ = -12, maxZ = -1;
var hitrostPadanja = 0.03;
var mocVetra = 0.005;

/* 
 - GLOBALNE SPREMENLJIVKE IN FUNKCIJE
*/

function saso_init() 
{
	initSnezinke(stSnezink, minX, maxX, minY, maxY, minZ, maxZ);
}

function saso_update()
{
	padanjeSnezink(stSnezink, hitrostPadanja, mocVetra, minY, maxY, minX, maxX);
}