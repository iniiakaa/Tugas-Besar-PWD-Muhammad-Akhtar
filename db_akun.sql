create database IF NOT EXISTS `db_akun`;
use `db_akun`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) 

CREATE TABLE IF NOT EXISTS barang (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  'foto' varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);