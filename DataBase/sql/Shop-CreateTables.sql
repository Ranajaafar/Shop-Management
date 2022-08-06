/*==============================================================*/
/* DBMS name:      Microsoft SQL Server 2008                    */
/* Created on:     2/10/2022 3:22:26 PM                         */
/*==============================================================*/
use shop
go
/*==============================================================*/
/* Table: CATEGORY                                              */
/*==============================================================*/
create table CATEGORY (
   CAT_ID               int			IDENTITY(100,100)        not null,
   CAT_NAME             varchar(50)          				 not null,
   constraint PK_CATEGORY primary key nonclustered (CAT_ID)
)
go

/*==============================================================*/
/* Table: CUSTOMER                                              */
/*==============================================================*/
create table CUSTOMER (
   CID                  int   		IDENTITY(1,1)     not null,
   CNAME                varchar(50)          		  not null,
   PHONE                varchar(24)          		  not null,
   CEMAIL               varchar(1024)        		  not null,
   COUNTRY              varchar(50)          		  not null,
   constraint PK_CUSTOMER primary key nonclustered (CID)
)
go

/*==============================================================*/
/* Table: DISCOUNT                                              */
/*==============================================================*/
create table DISCOUNT (
   DIS_ID               int  		IDENTITY(0,1)    not null,
   POURCENTAGE          decimal(3,0)         		 not null,
   DIS_PRICE            int                  		 not null,
   START_DATE           date                 		 null,
   END_DATE             date                 		 null,
   constraint PK_DISCOUNT primary key nonclustered (DIS_ID)
)
go

/*==============================================================*/
/* Table: ORDER_INFO                                            */
/*==============================================================*/
create table ORDER_INFO (
   OID                  int   	IDENTITY(4835,1)    not null,
   CID                  int             	 	 not null,
   OADDRESS             varchar(1024)        	 not null,
   DIS_ID               int             	 	 null,
   ODATE                date                 	 not null,
   TOTAL_AMOUNT         int                 	 not null,
   constraint PK_ORDER_INFO primary key nonclustered (OID),
   constraint FK_ORDER_IN_PLACED_CUSTOMER foreign key (CID) references CUSTOMER (CID),
   constraint FK_ORDER_IN_HAS_DISCOUNT foreign key (DIS_ID) references DISCOUNT (DIS_ID)
)
go

/*==============================================================*/
/* Table: DEPOT                                                 */
/*==============================================================*/
create table DEPOT (
   DID                  int 	    IDENTITY(1000,1000)		 not null,
   DNAME                varchar(50)          				 not null,
   DADDRESS             varchar(1024)        				 not null,
   constraint PK_DEPOT primary key nonclustered (DID)
)
go

/*==============================================================*/
/* Table: PRODUCT                                               */
/*==============================================================*/
create table PRODUCTS (
   PID                  int 		IDENTITY(1,1)       not null,
   PNAME                varchar(50)          			not null,
   PIMG                 varchar(1024)        			not null,   
   CAT_ID               int 	             			not null,
   PRICE                int                  			not null
      constraint CKC_PRICE_PRODUCT check (PRICE >= 0),
   DESCRIPTION          varchar(1024)        			not null,
   QUANTITY             decimal(8,0)         			not null
      constraint CKC_QUANTIT_PRODUCT check (QUANTITY >= 0),
   DID                  int 	            			not null,
   constraint PK_PRODUCT primary key nonclustered (PID),
   constraint FK_PRODUCT_STOCKED_DEPOT foreign key (DID) references DEPOT (DID),
   constraint FK_PRODUCT_IN_CATEGORY foreign key (CAT_ID) references CATEGORY (CAT_ID)
)
go

/*==============================================================*/
/* Table: CONTAIN                                               */
/*==============================================================*/
create table CONTAIN (
   PID                  int 	             not null,
   OID                  int 	             not null,
   QUANTITY             decimal(8,0)         not null
      constraint CKC_QUANTITY_CONTAIN check (QUANTITY >= 1),
   constraint PK_CONTAIN primary key (PID, OID),
   constraint FK_CONTAIN_CONTAIN_ORDER_IN foreign key (OID) references ORDER_INFO (OID),
   constraint FK_CONTAIN_CONTAIN2_PRODUCTS foreign key (PID) references PRODUCTS (PID)
)
go

/*==============================================================*/
/* Table: SUPPLIER                                              */
/*==============================================================*/
create table SUPPLIER (
   SID                  int 	  IDENTITY(1,1)     not null,
   SNAME                varchar(50)          		not null,
   SPHONE               varchar(24)       		    not null,
   SEMAIL               varchar(1024)       		not null,
   SADDRESS             varchar(1024)      			null,
   constraint PK_SUPPLIER primary key nonclustered (SID)
)
go

/*==============================================================*/
/* Table: SUPPLY                                                */
/*==============================================================*/
create table SUPPLY(
   SID                  int  	             not null,
   PID                  int 	             not null,
   SDATE                date                 not null,
   QUANTITY             decimal(8,0)         not null
      constraint CKC_QUANTITY_SUPPLY check (QUANTITY >= 1),
   constraint PK_SUPPLY primary key (SID, PID, SDATE),
   constraint FK_SUPPLY_SUPPLY_PRODUCT foreign key (PID) references PRODUCTS (PID),
   constraint FK_SUPPLY_SUPPLY2_SUPPLIER foreign key (SID) references SUPPLIER (SID)
)
go

/*==============================================================*/
/* Table: ADMINISTRATOR                                         */
/*==============================================================*/

create table ADMINISTRATOR (
   ADM_ID					int			IDENTITY(1,1)        not null,
   ADM_USERNAME             varchar(50)          				 not null,
   ADM_PASSWORD             varchar(50)          				 not null,
   constraint PK_ADMINISTRATOR primary key nonclustered (ADM_ID)
)
go
