function TextElement(text, pos_x, pos_y, pos_z)
{
	//Create text
	var text_geo = new THREE.TextGeometry(String(text), {size: 0.1, height: 0.01, font: "droid sans"} );	
	text_geo.computeBoundingBox();
	var x = text_geo.boundingBox.max.x;
	text_geo.applyMatrix( new THREE.Matrix4().makeTranslation(-text_geo.boundingBox.max.x/2, -text_geo.boundingBox.max.y/2, 0) );
	var mat = new THREE.MeshBasicMaterial( {color: 0xffffff, opacity: 0.7, transparent: true} );
	this.mesh = new THREE.Mesh(text_geo, mat);

	//Create plate
	var floor_geometry = new THREE.BoxGeometry( x + 0.1, text_geo.boundingBox.max.y + 0.1, text_geo.boundingBox.max.z);
	var floor_material = new THREE.MeshBasicMaterial({color: 0x22313F, opacity: 0.7, transparent: true});
	this.plate = new THREE.Mesh( floor_geometry, floor_material );

	this.mesh.position.x = pos_x;
	this.mesh.position.y = pos_y;
	this.mesh.position.z = pos_z;

	this.plate.position.x = pos_x;
	this.plate.position.y = pos_y;
	this.plate.position.z = pos_z - 0.001;// + text_geo.boundingBox.max.z/2;

	scene.add(this.mesh);
	scene.add(this.plate);

	this.update = function(){
		this.mesh.lookAt(camera.position);
		this.plate.lookAt(camera.position);
	}
}

//Precalcualte cos table
var cos_table = new Array();
for (var x = 0; x < 8; ++x)
{
	for (var u = 0; u < 8; ++u)
	{
		cos_table[x + u*8] = Math.cos(((2*x + 1)*u*Math.PI)/16.0);
	}
}

function strToInt(str, size)
{
	var a = "";
	if (str[0] == "1")
	{
		if (size == 1) return -1;
		for (var i = 0; i < size; ++i)
		{
			if (str[i] == '1') a += "0";
			else a += "1";
		}
		return -(parseInt(a.substring(1, size), 2) + 1);
	}
	else
	{
		if (size == 1) return 0;
		return parseInt(str.substring(1, size), 2);
	}
}

function unwrapZigZag(in_data)
{
    var konec = false;
    var x = 0;
    var y = 0;
    var index = 0;

    var data = new Array();

    //Reset table
    for (var i = 0; i < 64; ++i)
    {
        data[i] = 5000;
    }

    do
    {
        data[x + y*8] = in_data[index];
        //Check where to go
        //Leftdown
        if (x>0 && y<7 && data[(x-1) + (y+1)*8]==5000)
        {
            x--; y++;
        }
        //Upright
        else if ((x<7) && (y>0) && (data[(x+1) + (y-1)*8]==5000))
        {
            x++; y--;
        }
        //Right on top and bottom lines
        else if ((x>0) && (x<7))
            x++;
        //Down on left and right lines
        else if ((y>0) && (y<7))
            y++;
        //Right in topleft and bottomleft
        else if (x<7)
            x++;
        else konec = true;
        ++index;
    } while(!konec);

    return data;
}

function C(i)
{
    return i == 0? (1/1.41421356237) : 1;
}

function calculateIDCT(block)
{
    var idct_values = new Array();

    var value = 0;
    for (var y = 0; y < 8; ++y)
    {
        for (var x = 0; x < 8; ++x)
        {
            value = 0;
            for (var v = 0; v < 8; ++v)
            {
                for (var u = 0; u < 8; ++u)
                {
                    value += C(u) * C(v) * (block[u + v*8]) * cos_table[x + u*8] * cos_table[y + v*8];
                }
            }
            value *= 1.0/4.0;
            if (value < -128)
            {
                value = -128;
            }
            else if (value > 127)
            {
                value = 127;
            }
            idct_values[x + y*8] = Math.floor(value);
        }
    }

    return idct_values;
}

function unwrapBlocks(blocks, image_width, image_height)
{
    var pos_x = 0;
    var pos_y = 0;
    var data = new Array();

    for (var i = 0; i < blocks.length; ++i)
    {
        var b = blocks[i];

        for (var y = 0; y < 8; ++y)
        {
            for (var x = 0; x < 8; ++x)
            {
                if (x + pos_x < image_width && y + pos_y < image_height)
                {
                    data[(x + pos_x) + (y + pos_y)*image_width] = b[x + y*8];
                }
            }
        }

        pos_x += 8;
        if (pos_x >= image_width)
        {
            pos_x = 0;
            pos_y += 8;
        }
    }

    return data;
}

var grass_mesh;
var texture = null;

function load_dct(file_name)
{
	var oReq = new XMLHttpRequest();
	var in_stream = "";
	oReq.open("GET", file_name, true);
	oReq.responseType = "arraybuffer";
	

	oReq.onload = function (oEvent) {
	  	var arrayBuffer = oReq.response; // Note: not oReq.responseText
	  	if (arrayBuffer) {
	    	var byteArray = new Uint8Array(arrayBuffer);
	    	for (var i = 0; i < byteArray.byteLength; i++) 
	    	{
	    		// do something with each byte in the array
	    		var n = parseInt(byteArray[i]).toString(2);
	    		while (n.length < 8) n = "0" + n;
	    		in_stream += n;
	    	}
	  	}

	  	//Read image width and height
	  	var image_width = parseInt(in_stream.substring(0, 16), 2);
	  	var image_height = parseInt(in_stream.substring(16, 32), 2);
	  	var pos = 32;

	  	var num_blocks = Math.ceil(image_width/8.0) * Math.ceil(image_height/8.0) * 3;

	  	var blocks = new Array();

	  	for (var i = 0; i < num_blocks; ++i)
	  	{
	  		var data = new Array();
	  		var data_index = 1;
	  		var num_values = 1;

	  		//console.log(in_stream.substring(pos));

	  		//Read DC
	  		//console.log(in_stream.substring(pos, pos+11));
            var dc = strToInt(in_stream.substring(pos, pos+11), 11);
            pos += 11;
            data[0] = dc;

           	

            //Read AC
            while (num_values < 64)
            {
                //a in b tip
                if (in_stream[pos] == "0")
                {
                    pos++;

                    //Preberi tekoco
                    //Dodaj nule
                    var num_null = parseInt(in_stream.substring(pos, pos+6), 2);
                    //console.log(in_stream.substring(pos, pos+6));
                    pos += 6;

                    for (var n = 0; n < num_null; ++n)
                    {
                        data[data_index] = 0;
                        ++data_index;
                    }
                    num_values += num_null;

                    //Check if a tip a or b tip
                    if (num_values < 64)
                    {
                        //Preberi dolzino
                        var l = parseInt(in_stream.substring(pos, pos+4), 2);
                        pos += 4;

                        //Preberi ac
                        var ac = strToInt(in_stream.substring(pos, pos+l), l);
                        pos += l;
                        if (data_index >= 64)
                        {
                            data_index = 0;
                        }
                        data[data_index] = ac;
                        ++data_index;
                        ++num_values;
                    }
                }
                //C tip
                else if (in_stream[pos] == "1")
                {
                   	pos++;
                    //Preberi dolzino
                   	var l = parseInt(in_stream.substring(pos, pos+4), 2);
                    pos += 4;
                    //console.log(l);

                    //preberi ac
                    var ac = strToInt(in_stream.substring(pos, pos+l), l);
                    //console.log(in_stream.substring(pos, pos+l));
                    pos += l;
                    if (data_index >= 64)
                    {
                        data_index = 0;
                    }
                    data[data_index] = ac;
                    //console.log(ac);
                    ++data_index;
                    ++num_values;
                }
            }

            var block_data = unwrapZigZag(data);
            var inverse = calculateIDCT(block_data);
            blocks.push(inverse);
	  	}

	  	//We have blocks
	  	//Divide into 3 sets
	  	var red_values = new Array();
	  	var green_values = new Array();
	  	var blue_values = new Array();
	  	var i = 0;
	  	for(; i < blocks.length/3; ++i)
	  	{
	  		red_values.push(blocks[i]);
	  	}
	  	for(; i < blocks.length/3*2; ++i)
	  	{
	  		green_values.push(blocks[i]);
	  	}
	  	for(; i < blocks.length; ++i)
	  	{
	  		blue_values.push(blocks[i]);
	  	}

	  	//Unwrap blocks onto channels
	  	var red_channel = unwrapBlocks(red_values, image_width, image_height);
	  	var green_channel = unwrapBlocks(green_values, image_width, image_height);
	  	var blue_channel = unwrapBlocks(blue_values, image_width, image_height);

	  	//Create one array of data
	  	var c_pos = 0;
	  	var texture_data = new Uint8Array(image_width * image_height * 3);
	  	for (var i = 0; i < image_width * image_height * 3; i += 3)
	  	{
	  		texture_data[i] = blue_channel[c_pos] + 128;
	  		texture_data[i+1] = green_channel[c_pos] + 128;
	  		texture_data[i+2] = red_channel[c_pos] + 128;
	  		c_pos++;
	  	}

	  	texture = new THREE.DataTexture(texture_data, image_width, image_height, THREE.RGBFormat, THREE.UnsignedByteType);
	  	texture.needsUpdate = true;

	  	//Create balcon floor
		var floor_geometry = new THREE.BoxGeometry( 5, 0.2, 2.5);
		//var floor_texture = THREE.ImageUtils.loadTexture("images/textures/floor_texture.jpg");
		//floor_texture.wrapS = floor_texture.wrapT = THREE.RepeatWrapping;
		//floor_texture.repeat.set(10, 5);

		texture.wrapS = texture.wrapT = THREE.RepeatWrapping;
		texture.repeat.set(10, 5);
		var floor_material = new THREE.MeshLambertMaterial({map: texture, side: THREE.DoubleSide});
		var floor_mesh = new THREE.Mesh( floor_geometry, floor_material );
		floor_mesh.position.y = 0.1;
		floor_mesh.receiveShadow = true;

		scene.add(floor_mesh);
	};

	oReq.send(null);
}

function getImageData(image)
{
    var canvas = document.createElement( 'canvas' );
    canvas.width = image.width;
    canvas.height = image.height;

    var context = canvas.getContext( '2d' );
    context.drawImage( image, 0, 0 );

    return context.getImageData( 0, 0, image.width, image.height );
}


var text_elements = new Array();
var audioClearSky;
var temperature_text;

function luka_init()
{
	//Kreairamo balkon z DCT sliko, balkon se kar naredi v funkciji, hax for fax
	load_dct("images/textures/test.dct");

	//Load height map texture
	var height_map = THREE.ImageUtils.loadTexture("images/textures/height.png", {}, function(){
		var height_data = getImageData(height_map.image);
		var grass_geometry = new THREE.PlaneGeometry(60, 60, 99, 49);

		for (var i = 0; i < grass_geometry.vertices.length; ++i)
		{
			var h = height_data.data[(i*4)+2];
			//console.log(grass_geometry.vertices[i]);
			grass_geometry.vertices[i].z = 0 - h/50;
		}

		var grass_texture = THREE.ImageUtils.loadTexture("images/textures/grass_texture.jpg");
		grass_texture.wrapS = grass_texture.wrapT = THREE.RepeatWrapping;
		grass_texture.repeat.set(150, 50);
		var grass_material = new THREE.MeshBasicMaterial({map: grass_texture, side: THREE.DoubleSide});
		grass_mesh = new THREE.Mesh( grass_geometry, grass_material );
		grass_mesh.rotation.x = Math.PI/2;
		grass_mesh.rotation.z = Math.PI;
		grass_mesh.position.z = -2;
		grass_mesh.receiveShadow = true;

		if (data_blob.condition_code != "snow")
		{
			scene.add(grass_mesh);
		}
	});

	//Create text with data
	//Main data
	console.log(data_blob);
	text_elements.push(new TextElement(data_blob.city_name + ', ' + data_blob.country, -4, 1.5, -1));
	text_elements.push(new TextElement(data_blob.condition, -4, 1.3, -1));
	temperature_text = new TextElement(parseFloat(data_blob.temperature).toFixed(0).toString() + '°C', -4, 1.1, -1);

	//Activity data
	text_elements.push(new TextElement(data_blob.task_title, 3.3, 1.5, -0.3));
	text_elements.push(new TextElement(data_blob.task1, 3.3, 1.3, -0.3));
	text_elements.push(new TextElement(data_blob.task2, 3.3, 1.1, -0.3));
	text_elements.push(new TextElement(data_blob.task3, 3.3, 0.9, -0.3));

	//Load clothes
	var plane = new THREE.PlaneGeometry( 0.5, 1, 1, 1);

	//Textures
	var pants_texture = THREE.ImageUtils.loadTexture("images/" + data_blob.pants + "_legs.png");
	var body_texture = THREE.ImageUtils.loadTexture("images/" + data_blob.body + "_torso.png");
	var head_texture = THREE.ImageUtils.loadTexture("images/" + data_blob.head + "_head.png");
	var boots_texture = THREE.ImageUtils.loadTexture("images/" + data_blob.boots + "_boots.png");
	var guy_texture = new THREE.ImageUtils.loadTexture("images/WeatherGuy.png");

	//Materials
	var pants_material = new THREE.MeshBasicMaterial( {map: pants_texture, transparent:true} );
	var body_material = new THREE.MeshBasicMaterial( {map: body_texture, transparent:true} );
	var head_material = new THREE.MeshBasicMaterial( {map: head_texture, transparent:true} );
	var boots_material = new THREE.MeshBasicMaterial( {map: boots_texture, transparent:true} );
	var guy_material = new THREE.MeshBasicMaterial( {map: guy_texture, transparent:true} );

	//Position them and add to scene
	var guy_position = new THREE.Vector3(-4, 1.3, 0.2);

	var pants_mesh = new THREE.Mesh(plane, pants_material);
	pants_mesh.rotation.y = Math.PI/2;
	pants_mesh.position.set(guy_position.x+0.0001, guy_position.y, guy_position.z);

	var body_mesh = new THREE.Mesh(plane, body_material);
	body_mesh.rotation.y = Math.PI/2;
	body_mesh.position.set(guy_position.x+0.0002, guy_position.y, guy_position.z);

	var head_mesh = new THREE.Mesh(plane, head_material);
	head_mesh.rotation.y = Math.PI/2;
	head_mesh.position.set(guy_position.x+0.0003, guy_position.y, guy_position.z);

	var boots_mesh = new THREE.Mesh(plane, boots_material);
	boots_mesh.rotation.y = Math.PI/2;
	boots_mesh.position.set(guy_position.x+0.0002, guy_position.y, guy_position.z);

	var guy_mesh = new THREE.Mesh(plane, guy_material);
	guy_mesh.rotation.y = Math.PI/2;
	guy_mesh.position.set(guy_position.x, guy_position.y, guy_position.z);

	scene.add(guy_mesh);
	scene.add(pants_mesh);
	scene.add(body_mesh);
	scene.add(head_mesh);
	scene.add(boots_mesh);	

	//Sound effect for clear sky
	audioClearSky = new Audio("sounds/clearSky.mp3");
	audioClearSky.loop = true;
	audioClearSky.play();
}

function luka_update()
{
	//Zoki temp
	if (temperatureChanged == true)
	{
		temperatureChanged = false;
		//Remove old text
		scene.remove(temperature_text.mesh);
		scene.remove(temperature_text.plate);
		temperature_text = new TextElement(parseFloat(temperatureRead).toFixed(0).toString() + '°C', -4, 1.1, -1);
	}

	temperature_text.update();
	for (i = 0; i < text_elements.length; ++i)
	{
		text_elements[i].update();
	}
}

//TODO PROJEKT RG
//Add texture loading (easy, three.js has)
//Add .obj loading (For objects, duhhh, buildin)
//Add HUD, to show weather data
//Construct balkon with forest or w/e
//Basic moving around
//Add some fancy effects