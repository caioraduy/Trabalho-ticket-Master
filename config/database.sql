CREATE DATABASE IF NOT EXISTS ticketmaster
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE ticketmaster;

CREATE TABLE users (
    id                     INT AUTO_INCREMENT PRIMARY KEY,
    name                   VARCHAR(100)  NOT NULL,
    email                  VARCHAR(150)  NOT NULL UNIQUE,
    password_hash          VARCHAR(255)  NOT NULL,
    reset_token            VARCHAR(64)   DEFAULT NULL,
    reset_token_expires_at DATETIME      DEFAULT NULL,
    created_at             DATETIME      DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE movies (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(150) NOT NULL,
    description  TEXT,
    genre        VARCHAR(50),
    duration_min INT,
    poster_url   VARCHAR(255),
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cinema_sessions (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    movie_id        INT           NOT NULL,
    room            VARCHAR(50),
    datetime        DATETIME,
    total_seats     INT           NOT NULL,
    available_seats INT           NOT NULL,
    price           DECIMAL(8,2)  NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

CREATE TABLE tickets (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    user_id           INT  NOT NULL,
    cinema_session_id INT  NOT NULL,
    seat_number       VARCHAR(10),
    purchased_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)           REFERENCES users(id)           ON DELETE CASCADE,
    FOREIGN KEY (cinema_session_id) REFERENCES cinema_sessions(id) ON DELETE CASCADE
);

CREATE TABLE reviews (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT     NOT NULL,
    movie_id   INT     NOT NULL,
    rating     TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment    TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);