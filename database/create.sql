CREATE TABLE cities
(
	id BIGINT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(45) NOT NULL,
	country VARCHAR(45) NOT NULL,
	continent VARCHAR(45) NOT NULL,
	longitude FLOAT NOT NULL,
	latitude FLOAT NOT NULL
);

CREATE TABLE weather_conditions
(
	id INT PRIMARY KEY,
	condition_name VARCHAR(45) NOT NULL
);

CREATE TABLE current_weather
(
	id BIGINT PRIMARY KEY AUTO_INCREMENT,
	city_id BIGINT NOT NULL REFERENCES cities(id),
	reading_time DATETIME NOT NULL,
	condition_id INT NOT NULL REFERENCES weather_conditions(id),
	tempC FLOAT NOT NULL,
	tempF FLOAT NOT NULL,
	pressure FLOAT NOT NULL,
	humidity INT NOT NULL,
	wind_direction INT NOT NULL,
	wind_speed_kph FLOAT NOT NULL,
	wind_speed_mph FLOAT NOT NULL
);

CREATE TABLE weather_history
(
	id BIGINT PRIMARY KEY AUTO_INCREMENT,
	city_id BIGINT NOT NULL REFERENCES cities(id),
	reading_time DATETIME NOT NULL,
	condition_id INT NOT NULL REFERENCES weather_conditions(id),
	tempC FLOAT NOT NULL,
	tempF FLOAT NOT NULL,
	pressure FLOAT NOT NULL,
	humidity INT NOT NULL,
	wind_direction INT NOT NULL,
	wind_speed_kph FLOAT NOT NULL,
	wind_speed_mph FLOAT NOT NULL
);
