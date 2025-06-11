
CREATE DATABASE IF NOT EXISTS db_akun;
USE db_akun;


CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'user',
  PRIMARY KEY (id)
);


INSERT INTO users (username, password, role)
VALUES 
('admin', '$2y$10$cxZy7IvwWRP1eytvgkkUUelj2S3C09cjYom9lLV19b0RmWcGow9E.', 'admin'); "123"


CREATE TABLE IF NOT EXISTS barang (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama VARCHAR(50) NOT NULL,
  harga DECIMAL(10,2) NOT NULL,
  stok INT(11) NOT NULL,
  foto VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS banner (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255) NOT NULL,
  gambar VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL
);

CREATE TABLE manual_book (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    file_manual VARCHAR(255), -- nama file PDF/image manual
    tanggal_upload DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE artikel (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255),
  tanggal DATE,
  isi TEXT,
  gambar VARCHAR(255)
);

CREATE TABLE discord_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255),
    deskripsi TEXT,
    link_discord VARCHAR(255),
    tanggal_upload DATETIME
);

CREATE TABLE tentang_kami (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255),
    logo VARCHAR(255),
    paragraf1 TEXT,
    paragraf2 TEXT,
    paragraf3 TEXT
);

CREATE TABLE instagram_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    link_instagram VARCHAR(255) NOT NULL,
    tanggal_upload DATETIME NOT NULL
);
