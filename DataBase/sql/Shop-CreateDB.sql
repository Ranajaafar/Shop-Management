use master
go

CREATE DATABASE shop
on
(   NAME = 'shop_dat',
	FILENAME = 'D:\DB\shop.mdf')
LOG on
(   NAME = 'shop_log',
	FILENAME = 'D:\DB\shop.ldf')