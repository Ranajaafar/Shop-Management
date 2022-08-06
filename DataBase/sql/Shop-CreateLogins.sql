USE [master]
GO
CREATE LOGIN [ADMIN] WITH PASSWORD=N'admin123', DEFAULT_DATABASE=[Shop]
GO
use Shop
GO
CREATE user [admin]  for Login [ADMIN]

grant select on out_of_stock to admin
grant select,update,delete,insert on products to admin
grant select,update,delete,insert on depot to admin
grant select,update,delete,insert on category to admin
grant select,update,delete,insert on discount to admin
grant select,update,delete,insert on supplier to admin
grant select,update,delete,insert on supply to admin
grant select on order_info to admin
grant select on customer to admin
grant select on contain to admin
grant select on administrator to admin
grant  exec on DELETE_DIS to  admin
grant  exec on TRANSFORME to  admin

grant  exec on country_pourcentage to  admin
grant  exec on NB_OFSUPPLY to  admin
grant  exec on NB_OFPRODUCT to  admin
grant  exec on NB_OFORDER to  admin
grant  exec on TODAY_ORDERS to  admin
grant  exec on NB_OFORDER2 to  admin
grant  exec on total_amount to  admin


USE [master]
GO
CREATE LOGIN [USER] WITH PASSWORD=N'SHOP', DEFAULT_DATABASE=[Shop]
GO
use Shop
GO
create user [shop]  for Login [USER]


grant SELECT ON on_stock TO shop
grant SELECT,UPDATE on order_info to shop
grant SELECT,UPDATE on products to shop
grant SELECT,UPDATE,INSERT on Contain to shop
grant exec on ADD_ORDER to  shop
grant exec on ADD_CUSTOMER to  shop
grant exec on PLACE_ORDER to  shop
grant exec on FETCH_DIS to shop
grant exec on GET_QT  to shop

