# Shop Management
### Technologies:

<img src="https://img.shields.io/badge/-MS%20SQL-4169E1?logo=Microsoft%20SQL%20Server&logoColor=fff" /> <img src="https://img.shields.io/badge/-Power%20Designer-EF4223?logo=Power%20Designer&logoColor=fff" />
<img src="https://img.shields.io/badge/-PHP-5F259F?logo=PHP&logoColor=fff" />
<img src="https://img.shields.io/badge/-HTML-19A974?logo=html5&logoColor=fff" />
<img src="https://img.shields.io/badge/-CSS-1BA0D7?logo=css3&logoColor=fff" />
<img src="https://img.shields.io/badge/-JavaScript-FC4C02?logo=JavaScript&logoColor=fff" />
<img src="https://img.shields.io/badge/-Batch%20File-68A51C?logo=Batch%20File&logoColor=fff" />
<br/><br/>




<!--

https://user-images.githubusercontent.com/110610925/183263601-290de8a6-35f2-4185-a751-5a05a98c8c0d.mp4

-->


In this project we have developed two Web applications:
- User Interface
- Administrator Interface
<h2 align="center" >User Side</h2>
We have developed a user interface for the shop. The user will need first to access the website, all the 
products will be displayed in categories, then he will add to cart all the products that he wants to buy, he can 
remove from cart also. When the user wants to complete the purchase, he will check out, all the calculations 
are made including if there is a discount or not, then the total amount is displayed on the screen, if the user 
wants to continue he will need to insert all his billing details, then place the order.
The order and costumer details will be updated into the database and the administrator system.


<h2 align="center" >Admin Side</h2>
We have developed a Shop Management System. The basic concept to develop this system was to manage 
shop products, orders, sales and manage all the functionalities related to the shop… 
The admin first will need to login then he will be able to:




- Manage products sales
- Manage products stocks
-  Manage products categories
- Manage depots
- Manage products discounts
- Manage suppliers and their supplies
- View all orders information 
- View customers

All those changes will be updated directly into the database.

<br/><br/>

### Application Architecture:
<img src="https://user-images.githubusercontent.com/110610925/183241102-922a6400-5dca-47b9-b889-605fba97dda2.png" width="45%" align="left" />
<img src="https://user-images.githubusercontent.com/110610925/183241103-5af535c5-5908-47aa-b6db-ff364f7eaa85.png" width="48%" />

<br/><br/>

### Database Modeling :
For our project we used <b> <I>power Designer</I> </b> to design the ER and physical diagram that helped us with the creation of database and the generation of the tables and indexes. 

<h2 align="center" >ER Diagram(ERD)</h2>



![Shop-ERD](https://user-images.githubusercontent.com/110610925/183241210-8b2d2743-c5ed-46a8-9597-2f10fae0b1e9.jpg)

<h2 align="center" >Physical-Data-Model(PDM)</h2>


![Shop-PDM](https://user-images.githubusercontent.com/110610925/183241248-02ba6d94-29bc-4220-8d59-923e9242943b.png)

Create DDL script:
- <a href="https://raw.githubusercontent.com/Ranajaafar/Shop-Management/main/DataBase/sql/Shop-CreateTables.sql
" target=blank > Create Tables</a>
- <a href="https://raw.githubusercontent.com/Ranajaafar/Shop-Management/main/DataBase/sql/Shop-CreateIndexes.sql" target=blank >Create Indexes</a>
- <a href="https://raw.githubusercontent.com/Ranajaafar/Shop-Management/main/DataBase/sql/Shop-CreateViews.sql" target=blank >Create Views</a>
- <a href="https://raw.githubusercontent.com/Ranajaafar/Shop-Management/main/DataBase/sql/Shop-CreateProcedures.sql" target=blank >Create Procedures</a>
- <a href="https://raw.githubusercontent.com/Ranajaafar/Shop-Management/main/DataBase/sql/Shop-CreateTriggers.sql" target=blank >Create Triggers</a>
- <a href="https://raw.githubusercontent.com/Ranajaafar/Shop-Management/main/DataBase/sql/Shop-CreateFunctions.sql" target=blank >Create Functions</a>
- <a href="https://raw.githubusercontent.com/Ranajaafar/Shop-Management/main/DataBase/sql/Shop-CreateLogins.sql" target=blank >Create Logins with User and Priviligies</a>

<b>Batch File</b>
~~~~~~~~~~~
set LOC=C:\Users\hp\Desktop\Project\DataBase
set SERV=-S HP-PC\SQLEXPRESS -U sa -P RanaJaafar

echo Beginning...

osql %SERV% -i%LOC%\sql\Shop-CreateDB.sql -o%LOC%\log\DB.log
echo Database created...

osql %SERV% -i%LOC%\sql\Shop-CreateTables.sql -o%LOC%\log\Tables.log
echo Tables created...

osql %SERV% -i%LOC%\sql\Shop-CreateIndexes.sql -o%LOC%\log\Indexes.log
echo Indexes created...

osql %SERV% -i%LOC%\sql\Shop-CreateViews.sql -o%LOC%\log\Views.log
echo Views created...

osql %SERV% -i%LOC%\sql\Shop-CreateProcedures.sql -o%LOC%\log\Procedures.log
echo Procedures created...

osql %SERV% -i%LOC%\sql\Shop-CreateTriggers.sql -o%LOC%\log\Triggers.log
echo Triggers created...

osql %SERV% -i%LOC%\sql\Shop-CreateFunctions.sql -o%LOC%\log\Functions.log
echo Functions created...

osql %SERV% -i%LOC%\sql\Shop-InsertData.sql -o%LOC%\log\Data.log
echo Data inserted...

osql %SERV% -i%LOC%\sql\Shop-CreateLogins.sql -o%LOC%\log\Logins.log
echo Logins created...

echo End of batch file...

~~~~~~~~~~~


for execute all the sql Script you have set LOC by the path of folder DataBase in your machine,and set SERV by Login and Password of MS SQL
