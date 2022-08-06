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
	
	<title>DashBoard</title>
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
    <?php include("includes/header.php");?>

	<div class="ts-main-content">

	<?php include('includes/sidebar.php');?>

		<div class="content-wrapper">           <!-- the div that contains the dashboard -->
			<div class="container-fluid">       <!-- div -> width=100% in all breakpoints -->
                <div class="col-md-12">

						<h2 class="page-title">Dashboard</h2>
						
					 	<div class="row">

							<div class="col-md-3">
								<div class="panel panel-default">
									<div class="panel-body bk-primary text-light">
										<div class="stat-panel text-center">

<?php
$result ="SELECT * FROM Customer ";
$params=array();
$options=array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
$stmt=sqlsrv_query($conn,$result,$params,$options);
$row_count=sqlsrv_num_rows($stmt);


?>

											<div class="stat-panel-number h1 "><?php echo $row_count;?></div>
											<div class="stat-panel-title text-uppercase">Total Customers</div>
										</div>
									</div>
									<a href="customers.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
								</div>
							</div>
									
							<div class="col-md-3">                                    
								<div class="panel panel-default">            <!-- create panel -> .panel  &&  design panel -> panel-default -->
									<div class="panel-body bk-success text-light">    
										<div class="stat-panel text-center">
<?php
$result ="SELECT * FROM Order_Info ";
$params=array();
$options=array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
$stmt=sqlsrv_query($conn,$result,$params,$options);
$row_count=sqlsrv_num_rows($stmt);
?>												
											<div class="stat-panel-number h1 "><?php echo $row_count;?></div>
											<div class="stat-panel-title text-uppercase">Total Orders</div>
										</div>
									</div>
											
                                    <a href="orders.php" class="block-anchor panel-footer text-center">See All &nbsp; <i class="fa fa-arrow-right"></i></a>
								</div>
							</div>

							<div class="col-md-3">                                    
								<div class="panel panel-default">            <!-- create panel -> .panel  &&  design panel -> panel-default -->
									<div class="panel-body bk-warning text-light">    
										<div class="stat-panel text-center">
<?php
$sum = 0;

$sql = "SELECT [dbo].[total_amount]() as nb";
$result =  sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

?>												
											<div class="stat-panel-number h1 "><?php echo $row['nb'];?>$</div>
											<div class="stat-panel-title text-uppercase">Total Money</div>
										</div>
									</div>
									<a href="#" class="block-anchor panel-footer text-center">Total &nbsp; <i class="fa fa-arrow-right"></i></a>
									
				
								</div>
							</div>

						</div>
						<div class="col-md-12" style="left:-1em;">
                            <div class="panel panel-default">
							    <div class="panel-heading">Customers Countries</div>
                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Lebanon</th>
                                                    <th>France</th>	
                                                    <th>USA</th>
                                                    <th>Italy</th>	
                                                    <th>Germany</th>											
                                                </tr>
                                            </thead>
											<tbody>
	<?php
	$sql1 = "SELECT [dbo].[country_pourcentage]('Lebanon') as pr1";
    $result1 =  sqlsrv_query($conn, $sql1);
    $row1 = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC);

	$sql2 = "SELECT [dbo].[country_pourcentage]('France') as pr2";
    $result2 =  sqlsrv_query($conn, $sql2);
    $row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);

	$sql3 = "SELECT [dbo].[country_pourcentage]('USA') as pr3";
    $result3 =  sqlsrv_query($conn, $sql3);
    $row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);

	$sql4 = "SELECT [dbo].[country_pourcentage]('Italy') as pr4";
    $result4 =  sqlsrv_query($conn, $sql4);
    $row4 = sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);

	$sql5 = "SELECT [dbo].[country_pourcentage]('Germany') as pr5";
    $result5 =  sqlsrv_query($conn, $sql5);
    $row5 = sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);

  
	?>
   
												<tr>
													<td><?php echo $row1["pr1"]; ?>%</td>
													<td><?php echo $row2["pr2"]; ?>%</td>
													<td><?php echo $row3["pr3"]; ?>%</td>
													<td><?php echo $row4["pr4"]; ?>%</td>
													<td><?php echo $row5["pr5"]; ?>%</td>
												</tr>

												
									    	</tbody>
								    </table>

						    	</div>
							</div>
					</div>
				</div>


			    </div>


		    </div>
	    </div>
    </div>
    

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
	


</body>

</html>