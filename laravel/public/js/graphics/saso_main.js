
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


	var snezinkaMaterial = [];

	// Materiali različnih prosojnosti za snežinke
	for(var i = 1; i < 5; i++) {
		snezinkaMaterial[i-1] = new THREE.MeshBasicMaterial({
			map:snezinkaTexture, 
			transparent:true, 
			opacity:(0.2*i)});
	}
	
	for(var i = 0; i < stSnezink; i++){
		// Različne snežinke
		if(i % 4 == 0)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial[0] );
		else if(i % 4 == 1)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial[1] );
		else if(i % 4 == 2)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial[2] );
		else if(i % 4 == 3)
			snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial[3] );	
		
		snezinke[i].position.x = getRandom(minX, maxX);
		snezinke[i].position.y = getRandom(minY, maxY);
		snezinke[i].position.z = getRandom(minZ, maxZ);
	}	

	scene.fog = new THREE.FogExp2(0x5C97BF, 0.12);
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
var maxStSnezink = 3000; 
var stSnezink = 900;
var velikostSnezinke = 0.13;
var minX = -15, maxX = 15;
var minY = 0, maxY = 10;
var minZ = -12, maxZ = -1;
var hitrostPadanja = 0.03;
var mocVetra = 0.005;

var zastavica = 0;
var isKeyPresed = 0;

/* 
 - GLOBALNE SPREMENLJIVKE IN FUNKCIJE
*/

function saso_init() 
{
	initSnezinke(maxStSnezink, minX, maxX, minY, maxY, minZ, maxZ);
	scene.fog.density = 0;
}

function saso_update()
{
	if (keyboard.pressed('9')) {
		if(isKeyPresed == 0) {
			if(zastavica == 0) {
				zastavica = 1;
				scene.fog.density = 0.12;
				for(var i = 0; i < stSnezink; i++)
					scene.add(snezinke[i]);
			}
			else {
				zastavica = 0;
				scene.fog.density = 0;
				for(var i = 0; i < stSnezink; i++)
					scene.remove(snezinke[i]);
			}
		}
		isKeyPresed = 1;
	} 
	else if (keyboard.pressed('m')) {
		if(isKeyPresed == 0) {
			if(stSnezink < 2900)
				stSnezink += 100;
			for(var i = 0; i < 100; i++)
				scene.add(snezinke[i + (stSnezink - 100)]);
		}
		isKeyPresed = 1;
	}
	else if (keyboard.pressed('n')) {
		if(isKeyPresed == 0) {
			if(stSnezink > 200)
				stSnezink -= 100;
			for(var i = 0; i < 100; i++)
				scene.remove(snezinke[i+stSnezink]);
		}
		isKeyPresed = 1;
	}  
	else {
		isKeyPresed = 0;
	}



	if(zastavica == 1)
		padanjeSnezink(stSnezink, hitrostPadanja, mocVetra, minY, maxY, minX, maxX);
}