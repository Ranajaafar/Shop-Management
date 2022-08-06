use shop
go

CREATE VIEW out_of_stock
AS select * from Products WHERE quantity=0  
go
-------------------------------------------------

CREATE VIEW on_stock
AS select * from Products WHERE quantity>0  
go
-------------------------------------------------

CREATE VIEW DIS
as  select * 
	from discount 
	where (cast((select YEAR(GETDATE())) as varchar(50))+'-'+cast(( select MONTH(GETDATE())) as varchar(50))+'-'+cast((select DAY(GETDATE())) as varchar(50)) between start_date and end_date) 
				or
		  (END_DATE  IS NULL and START_DATE is NULL)
go
----------------------------------------------------

CREATE VIEW ORDERTODAY
as select oid,total_amount
   from order_info     
   where cast((select YEAR(GETDATE())) as varchar(50))+'-'+cast(( select MONTH(GETDATE())) as varchar(50))+'-'+cast((select DAY(GETDATE())) as varchar(50))=odate
 go
 --------------------------------------------------
