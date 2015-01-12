function TextElement(text, pos_x, pos_y, pos_z)
{
	//Create text
	var text_geo = new THREE.TextGeometry(String(text), {size: 0.1, height: 0.01} );	
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

function strToInt(str, size)
{
	var a = "";
	for (var i = 0; i < size; ++i)
	{
		if (str[i] == '1') a += "0";
		else a += "1";
	}
	return -(parseInt(a.substring(1, size), 2) + 1);
}

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

	  	for (var i = 0; i < num_blocks; ++i)
	  	{
	  		var data = new Array();
	  		var data_index = 1;
	  		var num_values = 1;

	  		//Read DC
            var dc = strToInt(in_stream.substring(pos, pos+11), 11);
            pos += 11;
            data[0] = dc;

           	console.log(in_stream.substring(pos));

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
                    console.log(in_stream.substring(pos, pos+6));
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

                    //preberi ac
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

            console.log(data);
            break;
	  	}
	};

	oReq.send(null);
}

var text_elements = new Array();

function luka_init()
{
	var name_hud = document.getElementById("hud_location");
	name_hud.style.left = "20px";
	name_hud.style.top = "50px";

	//Create single color skybox
	var skybox_geometry = new THREE.BoxGeometry(50, 50, 50);
	var skybox_material = new THREE.MeshBasicMaterial( {color: 0x5C97BF, side:THREE.BackSide} );
	var skybox_mesh = new THREE.Mesh(skybox_geometry, skybox_material);
	scene.add(skybox_mesh);

	//Create balcon floor
	var floor_geometry = new THREE.BoxGeometry( 5, 0.2, 2.5);
	var floor_texture = THREE.ImageUtils.loadTexture("images/textures/floor_texture.jpg");
	floor_texture.wrapS = floor_texture.wrapT = THREE.RepeatWrapping;
	floor_texture.repeat.set(10, 5);
	var floor_material = new THREE.MeshLambertMaterial({map: floor_texture, side: THREE.DoubleSide});
	var floor_mesh = new THREE.Mesh( floor_geometry, floor_material );
	floor_mesh.position.y = 0.1;

	//Create outside grass
	var grass_geometry = new THREE.PlaneGeometry(100, 50, 20, 20);
	var grass_texture = THREE.ImageUtils.loadTexture("images/textures/grass_texture.jpg");
	grass_texture.wrapS = grass_texture.wrapT = THREE.RepeatWrapping;
	grass_texture.repeat.set(150, 50);
	var grass_material = new THREE.MeshLambertMaterial({map: grass_texture, side: THREE.DoubleSide});
	var grass_mesh = new THREE.Mesh( grass_geometry, grass_material );
	grass_mesh.rotation.x = Math.PI/2;
	grass_mesh.position.z = -8;

	scene.add(floor_mesh);
	scene.add(grass_mesh);

	//Add some elements
	text_elements.push(new TextElement(data_blob.city_name + ', ' + data_blob.country, 1, 1.2, -1));
	text_elements.push(new TextElement(data_blob.condition, 1, 1, -1));
	text_elements.push(new TextElement(data_blob.temperature.toFixed(0) + '°C', 1, 0.8, -1));
	text_elements.push(new TextElement("Much text, so fancy", -1.5, 1, -1));
	text_elements.push(new TextElement("FERIFax™", -1.5, 1.3, -1));

	//Set proper camera position TEMP
	//camera.rotation.x = 0.1;
	load_dct("images/textures/test.dct");
}

function luka_update()
{
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