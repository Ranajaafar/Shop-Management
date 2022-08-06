USE shop
GO

--check if there is a discount on the order

create procedure FETCH_DIS
  @price int,
  @price_final int out,
  @pourcentage decimal(3,0) OUT,
  @ID int OUT
AS
BEGIN
  declare crs_1 cursor for select dis_id,pourcentage,dis_price from dbo.DIS

  declare @dis_id int, @pr decimal(3,0) ,@dis_price int, @dis_id1 int, @pr1 int, @delivery int
  set @delivery = 5

  open crs_1
  fetch next from crs_1 into @dis_id, @pr , @dis_price

  while @@fetch_status=0
  BEGIN  
    if(@dis_id1>=0)
		BEGIN
			  set @pr1=(select dis_price from Discount  where dis_id=@dis_id1)  -- dis_price for the discount before!
			  
			  if(@price >= @dis_price)
			  BEGIN
				  if(@pr1<@dis_price)
					set @dis_id1=@dis_id
			  end	
		end
    else
		BEGIN
		   if(@price >= @dis_price)
				set @dis_id1 = @dis_id
		end
  
  fetch next from crs_1 into @dis_id,@pr,@dis_price
  end

  if(@dis_id1>=0)
	  BEGIN
		set @pr= (select pourcentage from discount where dis_id=@dis_id1)
		set @price_final= (@price-(@pr/100)*@price)+@delivery
		set @ID=@DIS_ID1
		set @pourcentage = @pr
	  end

  CLOSE crs_1
  deallocate crs_1
end  
go
---------------------------------------------------------------------------------------------------

-- delete all out dated discounts 

create procedure DELETE_DIS
AS
begin
  declare @YY VARCHAR(5),@MM VARCHAR(5),@DD VARCHAR(5), @date DATE, @DIS_ID INT
  
  SET @YY=(select YEAR(GETDATE()))
  SET @MM=( select MONTH(GETDATE()))
  SET @DD=(select DAY(GETDATE()))
  set @date= @YY+'-'+@MM+'-'+@DD
  
  declare crs CURSOR FOR select DIS_ID
						 FROM DISCOUNT
						 WHERE END_DATE < @date
  
  open crs
  fetch next from crs into @DIS_ID
  while @@fetch_status=0
  BEGIN
	 UPDATE ORDER_INFO SET DIS_ID=NULL WHERE DIS_ID=@DIS_ID
	 delete from DISCOUNT where DIS_ID=@DIS_ID
	 fetch next from crs into @DIS_ID
  END	 
  CLOSE crs
  deallocate crs
end
go

----------------------------------------------------------------------------------------------

create procedure ADD_CUSTOMER
   @CNAME    varchar(50),
   @PHONE    varchar(24),
   @CEMAIL   varchar(1024),
   @COUNTRY  varchar(50),
   @CID		 int   out
 as BEGIN

	 if exists(select * from Customer where cname=@cname and PHONE=@PHONE and cemail=@cemail and country=@country)
		set @CID=(select cid from Customer where cname=@cname and PHONE=@PHONE and cemail=@cemail and country=@country)
	 else 
	 BEGIN 
		    Insert into Customer(CNAME,PHONE,CEMAIL,COUNTRY)
								values(@CNAME,@PHONE,@CEMAIL,@COUNTRY);
								
			set @CID=(select max(CID) from Customer); 					
	  end
end
go


---------------------------------------------------------------------------------------------------------------------

create procedure ADD_ORDER
   @CID			int  ,  
   @DIS_ID		int,   
   @OADDRESS	varchar(1024)

as BEGIN
    declare @YY VARCHAR(5),@MM VARCHAR(5),@DD VARCHAR(5)
    declare @date_0 varchar(30), @OID int

    SET @YY=(select YEAR(GETDATE()))
    SET @MM=(select MONTH(GETDATE()))
    SET @DD=(select DAY(GETDATE()))
    set @date_0= @YY+'-'+@MM+'-'+@DD

    insert into Order_Info(CID,OADDRESS,DIS_ID,ODATE,TOTAL_AMOUNT)
						 values(@CID,@OADDRESS,@DIS_ID,@DATE_0,0);
END
go

-------------------------------------------------------------------------------------------------------------

-- when we call place order procedure -> we call 2 others procedures: add_customer and add_order

CREATE PROCEDURE PLACE_ORDER
     @CNAME   varchar(50),
     @PHONE     varchar(24),
     @CEMAIL   VARCHAR(1024),
     @COUNTRY    varchar(50),
	 @DIS_ID     INT,
	 @OADDRESS   varchar(1024)    
AS BEGIN	
   declare @cid int 
   begin transaction
   exec dbo.ADD_CUSTOMER @CNAME,@PHONE,@CEMAIL,@COUNTRY,@cid out
   exec dbo.ADD_ORDER @CID,@DIS_ID, @OADDRESS
   commit   
END
go

------------------------------------------------------------------------------------

-- transform all supplies from supplier1 to supplier2

create procedure TRANSFORME
        @sid int,
		@sid1 int
as
BEGIN
  if(@sid!=@sid1)
  begin
      if ((EXISTS(select * from supplier where sid=@sid1)) and (exists(select * from supplier where sid=@sid)))
	  begin
        begin transaction
		  declare cursortr CURSOR
		   for     select * from supply where sid=@sid
		   declare @pid int,@date_s date,@qt decimal(8,0)
		   open cursortr
		   fetch next from cursortr into @sid,@pid,@date_s,@qt
		   while @@fetch_status=0
		   BEGIN
		    if exists(select * from supply where pid=@pid and sid=@sid1 and sdate=@date_s)
			begin
                  update supply set QUANTITY=QUANTITY+@QT	where pid=@pid and sid=@sid1 and sdate=@date_s
			      delete supply where pid=@pid and sid=@sid and sdate=@date_s and QUANTITY=@QT
			end		
            else
            BEGIN
               insert into supply VALUES(@sid1,@pid,@date_s,@qt)
               delete supply where pid=@pid and sid=@sid and sdate=@date_s AND QUANTITY=@QT
            end	
            fetch next from cursortr into @sid,@pid,@date_s,@qt			
		   end
		   CLOSE cursortr
           deallocate cursortr
		commit
      end

  end
end		 
go
-----------------------------------------------------------------------------------



