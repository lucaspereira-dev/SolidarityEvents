DROP DATABASE IF EXISTS solidarity_events_db;
CREATE DATABASE solidarity_events_db;

USE solidarity_events_db;

CREATE TABLE IF NOT EXISTS users_tbl(
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    fist_name VARCHAR(100),
    last_name VARCHAR(100),
    phone VARCHAR(100),
    email VARCHAR(100),
    data_update DATETIME,
    data_creation DATETIME
);

CREATE TABLE IF NOT EXISTS adresses_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    street VARCHAR(100) NOT NULL,
    number INT NOT NULL,
    avenue VARCHAR(200) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    zip_code VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL,
    latitude DOUBLE NOT NULL,
    longitude DOUBLE NOT NULL,
    data_update DATETIME,
    data_creation DATETIME
);

CREATE TABLE IF NOT EXISTS adresses_users_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    users_id INT NOT NULL,
    FOREIGN KEY (users_id)
        REFERENCES users_tbl (id),
    adresses_id INT NOT NULL,
    FOREIGN KEY (adresses_id)
        REFERENCES adresses_tbl (id),
    data_creation DATETIME
);

CREATE TABLE IF NOT EXISTS events_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    group_name VARCHAR(200),
    event_name VARCHAR(300),
    drescription TEXT,
    description_donations TEXT,
    data_update DATETIME,
    data_creation DATETIME
);

CREATE TABLE IF NOT EXISTS pictures_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    hash TEXT,
    mimo VARCHAR(50),
    dir TEXT,
    title VARCHAR(100),
    description TEXT,
    data_creation DATETIME
);

CREATE TABLE IF NOT EXISTS events_pictures_tbl (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    events_id INT NOT NULL,
    FOREIGN KEY (events_id)
        REFERENCES events_tbl (id),
    pictures_id INT NOT NULL,
    FOREIGN KEY (pictures_id)
        REFERENCES pictures_tbl (id),
    data_creation DATETIME
);

CREATE TABLE IF NOT EXISTS events_organizer (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    adresses_id INT NOT NULL,
    FOREIGN KEY (adresses_id)
        REFERENCES adresses_tbl (id),
    users_id INT NOT NULL,
    FOREIGN KEY (users_id)
        REFERENCES users_tbl (id),
    events_id INT NOT NULL,
    FOREIGN KEY (events_id)
        REFERENCES events_tbl (id),
    date_init_event DATETIME,
    date_end_event DATETIME,
    data_update DATETIME,
    data_creation DATETIME
);

