<?php
include('includes/checklogin.php');
include('includes/config.php');


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


</head>

<body>

    <?php include('includes/header.php');?>
 
	<div class="ts-main-content">

	<?php include('includes/sidebar.php');?>

		<div class="content-wrapper">           <!-- the div that contains the dashboard -->
			<div class="container-fluid">  
				<div class="col-md-12">
						<h2 class="page-title">All Orders Info</h2>

                            <!-- LIST Orders -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
							        <div class="panel-heading">All Order Info</div>

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>oid</th>
                                                    <th>cid</th>	
													<th>dis_id</th>
                                                    <th>cname</th>
                                                    <th>odate</th>	
													<th>oaddress</th>
                                                    <th>total_amount ($)</th>	
													<th>view order</th>     											
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
<?php


$sql = "SELECT oid,cid,oaddress,odate,dis_id,total_amount FROM ORDER_INFO";
$result = sqlsrv_query($conn, $sql);

if ($result)
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

		$sql2="SELECT cname FROM customer where cid=".$row["cid"];
		$result2 = sqlsrv_query($conn, $sql2);
		$row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)
?>
                                            <tr>
                                                <td><?php echo $row["oid"]; ?></td>
                                                <td><?php echo $row["cid"]; ?></td>
												<td><?php echo $row["dis_id"]; ?></td>
												<td><?php echo $row2["cname"]; ?></td>
                                                <td><?php echo date_format($row["odate"], 'Y-n-j'); ?></td>
                                                <td><?php echo $row["oaddress"]; ?></td>
                                                <td><?php echo $row["total_amount"]; ?>$</td>
                                                <td>
                                                    <a href="view-order.php?id=<?php echo $row["oid"]; ?>"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
    <?php
    }?>
												
									    </tbody>
								    </table>

                                    <form method="post">
                                        <h4>Get number of orders of a specific customer</h3>
                                        <input type="text" name="cinfo" placeholder="Customer id" required>
                                        <input type="submit" name="getNbOrders" value="go">
                                        

<?php

if(isset($_POST['getNbOrders'])){
    $cid = trim($_POST['cinfo']);

    $sql = "SELECT cid from customer where cid=".$cid;
    $result =  sqlsrv_query($conn, $sql);
    
    if(sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){

    $sql = "SELECT [dbo].[NB_OFORDER](".$cid.") as nb";
    $result =  sqlsrv_query($conn, $sql);

    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    
    echo "<h4>Total: ".$row['nb']."</h4>";
    }
    else{
       echo "<script> alert('Please enter a valid cid!')</script>";
    }
}
?>
                                    </form> 

                                    <hr style="margin-bottom:0;">
                                    
                                    <form method="post">
                                        <div style="display:flex; align-items:center; text-align:center;"><h4 style="margin-right:.5em; margin-top:1em;">Get number of Today's Orders</h4>
                                        <input type="submit" name="getTodayOrders" value="go"  style="margin-top:.5em; "> </div>
                                        

<?php

if(isset($_POST['getTodayOrders'])){

    $sql = "SELECT [dbo].[TODAY_ORDERS]() as nb";
    $result =  sqlsrv_query($conn, $sql);

    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    
    echo "<h4>Total: ".$row['nb']."</h4>";

}
?>
                                    </form> 

                                    <hr style="margin-bottom:0;">

                                    <form method="post">
                                        <h4>Get number of orders of a specific date</h4>
                                        <input type="text" name="cinfo2" placeholder="Order date" required>
                                        <input type="submit" name="getNbOrders2" value="go">
                                        

<?php

if(isset($_POST['getNbOrders2'])){
    $date = trim($_POST['cinfo2']);


    $sql = "SELECT [dbo].[NB_OFORDER2]('".$date."') as nb";
    $result =  sqlsrv_query($conn, $sql);

    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    
    echo "<h4>Total: ".$row['nb']."</h4>";
 
}
?>
                                    </form> 

						    	</div>
					    	</div>

            			</div>
       			</div>
   		    </div>
		</div>
	</div>
</body>
</html>