
/* 
 + GLOBALNE SPREMENLJIVKE
*/

var snezinke = [];
var maxStSnezink = 3000; 
var stSnezink = 900;
var velikostSnezinke = 0.13;
var minX = -15, maxX = 15;
var minY = 0, maxY = 10;
var minZ = -24, maxZ = -1;
var hitrostPadanja = 0.03;
var mocVetra = 0.005;
var fogDensity = 0.1;
var cameraLook;

var zastavica = 0;
var isKeyPresed = 0;

/* 
 - GLOBALNE SPREMENLJIVKE
*/

function saso_init() 
{
	// SNEG
	initSnezinke(maxStSnezink, minX, maxX, minY, maxY, minZ, maxZ);
	scene.fog.density = 0;

	// MISKA
	// Lock request za miško
	canvas.onclick = canvas.requestPointerLock || canvas.mozRequestPointerLock || canvas.webkitRequestPointerLock;
	
	document.addEventListener( 'mousemove', premikanjeMiske, false );

	cameraLook = new THREE.Vector3(0,1,0);
}

function saso_update()
{
	if (keyboard.pressed('9')) {
		if(isKeyPresed == 0) {
			if(zastavica == 0) {
				zastavica = 1;
				scene.fog.density = fogDensity;
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
			if(stSnezink < maxStSnezink - 100)
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

	// Basic movement
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
}

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
		for(var j = 0; j < 4; j++) {
			// Različne snežinke
			if(i % 4 == j)
				snezinke[i] = new THREE.Mesh( snezinkaGeometry, snezinkaMaterial[j] );
		}
		
		snezinke[i].position.x = getRandom(minX, maxX);
		snezinke[i].position.y = getRandom(minY, maxY);
		snezinke[i].position.z = getRandom(minZ, maxZ);
	}	

	scene.fog = new THREE.FogExp2(0x5C97BF, fogDensity);
}

function padanjeSnezink(stSnezink, hitrostPadanja, mocVetra, minY, maxY, minX, maxX) {
	for(var i = 0; i < stSnezink; i++){

		// Padanje dol po y
		snezinke[i].position.y -= hitrostPadanja;

		for(var j = 0; j < 4; j++) {
			if(i % 4 == j)
				snezinke[i].position.x += mocVetra - 0.002*j;
		}
		
		if(snezinke[i].position.y < minY)
			snezinke[i].position.y = maxY;

		if(snezinke[i].position.x > maxX)
			snezinke[i].position.x = minX;

		else if(snezinke[i].position.x < minX)
			snezinke[i].position.x = maxX;
	}
}

var X = 0;
var Y = 1;

function premikanjeMiske( event ) {
	if( document.pointerLockElement === canvas || 
		document.mozPointerLockElement === canvas ||
  		document.webkitPointerLockElement === canvas) {

		X -= (event.movementX || event.mozMovementX || event.webkitMovementX || 0)/10;
		Y -= (event.movementY || event.mozMovementY || event.webkitMovementY || 0)/1000;

		
		// Lock pogleda navzgor
		if(Y > 90)
			Y = 90;
		else if (Y < -90)
			Y = -90;

		// Reset če gre krog okoli
		if(X > 360 || X < -360)
			X = 0;

		cameraLook.y = 1;
		camera.lookAt(cameraLook);

		// Koti so v radianih, moje meritve pa v stopinjah zato je tukaj pretvorba
		camera.rotation.y = X * Math.PI / 180;
	}
}