
/* 
 + GLOBALNE SPREMENLJIVKE
*/

var snezinke = [];
var grass_mesh_snow;
var maxStSnezink = 3000; 
var stSnezink = 1400;
var velikostSnezinke = 0.13;
var SnegMinX = -15; 
var SnegMaxX = 15;
var SnegMinY = 0; 
var SnegMaxY = 10;
var SnegMinZ = -24; 
var SnegMaxZ = 10;
var hitrostPadanja = 0.03;
var mocVetra = 0.005;
var fogDensity = 0.1;
var vektorPogleda;

// Za hojo in simulacijo korakanja
var hitrostHoje = 0.05;
var hoja = 1;
var counter = 0;

// omejitev hoje
var maxLevo = -2.49;
var maxDesno = 2.49;
var maxNaprej = -1.24;
var maxNazaj = 0.99;

// Za tipke, zaznava enkratnega klika
var isKeyPresed = 0;

// Za pogled kamere
var X = 90;
var Y = 0;

// Zvočni efekt
var audioSnow;

/* 
 - GLOBALNE SPREMENLJIVKE
*/

function saso_init() 
{
	// SNEG
	initSnezinke(maxStSnezink, SnegMinX, SnegMaxX, SnegMinY, SnegMaxY, SnegMinZ, SnegMaxZ);
	scene.fog.density = 0;

	// Zasnežena trava
	var grass_geometry = new THREE.PlaneGeometry(100, 50, 20, 20);
	var grass_texture = THREE.ImageUtils.loadTexture("images/textures/grass_texture_snow.jpg");
	grass_texture.wrapS = grass_texture.wrapT = THREE.RepeatWrapping;
	grass_texture.repeat.set(150, 50);
	var grass_material = new THREE.MeshLambertMaterial({map: grass_texture, side: THREE.DoubleSide});
	grass_mesh_snow = new THREE.Mesh( grass_geometry, grass_material );
	grass_mesh_snow.rotation.x = Math.PI/2;
	grass_mesh_snow.position.z = -8;

	// MISKA
	// Vektor pogleda
	vektorPogleda = new THREE.Vector3( 0, 0, 0 );

	// Lock request za miško
	canvas.onclick = canvas.requestPointerLock || canvas.mozRequestPointerLock || canvas.webkitRequestPointerLock;
	
	document.addEventListener( 'mousemove', premikanjeMiske, false );

	// Inicializacija zvočnega efekta
	audioSnow = new Audio("sounds/snow.mp3");
	audioSnow.loop = true;

	if(data_blob.condition_code == "snow"){
		zastavica = 1;
		scene.fog.density = fogDensity;
		scene.add(grass_mesh_snow);
		scene.remove(grass_mesh);
		for(var i = 0; i < stSnezink; i++)
			scene.add(snezinke[i]);
	}
}

function saso_update()
{
	if (keyboard.pressed('b')) {
		if (isKeyPresed == 0) {
			if (zastavica == 0) {
				zastavica = 1;
				scene.fog.density = fogDensity;
				scene.add(grass_mesh_snow);
				scene.remove(grass_mesh);
				// Zvočni efekt - ustavi vse druge svojega predvaja
				snowSoundEffect(true);
				for(var i = 0; i < stSnezink; i++)
					scene.add(snezinke[i]);
			}
			else {
				zastavica = 0;
				scene.fog.density = 0;
				scene.add(grass_mesh);
				scene.remove(grass_mesh_snow);
				// Ustavim zvočni efekt
				snowSoundEffect(false);
				for(var i = 0; i < stSnezink; i++)
					scene.remove(snezinke[i]);
			}
		}
		isKeyPresed = 1;
	} 
	else if (keyboard.pressed('m')) {
		if (isKeyPresed == 0) {
			if(stSnezink < maxStSnezink - 100)
				stSnezink += 100;
			for(var i = 0; i < 100; i++)
				scene.add(snezinke[i + (stSnezink - 100)]);
		}
		isKeyPresed = 1;
	}
	else if (keyboard.pressed('n')) {
		if (isKeyPresed == 0) {
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

	if(zastavica == 1) {
		if (keyboard.pressed('right')) {
			if(mocVetra < 0.1)
				mocVetra += 0.001;
		}
		else if (keyboard.pressed('left')) {
			if(mocVetra > -0.1)
				mocVetra -= 0.001;
		} 
	}	 

	if (zastavica == 1)
		padanjeSnezink(stSnezink, hitrostPadanja, mocVetra, SnegMinY, SnegMaxY, SnegMinX, SnegMaxX, SnegMinZ, SnegMaxZ);

	premikanjeTipkovnica(maxLevo, maxDesno, maxNaprej, maxNazaj);
}

function getRandom(min, max) {
  	return Math.random() * (max - min) + min;
}

function initSnezinke(stSnezink, SnegMinX, SnegMaxX, SnegMinY, SnegMaxY, SnegMinZ, SnegMaxZ) {
	// Textura in geometry za snežinko
	var snezinkaTexture = THREE.ImageUtils.loadTexture("images/textures/snezinka.png");
	var snezinkaGeometry = new THREE.PlaneGeometry(velikostSnezinke,velikostSnezinke);


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
		
		snezinke[i].position.x = getRandom(SnegMinX, SnegMaxX);
		snezinke[i].position.y = getRandom(SnegMinY, SnegMaxY);
		snezinke[i].position.z = getRandom(SnegMinZ, SnegMaxZ);
	}	

	scene.fog = new THREE.FogExp2(0x5C97BF, fogDensity);
}

function padanjeSnezink(stSnezink, hitrostPadanja, mocVetra, SnegMinY, SnegMaxY, SnegMinX, SnegMaxX) {
	for(var i = 0; i < stSnezink; i++){

		// Padanje dol po y
		snezinke[i].position.y -= hitrostPadanja;

		for(var j = 0; j < 4; j++) {
			if(i % 4 == j)
				snezinke[i].position.x += mocVetra - 0.002*j;
		}
		
		// Vedno pravokotno na pogled
		snezinke[i].lookAt(camera.position);

		// Če grejo iven polja
		if(snezinke[i].position.y < SnegMinY)
			snezinke[i].position.y = SnegMaxY;

		if(snezinke[i].position.x > SnegMaxX)
			snezinke[i].position.x = SnegMinX;

		else if(snezinke[i].position.x < SnegMinX)
			snezinke[i].position.x = SnegMaxX;
	}
}

function premikanjeMiske( event ) {
	if( document.pointerLockElement === canvas || 
		document.mozPointerLockElement === canvas ||
  		document.webkitPointerLockElement === canvas ) {

		X -= (event.movementX || event.mozMovementX || event.webkitMovementX || 0)/10;
		Y -= (event.movementY || event.mozMovementY || event.webkitMovementY || 0)/10;
		
		// Lock pogleda navzgor / navzdol
		if(Y > 80)
			Y = 80;
		else if (Y < -80)
			Y = -80;

		// Reset če gre krog okoli
		if(X > 360 || X < -360)
			X = 0;

		var beta = (Y)*Math.PI/180;
		var alfa = (X-180)*Math.PI/180;

		// Koti so v radianih, moje meritve pa v stopinjah zato je tukaj pretvorba
		// 1000 pomeni radij
		vektorPogleda.x = -1000 * Math.cos(beta) * Math.cos(alfa);
		vektorPogleda.y = 1000 * Math.sin(beta);
		vektorPogleda.z = 1000 * Math.cos(beta) * Math.sin(alfa);

		camera.lookAt(vektorPogleda);
	}
}

function premikanjeTipkovnica(maxLevo, maxDesno, maxNaprej, maxNazaj) {
	// Hoja
	if ( document.pointerLockElement === canvas || 
		 document.mozPointerLockElement === canvas ||
  		 document.webkitPointerLockElement === canvas ) {

		if(jeOblacno == false && zastavica == 0 && jeDelnoOblacno == false) {
			if (keyboard.pressed('up') && keyboard.pressed('left')){
				camera.translateZ( -hitrostHoje/1.2 );
				camera.translateX( -hitrostHoje/1.2 );
				simulacijaHoje();
			}
			else if (keyboard.pressed('up') && keyboard.pressed('right')){
				camera.translateZ( -hitrostHoje/1.2 );
				camera.translateX( hitrostHoje/1.2 );
				simulacijaHoje();
			}
			else if (keyboard.pressed('down') && keyboard.pressed('left')){
				camera.translateZ( hitrostHoje/1.2 );
				camera.translateX( -hitrostHoje/1.2 );
				simulacijaHoje();
			}
			else if (keyboard.pressed('down') && keyboard.pressed('right')){
				camera.translateZ( hitrostHoje/1.2 );
				camera.translateX( hitrostHoje/1.2 );
				simulacijaHoje();
			}
			else if (keyboard.pressed('up')) {
				camera.translateZ( -hitrostHoje );
				simulacijaHoje();
			} 
			else if (keyboard.pressed('right')) {
				camera.translateX( hitrostHoje );
				simulacijaHoje();
			} 
			else if (keyboard.pressed('down')) {
				camera.translateZ( hitrostHoje );
				simulacijaHoje();
				
			} 
			else if (keyboard.pressed('left')) {
				camera.translateX( -hitrostHoje );
				simulacijaHoje();
			}
		}

		if (keyboard.pressed('w') && keyboard.pressed('a')){
			camera.translateZ( -hitrostHoje/1.2 );
			camera.translateX( -hitrostHoje/1.2 );
			simulacijaHoje();
		}
		else if (keyboard.pressed('w') && keyboard.pressed('d')){
			camera.translateZ( -hitrostHoje/1.2 );
			camera.translateX( hitrostHoje/1.2 );
			simulacijaHoje();
		}
		else if (keyboard.pressed('s') && keyboard.pressed('a')){
			camera.translateZ( hitrostHoje/1.2 );
			camera.translateX( -hitrostHoje/1.2 );
			simulacijaHoje();
		}
		else if (keyboard.pressed('s') && keyboard.pressed('d')){
			camera.translateZ( hitrostHoje/1.2 );
			camera.translateX( hitrostHoje/1.2 );
			simulacijaHoje();
		}
		else if (keyboard.pressed('w')) {
			camera.translateZ( -hitrostHoje );
			simulacijaHoje();
		} 
		else if (keyboard.pressed('d')) {
			camera.translateX( hitrostHoje );
			simulacijaHoje();
		} 
		else if (keyboard.pressed('s')) {
			camera.translateZ( hitrostHoje );
			simulacijaHoje();
			
		} 
		else if (keyboard.pressed('a')) {
			camera.translateX( -hitrostHoje );
			simulacijaHoje();
		}
	}

	// Omejitev hoje
	if (camera.position.x < maxLevo)
		camera.position.x = maxLevo;
	else if (camera.position.x > maxDesno)
		camera.position.x = maxDesno;
	
	if (camera.position.z > maxNazaj)
		camera.position.z = maxNazaj;
	else if (camera.position.z < maxNaprej)
		camera.position.z = maxNaprej;
}


function simulacijaHoje() {
	// Simulacija hoje
	if(counter < 10)
		hoja += 0.005;
	else if(counter < 20)
		hoja -= 0.005;
	else {
		counter = 0;
		hoja = 1;
	}
	counter++;
	camera.position.y = hoja;
}

function snowSoundEffect(play)
{
    if (play)
    {
        audioClearSky.pause();
        audioRain.pause();
        audioThunder.pause();
        audioSnow.play();
    }
    else
    {
        audioSnow.pause();
        audioClearSky.play();    
    }
}
