<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');

?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>OrderInfo</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">

	<style>
		
		p{
			margin:1em 0 1em 0;
		}
		p span {
			color:red;
			font-weight:bold;
		}

		ul{
			margin-left:2em;
		}
	</style>



</head>
<?php

if(isset($_GET['id'])){
	$oid = $_GET['id'];
}


?>

<body>

    <?php include('includes/header.php');?>
 
	<div class="ts-main-content">

	<?php include('includes/sidebar.php');?>

		<div class="content-wrapper">           <!-- the div that contains the dashboard -->
			<div class="container-fluid">  
				<div class="col-md-12">
						<h2 class="page-title">Order Details</h2>
						<?php 							
							$sql3 = "SELECT * from order_info where oid=".$oid;
							$result3 =  sqlsrv_query($conn, $sql3); 
							$row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
						?>
                        <p><span>Order id:</span> <?php echo $oid ?></p>
                        <p><span>Order date:</span> <?php echo date_format($row3["ODATE"], 'Y-n-j'); ?></p>
                        <p><span>Order address:</span> <?php echo $row3['OADDRESS'] ?></p>
						<p><span>Order:</span> </p>
						
						<ul>
							<?php 
							
							$sql = "SELECT pid,quantity from contain where oid=".$oid;
							$result =  sqlsrv_query($conn, $sql);
							
							while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
								
								$sql2 = "SELECT pname,price from products where pid=".$row['pid'];
							    $result2 =  sqlsrv_query($conn, $sql2);
								$row2= sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)
								
								?>
								<li><?php echo $row2['pname']."(x".$row['quantity'].")"." : ".$row2['price']*$row['quantity']."$" ?></li>
							<?php
							}
							?>
							
						</ul>

						<?php 
							
							$sql = "SELECT pourcentage from Discount where dis_id=".$row3['DIS_ID'];
							$result =  sqlsrv_query($conn, $sql);
							$row= sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

							?>
						
						
						<p><span>Discount: </span><?php echo $row['pourcentage'] ?>% </p>
						<p><span>Delivery: </span>5$</p>

						<?php 
							
							$sql = "SELECT * from customer where cid=".$row3['CID'];
							$result =  sqlsrv_query($conn, $sql);
							$row= sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)

							?>

						<p><span>Total amount: </span><?php echo $row3['TOTAL_AMOUNT'] ?>$ </p>
						<p><span>Customer: </span><?php echo $row['CNAME'] ?> </p>
						<p><span>Customer phone: </span><?php echo $row['PHONE'] ?> </p>
						<p><span>Customer email: </span><?php echo $row['CEMAIL'] ?> </p>
						<p><span>Customer country: </span><?php echo $row['COUNTRY'] ?> </p>

                           


            			</div>
       			</div>
   		    </div>
		</div>
	</div>
</body>
</html>