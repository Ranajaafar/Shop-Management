
USE shop
GO

/*==============================================================*/
/* Table : CATEGORY                                             */
/*==============================================================*/

-- we can't insert 2 categories having the same name

		---  insert ---

create trigger CATEGORY_I on Category for insert
as
begin
  declare @c int
  set @c=(select count(*) from category)

  if ((select count(*) from category t1,category t2 where t1.cat_name = t2.cat_name)!=@c)
  begin
      rollback
  end

end
go
          ---  update ---

create trigger CATEGORY_U on category for update
as
begin
  declare @c int
  set @c=(select count(*) from category)
  if ((select count(*) from category t1,category t2 where t1.cat_name = t2.cat_name)!=@c)
      rollback
   
end
go

/*==============================================================*/
/* Table : SUPPLY                                               */
/*==============================================================*/

-- when we insert into supply table the number of products increase 
-- when we delete from supply table the number of products decrease 

		 ---  insert ---
   
create trigger SUPPLY_I on Supply for insert
as
begin
 declare crs_SUPPLY_I cursor FOR select * from inserted
 declare @pid int, @sid int, @DATE_S date, @qt decimal(8,0) 

 open crs_SUPPLY_I
 fetch next from crs_SUPPLY_I into @SID,@PID,@DATE_S,@qt
 while @@fetch_status=0
 BEGIN
    update Products set quantity = quantity + @qt WHERE pid = @PID

   fetch next from crs_SUPPLY_I into @SID,@PID,@DATE_S,@qt
 end
 CLOSE crs_SUPPLY_I
 deallocate crs_SUPPLY_I
end 
go
         --- delete --- 

create trigger SUPPLY_D on Supply for delete
as
begin
   declare crs_SUPPLY_D cursor FOR select * from deleted

 declare @PID int, @SID int, @DATE_S date, @qt decimal(8,0)
 open crs_SUPPLY_D
 fetch next from crs_SUPPLY_D into @SID,@PID,@DATE_S,@qt
 while @@fetch_status=0
 BEGIN
   update Products set quantity = quantity - @qt WHERE pid = @PID
   fetch next from crs_SUPPLY_D into @SID,@PID,@DATE_S,@qt
 end
 CLOSE crs_SUPPLY_D
 deallocate crs_SUPPLY_D
end
go
		 ---  update ---

create trigger SUPPLY_U on SUPPLY for update
as
begin
  declare crs_SUPPLY_U1 cursor FOR select * from deleted
  declare crs_SUPPLY_U cursor FOR select * from inserted

  declare @pid int, @sid int, @DATE_S date, @qt decimal(8,0)
  declare @pid1 int, @sid1 int, @DATE_S1 date , @qt1 decimal(8,0)

   open crs_SUPPLY_U
   fetch next from crs_SUPPLY_U into @SID,@PID,@DATE_S,@qt
   open crs_SUPPLY_U1
   fetch next from crs_SUPPLY_U1 into @SID1,@PID1,@DATE_S1,@qt1
   while @@fetch_status=0
    BEGIN 
		
		update Products set quantity = quantity - @qt1 where pid = @pid1  
		 
		update Products set quantity = quantity + @qt where pid = @pid	 
		
        fetch next from crs_SUPPLY_U into @SID,@PID,@DATE_S,@qt
        fetch next from crs_SUPPLY_U1 into @SID1,@PID1,@DATE_S1,@qt1
    end
  CLOSE crs_SUPPLY_U
  deallocate crs_SUPPLY_U
 
 CLOSE crs_SUPPLY_U1
  deallocate crs_SUPPLY_U1
end
go

/*==============================================================*/
/* Table : CONTAIN                                              */
/*==============================================================*/

-- each time we insert into contain table total amount increase and number of products decrease 


		---  insert ---

create trigger CONTAIN_I on Contain for insert
as
begin
  if exists(select 1 from products t1,inserted t2 where t1.pid=t2.pid and t1.quantity<t2.quantity)
    rollback
	
  declare crs_CONTAIN_I cursor FOR select * from inserted
  declare @OID int, @PID int, @qt decimal(8,0), @q decimal(8,0), @i CHAR(1), @pr int
  
  open crs_CONTAIN_I
  fetch next from crs_CONTAIN_I into  @PID,@OID, @qt
  while @@fetch_status=0
   BEGIN
	    set @pr = (select price from Products where pid=@PID)

	    update Products set quantity = quantity-@qt where pid=@PID			    
	    update Order_Info set TOTAL_AMOUNT = TOTAL_AMOUNT + @qt*@pr  where oid=@OID

		
      fetch next from crs_CONTAIN_I into @PID,@OID,@qt
   END 
  CLOSE crs_CONTAIN_I
  deallocate crs_CONTAIN_I
 END
go