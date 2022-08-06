use shop 
go

/* ==================================================================================================================== */
/* TABLE : CATEGORY																										*/					
/* ==================================================================================================================== */

INSERT INTO Category(CAT_NAME) VALUES
							('winter'),
							('summer'),
							('sets');

/* ==================================================================================================================== */
/* TABLE : DEPOT																									*/					
/* ==================================================================================================================== */

INSERT INTO Depot(DNAME,DADDRESS) VALUES
							('depot1', 'address_1'),
							('depot2', 'address_2'),
							('depot3', 'address_1');

/* ==================================================================================================================== */
/* TABLE : PRODUCTS																										*/					
/* ==================================================================================================================== */

INSERT INTO Products(PNAME,PIMG,CAT_ID,PRICE,DESCRIPTION,QUANTITY,DID) VALUES
							('Winter Sky','./img/w1.jpeg',100,20,'Winter Sky by Victoria s Secret is a Aromatic fragrance for women. Winter Sky was launched in 2020.',0,1000),
							('Platinum ice','./img/w2.jpeg',100,20,'Platinum Ice by Victoria s Secret is a Fruity Floral fragrance for women. Platinum Ice was launched in 2020.',0,1000),
							('Wonderland Woods','./img/w3.jpeg',100,20,'Wonderland Woods by Victoria s Secret is a Floral Green fragrance for women. Wonderland Woods Sky was launched in 2020.',0,1000),
							('Fresh Snowfall','./img/w4.jpeg',100,20,'Fresh Snowfall by Victoria s Secret is a Floral for women. Fresh Snowfall was launched in 2020.',0,1000),
							('Love Spell Frosted','./img/w5.jpeg',100,20,'Love Spell Frosted by Victoria s Secret is a Floral for women. Love Spell Frosted was launched in 2020.',0,1000),
							('Cheers Again','./img/w6.jpeg',100,20,'Cheers Again by Victoria s Secret is a Aromatic fragrance for women. Cheers Again was launched in 2020.',0,1000),

							('Pure Seduction','./img/v1.jpeg',200,40,'Winter Sky by Victoria s Secret is a Aromatic fragrance for women. Winter Sky was launched in 2020.',0,2000),
							('Velvet Petals','./img/v2.jpeg',200,40,'Platinum Ice by Victoria s Secret is a Fruity Floral fragrance for women. Platinum Ice was launched in 2020.',0,2000),
							('Spring Poppies','./img/v3.jpeg',200,40,'Wonderland Woods by Victoria s Secret is a Floral Green fragrance for women. Wonderland Woods Sky was launched in 2020.',0,2000),
							('Blushing Berry Magnolia','./img/v4.jpeg',200,40,'Fresh Snowfall by Victoria s Secret is a Floral for women. Fresh Snowfall was launched in 2020.',0,2000),
							('Velvet Petals Decadent','./img/v5.jpeg',200,40,'Lovespell Frosted by Victoria s Secret is a Floral for women. Lovespell Frosted was launched in 2020.',0,2000),
							('Dreamy Plum Dahlia','./img/v6.jpeg',200,40,'Cheers Again by Victoria s Secret is a Aromatic fragrance for women. Cheers Again was launched in 2020.',0,2000),
							
							('Bare Vanilla','./img/s1.jpeg',300,120,'Bare Vanilla set comes with body splash and body cream was launched in 2021.',0,3000),
							('Coconut Passion','./img/s2.jpeg',300,120,'Coconut Passion set comes with body splash and body cream was launched in 2021.',0,3000),
							('Red Temptation','./img/s3.jpeg',300,120,'Red Temptation set comes with body splash and body cream was launched in 2021.',0,3000),
							('Midnight Bloom','./img/s4.jpeg',300,120,'Midnight Bloom set comes with body splash and body cream was launched in 2021.',0,3000),
							('Amber Romance','./img/s5.jpeg',300,120,'Amber Romance set comes with body splash and body cream was launched in 2021.',0,3000),
							('Aqua Kiss','./img/s6.jpeg',300,120,'Aqua Kiss set comes with body splash and body cream was launched in 2021.',0,3000);

/* ==================================================================================================================== */
/* TABLE : SUPPLIER																										*/					
/* ==================================================================================================================== */

INSERT INTO Supplier(SNAME,SPHONE,SEMAIL,SADDRESS) VALUES
							('Fadi Maalouf', 03825853, 'fadimaalouf@gmail.com', 'Beirut' ),
							('Tony Nakour', 71523980, 'tonynakour@gmail.com', 'Saida' ), 
							('Alaa Ghodban', 81200756, 'alaaghodban@gmail.com', 'Tripoli' );

/* ==================================================================================================================== */
/* TABLE : SUPPLY																										*/					
/* ==================================================================================================================== */

INSERT INTO Supply VALUES
							( 1 , 1,'2021-1-2' , 147),
							( 1 , 2,'2021-2-1' , 40),
							( 1 , 7,'2021-2-28' , 24),
							( 1 , 8,'2021-3-2' , 76),
							( 1 , 13,'2021-6-19' , 50),
							( 1 , 14,'2022-1-15' , 45),

							( 2 , 3,'2021-1-9' , 190),
							( 2 , 4,'2021-2-15' , 87),
							( 2 , 9,'2021-3-28' , 34),
							( 2 , 10,'2021-4-7' , 78),
							( 2 , 15,'2021-8-29', 190),
							( 2 , 16,'2022-1-2' , 32),

							( 3 , 6,'2021-5-7' , 215),
							( 3 , 11,'2021-10-1' , 10),
							( 3 , 17,'2021-12-22' , 74);

/* ==================================================================================================================== */
/* TABLE : DISCOUNT																									    */					
/* ==================================================================================================================== */

INSERT INTO Discount(POURCENTAGE,DIS_PRICE,START_DATE,END_DATE) VALUES
							(0 , 0  , NULL , NULL ),
							(10, 100, '2022-1-11' , '2022-5-11' ),
							(20, 300, '2022-1-11' , '2022-5-11' ),
							(50, 600, '2022-1-25' , '2022-3-2' );

/* ==================================================================================================================== */
/* TABLE : Customers																									*/					
/* ==================================================================================================================== */
INSERT INTO CUSTOMER(CNAME,PHONE,CEMAIL,COUNTRY) VALUES
							('Lynn Aouad','71658432','lynnaouad@gmail.com','Lebanon'),
							('Rana Jaafar','03697541','ranajaafar@gmail.com','Lebanon'),
							('Lynn Elmesmar','71659948','lynnelmesmar@gmail.com','Lebanon'),

							('Maya Assi','03695547','mayaassi@gmail.com','France'),

							('Joelle Haddad','81365447','joellehaddad@gmail.com','USA'),
							('Norma kawas','03669874','normakawas@gmail.com','USA'),
							('Lea hassoun','81365447','leahassoun@gmail.com','USA'),
							('Maya hassoun','03669874','mayahassoun@gmail.com','USA'),

							('Marita hellani','03669874','maritahellani@gmail.com','Italy'),

							('Savine flores','03669874','savineflores@gmail.com','Germany');


/* ==================================================================================================================== */
/* TABLE : Order_info																									*/					
/* ==================================================================================================================== */

INSERT INTO ORDER_INFO(CID,DIS_ID,OADDRESS,ODATE,TOTAL_AMOUNT) VALUES
							(1,0,'Lebanon','2022-1-25',45 ),
						
							(2,1,'Lebanon','2022-1-25',131 ),
							(3,2,'Lebanon','2022-1-25',293 ),

							(4,1,'France','2022-1-28',257 ),

							(5,1,'USA','2022-1-28',95 ),
							(6,1,'USA','2022-2-2',131 ),
				
							(9,1,'Italy','2022-2-15',221 ),
							(10,2,'Germany','2022-2-16',293 ), 

							(1,0,'Lebanon','2022-1-27',45 ),
							(1,2,'Lebanon','2022-2-4',167 ),
							(1,2,'Lebanon','2022-2-26',293 ); 
					


/* ==================================================================================================================== */
/* TABLE : Contain																									    */					
/* ==================================================================================================================== */

INSERT INTO CONTAIN(PID,OID,QUANTITY) VALUES
(1,4835,2),

(2,4836,2),
(3,4836,4),
(4,4836,1),

(16,4837,3),

(3,4838,2),
(9,4838,3),
(14,4838,1),

(1,4839,5),

(4,4840,1),
(17,4840,1),

(7,4841,2),
(8,4841,1),
(9,4841,3),

(17,4842,3),

(7,4843,1),

(10,4844,2),
(11,4844,1),
(1,4844,3),  

(13,4845,2),
(14,4845,1);

/* ==================================================================================================================== */
/* TABLE : administrator																									    */					
/* ==================================================================================================================== */

INSERT INTO ADMINISTRATOR(ADM_USERNAME,ADM_PASSWORD) VALUES
							('rana_jaafar', '97456'),
							('leen_el-mesmar', '97068'),
							('lynn_aouad', '97751');


