/* scene limits */
var minX = -15,
	maxX = 15,
	minY = 0,
	maxY = 10,
	minZ = -25,
	maxZ = 0;

/* scene related variables */
var rainDrops = [];
var clouds;

/* rain related variables */
var rainDensity = 1500;
var rainfallSpeed = 0.4;
var isRaining = false;
var fogdensity = 0.075;

/* other variables */
var windSpeed = 0.0;
var isKeyPressed = false;

/* FUNCTIONS */
function initClouds()
{
	var cloudTexture = THREE.ImageUtils.loadTexture("images/textures/cloud.png");
	var cloudPlaneGeometry = new THREE.PlaneGeometry(50.0, 10.0);
	var cloudMaterial = new THREE.MeshBasicMaterial({map:cloudTexture, transparent:true});
	
	clouds = new THREE.Mesh(cloudPlaneGeometry, cloudMaterial);
	clouds.position.x = 0.0;
	clouds.position.y = 7;
	clouds.position.z = -6;
}

function initThunder()
{
	
}

function initRaindrops() 
{
	var rainTexture = THREE.ImageUtils.loadTexture("images/textures/rain.png");
	var rainPlaneGeometry = new THREE.PlaneGeometry(0.02, 0.1);
	var rainMaterial = new THREE.MeshBasicMaterial({map:rainTexture, transparent:true});
	
	for(var i = 0; i < rainDensity; i++)
	{
		rainDrops[i] = new THREE.Mesh(rainPlaneGeometry, rainMaterial);
		rainDrops[i].position.x = randomNumber(minX, maxX);
		rainDrops[i].position.y = randomNumber(minY, maxY);
		rainDrops[i].position.z = randomNumber(minZ, maxZ);
	}
}

function rainfall(rainDensity, rainfallSpeed, windSpeed) 
{
	for(var i = 0; i < rainDrops.length; i++)
	{
		rainDrops[i].position.y -= rainfallSpeed;
		rainDrops[i].position.x += windSpeed;
		
		if(rainDrops[i].position.y < minY) rainDrops[i].position.y = maxY;
		if(rainDrops[i].position.x > maxX) rainDrops[i].position.x = minX;
		else if(rainDrops[i].position.x < minX) rainDrops[i].position.x = maxX;
	}
}

function randomNumber(low, high) { return Math.random() * (high - low) + low; }

function zoran_init() 
{
	initRaindrops();
	initClouds();
	initThunder();
}

function zoran_update()
{
	if(isRaining)
		rainfall(rainDensity, rainfallSpeed, windSpeed);
		
	if (keyboard.pressed('r')) 
	{
		if(!isKeyPressed) 
		{
			if(!isRaining)
			{
				for(var i = 0; i < rainDrops.length; i++) scene.add(rainDrops[i]);
				scene.add(clouds);
				scene.fog.density = fogdensity;
			}
			else
			{
				for(var i = 0; i < rainDrops.length; i++) scene.remove(rainDrops[i]);
				scene.remove(clouds);
				scene.fog.density = 0;
			}
				
			isRaining = !isRaining;
		}
		
		isKeyPressed = true;
	} 
	else
		isKeyPressed = false;
}