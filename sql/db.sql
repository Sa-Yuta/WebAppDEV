CREATE DATABASE whisper_db;

USE whisper_db;

CREATE TABLE User (
    user_id     VARCHAR(20)     PRIMARY KEY,
    user_name   VARCHAR(50)     NOT NULL,
    email       VARCHAR(255)    NOT NULL,
    pass        CHAR(60)     NOT NULL,
    birthday    DATE            NOT NULL,
    registday   DATE            NOT NULL
);

CREATE TABLE User_info (
    user_id     VARCHAR(20)     PRIMARY KEY,
    self_intro  VARCHAR(140)    DEFAULT NULL,
    header_pic  VARCHAR(255)    DEFAULT 'default_header.jpg',
    icon_pic    VARCHAR(255)    DEFAULT 'default_icon.jpg',

    FOREIGN KEY (user_id) REFERENCES User(user_id)
);


CREATE TABLE Follow (
    id              INTEGER     AUTO_INCREMENT PRIMARY KEY,
    user_id         VARCHAR(20) NOT NULL,
    follow_user_id  VARCHAR(20) NOT NULL,

    FOREIGN KEY (follow_user_id) REFERENCES User(user_id)
);

CREATE TABLE Whispers (
    id      INTEGER      AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(20)  NOT NULL,
    content VARCHAR(140) NOT NULL,
    picture VARCHAR(255) DEFAULT NULL,
    flag    TINYINT(1)   DEFAULT 0,

    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

CREATE TABLE Likes (
    id      INTEGER     AUTO_INCREMENT PRIMARY KEY,
    post_id INTEGER     NOT NULL,
    user_id VARCHAR(20) NOT NULL,
    
    FOREIGN KEY (post_id) REFERENCES Whispers(id),
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);
