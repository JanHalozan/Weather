/* scene limits */
var minX = -15,
	maxX = 15,
	minY = 0,
	maxY = 7,
	minZ = -10,
	maxZ = 5;

var temperatureChanged = false;
var temperatureRead = 0;

/* scene related variables */
var rainDrops = [];
var clouds = null;
var thunder = null;

/* rain related variables */
var rainDensity = 2000;
var rainfallSpeed = 0.25;
var isRaining = false;
var fogdensity = 0.075;
var isThunderstorm = false;

/* other variables */
var windSpeed = 0.1;
var isRKeyPressed = false;
var isTKeyPressed = false;
var isNumKeyPressed = false;
var thunderVisible = false;

/* FUNCTIONS */
function initClouds()
{
	var cloudTexture = THREE.ImageUtils.loadTexture("images/textures/cloud.png");
	var cloudPlaneGeometry = new THREE.PlaneGeometry(80.0, 80.0);
	var cloudMaterial = new THREE.MeshBasicMaterial({map:cloudTexture, transparent:true, opacity: 1.4});
	
	clouds = new THREE.Mesh(cloudPlaneGeometry, cloudMaterial);
	clouds.position.x = 5.0;
	clouds.position.y = 8;
	clouds.position.z = 11;
	clouds.rotation.x = 1.5;
}

function initThunder()
{
	var thunderTexture = THREE.ImageUtils.loadTexture("images/textures/bolt.png");
	var thunderGeometry = new THREE.PlaneGeometry(0.8, 8.0);
	var thunderMaterial = new THREE.MeshBasicMaterial({map: thunderTexture, transparent: true});

	thunder = new THREE.Mesh(thunderGeometry, thunderMaterial);
	thunder.position.x = randomNumber(minX, maxX);
	thunder.position.y = 4.0;
	thunder.position.z = -20.0;
}

function initRaindrops() 
{
	var rainTexture = THREE.ImageUtils.loadTexture("images/textures/rain.png");
	var rainPlaneGeometry = new THREE.PlaneGeometry(0.01, 0.08);
	var rainMaterial = new THREE.MeshBasicMaterial({map:rainTexture, transparent: true});
	//var rainMaterial = new THREE.MeshBasicMaterial({color: 0xAAAAAA});
	
	for(var i = 0; i < rainDensity; i++)
	{
		rainDrops[i] = new THREE.Mesh(rainPlaneGeometry, rainMaterial);
		rainDrops[i].position.x = randomNumber(minX, maxX);
		rainDrops[i].position.y = randomNumber(minY, maxY);
		rainDrops[i].position.z = randomNumber(minZ, maxZ);
		rainDrops[i].rotation.z = windSpeed * 2.0;
	}
}

function rainfall(rainDensity, rainfallSpeed, windSpeed) 
{
	for(var i = 0; i < rainDrops.length; i++)
	{
		rainDrops[i].position.y -= rainfallSpeed;
		rainDrops[i].position.x += windSpeed;
		rainDrops[i].rotation.y = (X-90)*Math.PI/180;
		
		if(rainDrops[i].position.y < minY) rainDrops[i].position.y = maxY;
		if(rainDrops[i].position.x > maxX) rainDrops[i].position.x = minX;
		else if(rainDrops[i].position.x < minX) rainDrops[i].position.x = maxX;
	}
}

var audioRain;
var audioThunder;
var tempCount = 0.0;

function randomNumber(low, high) { return Math.random() * (high - low) + low; }

function rainStart()
{
	isRaining = true;
	for(var i = 0; i < rainDrops.length; i++) scene.add(rainDrops[i]);
	scene.add(clouds);

	rainSoundEffect(true);
}

function thunderStrike()
{
	audioThunder.load();
	thunderVisible = true;
	thunderCount = 0;
	thunder.position.x = randomNumber(minX, maxX);
	thunder.rotation.y = (90-X) * Math.PI / 180;

	scene.add(thunder);
}

function zoran_init() 
{
	if (data_blob.condition_code == "shower_rain")
		rainDensity = 3000;

	initRaindrops();
	initClouds();
	initThunder();

	// sound effects
	audioRain = new Audio("sounds/rain.mp3");
	audioRain.loop = true;
	audioThunder = new Audio("sounds/thunder.mp3");

	// load weather
	if (data_blob.condition_code == "rain")
	{
		rainStart();
		scene.fog.density = 0.04;
	}
	else if (data_blob.condition_code == "shower_rain")
	{
		rainStart();
		scene.fog.density = fogdensity;
	}
	else if (data_blob.condition_code == "thunderstorm")
	{
		rainStart();
		scene.fog.density = fogdensity;
		isThunderstorm = true;
		setInterval(thunderStrike, 24000);
	}
}

var thunderCount = 0;
var flashMesh;
var flashOpacity;
var flashGeometry = new THREE.BoxGeometry(11.2, 3, 3);

function rainSoundEffect(play)
{
	if (play)
	{
		audioRain.play();
		audioClearSky.pause();
		audioSnow.pause();
	}
	else
	{
		audioRain.pause();
		audioThunder.pause();
		audioClearSky.play();
	}
}

function zoran_update()
{
	if(isRaining)
		rainfall(rainDensity, rainfallSpeed, windSpeed);

	if (thunderVisible)
	{
		audioThunder.play();

		if (thunderCount > 20)
		{
			scene.remove(thunder);
			thunderVisible = false;
			scene.remove(flashMesh);
		}
		else
		{
			scene.remove(flashMesh);
			var flashMaterial = new THREE.MeshBasicMaterial( {color: 0xFFFFFF, side:THREE.BackSide, transparent: true, opacity: 0.6 - (thunderCount / 20.0)} );
			flashMesh = new THREE.Mesh(flashGeometry, flashMaterial);
			flashMesh.position.y = 1.25;
			scene.add(flashMesh);
			thunderCount++;
		}
	}
	
	/*
	if (keyboard.pressed('t')) 
	{
		if(!isTKeyPressed) 
		{
			if(isRaining && !thunderVisible)
			{
				thunderVisible = true;
				thunderCount = 0;
				thunder.position.x = randomNumber(minX, maxX);
				thunder.rotation.y = (90-X) * Math.PI / 180;

				scene.add(thunder);
			}
		}
		
		isTKeyPressed = true;
	} 
	else
		isTKeyPressed = false;
	*/
		
	if (keyboard.pressed('r')) 
	{
		if(!isRKeyPressed) 
		{
			if(!isRaining)
			{
				for(var i = 0; i < rainDrops.length; i++) scene.add(rainDrops[i]);
				scene.add(clouds);

				scene.fog.density = fogdensity;
				rainSoundEffect(true);
			}
			else
			{
				for(var i = 0; i < rainDrops.length; i++) scene.remove(rainDrops[i]);
				scene.remove(clouds);
				scene.remove(thunder);

				scene.fog.density = 0;
				rainSoundEffect(false);
			}
				
			isRaining = !isRaining;
		}
		
		isRKeyPressed = true;
	} 
	else
		isRKeyPressed = false;
	
	/* PLOŠČICA - TEMPERATURA */
	if (keyboard.pressed('0') || keyboard.pressed('1') || keyboard.pressed('2') || keyboard.pressed('3') || keyboard.pressed('4') || keyboard.pressed('5') || keyboard.pressed('6') || keyboard.pressed('7') || keyboard.pressed('8') || keyboard.pressed('9')) 
	{
		if(!isNumKeyPressed) 
		{
			var number;
			if (keyboard.pressed('1')) number = 1.0;
			else if (keyboard.pressed('2'))	number = 2.0;
			else if (keyboard.pressed('3'))	number = 3.0;
			else if (keyboard.pressed('4'))	number = 4.0;
			else if (keyboard.pressed('5'))	number = 5.0;
			else if (keyboard.pressed('6'))	number = 6.0;
			else if (keyboard.pressed('7'))	number = 7.0;
			else if (keyboard.pressed('8'))	number = 8.0;
			else if (keyboard.pressed('9'))	number = 9.0;
			else number = 0.0;

			if (tempCount == 0)
				temperatureRead = number;
			else if (tempCount == 1)
			{
				temperatureRead = temperatureRead * 10.0 + number;
				temperatureChanged = true;
				tempCount = -1;
			}

			tempCount = tempCount + 1;
		}
		
		isNumKeyPressed = true;
	} 
	else
		isNumKeyPressed = false;
}


