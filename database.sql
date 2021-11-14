DROP DATABASE IF EXISTS solidarity_events_db;
CREATE DATABASE solidarity_events_db;

USE solidarity_events_db;

CREATE TABLE IF NOT EXISTS users_tbl(
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100),
    date_update TIMESTAMP,
    date_creation TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    event_name VARCHAR(300) NOT NULL,
    drescription TEXT,
    description_donations TEXT,
    latitude DOUBLE NOT NULL,
    longitude DOUBLE NOT NULL,
    date_update TIMESTAMP,
    date_creation TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pictures_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    mimo VARCHAR(50),
    base64 TEXT,
    title VARCHAR(100),
    description TEXT,
    date_creation TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events_pictures_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    events_id INT NOT NULL,
    FOREIGN KEY (events_id)
        REFERENCES events_tbl (id),
    users_id INT NOT NULL,
    FOREIGN KEY (users_id)
        REFERENCES users_tbl (id),
    pictures_id INT NOT NULL,
    FOREIGN KEY (pictures_id)
        REFERENCES pictures_tbl (id),
    date_creation TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events_organizer_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    status TINYINT(1) DEFAULT 1,
    users_id INT NOT NULL,
    FOREIGN KEY (users_id)
        REFERENCES users_tbl (id),
    events_id INT NOT NULL,
    FOREIGN KEY (events_id)
        REFERENCES events_tbl (id),
    phone VARCHAR(100),
    date_init_event DATETIME,
    date_end_event DATETIME,
    date_update TIMESTAMP,
    date_creation TIMESTAMP
);

