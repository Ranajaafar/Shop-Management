use shop
go

-- get customers country percentage
create function country_pourcentage(@coutry varchar(50))
returns INT
BEGIN
 declare @count integer,@pr integer,@RES decimal(5,2)
 set @count=(select count(*)
             from CUSTOMER)
 set @pr=(select count(*)
          from CUSTOMER
          where COUNTRY=@coutry
		  )	
 set @RES=(@pr*100)/(@count*1.0)
 return @RES
end
go

-----------------------------------------------------------------------------------

-- get quantity in stock of a specific product
create function GET_QT(@PID int)
returns  int
BEGIN
  declare @Q int
  if((select count(*) from products where pid=@pid)=1)
  BEGIN
	set @Q=(select quantity FROM products WHERE pid=@PID)
  END

 return @Q
end
go


-----------------------------------------------------------------------------------

-- get number of supplies of a specific supplier
create function NB_OFSUPPLY(@sid int)
returns  int
BEGIN
 declare @nb int
 set @nb=(select count(*) from supply where sid=@sid AND sdate=(cast((select YEAR(GETDATE())) as varchar(50))+'-'+cast(( select MONTH(GETDATE())) as varchar(50))+'-'+cast((select DAY(GETDATE())) as varchar(50)))
 )
 return @nb
end
go

-----------------------------------------------------------------------------------

-- get number of products in a specific depot
create function NB_OFPRODUCT(@did int)
returns  int
BEGIN
 declare @nb int
 set @nb=(select count(*) from products where did=@did AND QUANTITY!=0)
 return @nb
end
go


-----------------------------------------------------------------------------------

-- get number of orders in a specific customer
create function NB_OFORDER(@cid int)
returns int
BEGIN
 declare @nb int
 set @nb=(select count(*) from order_INFO where cid=@cid)
 return @nb
end
go

-----------------------------------------------------------------------------------

-- get number of today's orders
create function TODAY_ORDERS()
returns  int
BEGIN
 declare @nb int
 set @nb=(select count(*) from ORDER_INFO 
		  where odate=(cast((select YEAR(GETDATE())) as varchar(50))+'-'+cast(( select MONTH(GETDATE())) as varchar(50))
		  +'-'+cast((select DAY(GETDATE())) as varchar(50))))
 return @nb
end
go

-----------------------------------------------------------------------------------

-- get number of orders in a specific date
create function NB_OFORDER2(@date_0 date)
returns integer
BEGIN
  DECLARE @nb integer
  SET @NB=(select count(*) from ORDER_INFO where Odate=@date_0) 
  RETURN @NB
end
go


-----------------------------------------------------------------------------------

-- get total amount of all orders
create function total_amount()
returns  int
BEGIN
 declare @a int
 set @a=(select sum(total_amount) from order_info)
 return @a
end
go

-----------------------------------------------------------------------------------

