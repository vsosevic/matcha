<?php
include('database.php');

try {
	$db = new PDO($DB_DSN_G, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//DB creation
	$sql = "DROP DATABASE IF EXISTS matcha";
	$db->exec($sql);
	$sql = "CREATE DATABASE IF NOT EXISTS matcha";
	$db->exec($sql);

	//Table users
	$sql = "USE matcha;
		CREATE TABLE `Cities`
			(Id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			city VARCHAR(50) NOT NULL
			) ENGINE=InnoDB;
		CREATE TABLE `Users`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			user_name VARCHAR(50) NOT NULL,
			first_name VARCHAR(50) NOT NULL,
			last_name VARCHAR(50) NOT NULL,
			email VARCHAR(50),
			password varchar (255) NOT NULL,
			gender TINYINT DEFAULT 0,
			orientation TINYINT DEFAULT 0,
			about LONGTEXT NULL,
			registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			city_id INT(4) UNSIGNED,
			fame_rating INT(2) DEFAULT 1,
			age TINYINT UNSIGNED,
			last_connection TIMESTAMP,
			fake_reported TINYINT(1),
			auth_key CHAR(50),
			FOREIGN KEY (city_id) REFERENCES Cities (Id)
			) ENGINE=InnoDB;
		CREATE TABLE `Interests`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			interest VARCHAR(50) NOT NULL
			) ENGINE=InnoDB;
		CREATE TABLE `UsersToInterests`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			users_id INT(6) UNSIGNED NOT NULL,
			interests_id INT(6) UNSIGNED NOT NULL,
			FOREIGN KEY (users_id) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE,
       		FOREIGN KEY (interests_id) REFERENCES Interests (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE
			) ENGINE=InnoDB;
		CREATE TABLE `Likes`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			like_from INT(6) UNSIGNED NOT NULL,
			like_to INT(6) UNSIGNED NOT NULL,
			date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			FOREIGN KEY (like_from) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE,
       		FOREIGN KEY (like_to) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE
			) ENGINE=InnoDB;
		CREATE TABLE `Visites`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			visit_from INT(6) UNSIGNED NOT NULL,
			visit_to INT(6) UNSIGNED NOT NULL,
			date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			FOREIGN KEY (visit_from) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE,
       		FOREIGN KEY (visit_to) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE
			) ENGINE=InnoDB;
		CREATE TABLE `Blocks`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			block_from INT(6) UNSIGNED NOT NULL,
			block_to INT(6) UNSIGNED NOT NULL,
			FOREIGN KEY (block_from) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE,
       		FOREIGN KEY (block_to) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE
			) ENGINE=InnoDB;
		CREATE TABLE `Chat`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			message_from INT(6) UNSIGNED NOT NULL,
			message_to INT(6) UNSIGNED NOT NULL,
            seen TINYINT DEFAULT 0,
			date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			message LONGTEXT NOT NULL,
			FOREIGN KEY (message_from) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE,
       		FOREIGN KEY (message_to) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE
			) ENGINE=InnoDB;
		CREATE TABLE `Notifications`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			users_id INT(6) UNSIGNED NOT NULL,
			notification_type TINYINT NOT NULL,
			seen TINYINT DEFAULT 0,
			FOREIGN KEY (users_id) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE
			) ENGINE=InnoDB;
		CREATE TABLE `Avatars`
			(Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			users_id INT(6) UNSIGNED NOT NULL,
			avatar1 VARCHAR(200) DEFAULT 'sources/no_image.png',
			avatar2 VARCHAR(200) DEFAULT 'sources/no_image.png',
			avatar3 VARCHAR(200) DEFAULT 'sources/no_image.png',
			avatar4 VARCHAR(200) DEFAULT 'sources/no_image.png',
			avatar5 VARCHAR(200) DEFAULT 'sources/no_image.png',
			FOREIGN KEY (users_id) REFERENCES Users (Id)
				ON DELETE CASCADE
       			ON UPDATE CASCADE
			) ENGINE=InnoDB;
			";
	$db->exec($sql);
	} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
	}
$db = null;
?>