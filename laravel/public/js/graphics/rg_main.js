//Call all init functions
luka_init();
jan_init();
fras_init();
saso_init();
zoran_init();


//Main render function, called at 60FPS
var render = function () {
	requestAnimationFrame( render );

	//Call all update functions
	luka_update();
	jan_update();
	fras_update();
	saso_update();
	zoran_update();

	renderer.render(scene, camera);
};	

render();