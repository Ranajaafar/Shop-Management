<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Out Of Stock</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
    <style>
        .outofstock-img{width:20%;
                        heigh:60px;
                        object-fit:cover;
                        }

    </style>

</head>

<?php
include('includes/checklogin.php');
include('includes/config.php');

?>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>

		<div class="content-wrapper">
			<div class="container-fluid">

<?php	
//$aid=$_SESSION['id'];

$sql="SELECT * FROM dbo.out_of_stock";
$params = array();
$options = array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
$result = sqlsrv_query($conn,$sql,$params,$options);  
$row_count = sqlsrv_num_rows($result);       ?>      

					<div class="col-md-12">
						<h2 class="page-title">Out Of Stock - Total items: <?php echo $row_count ?></h2>

                        <row>
                            <div class="col-md-12">
                                <div class="panel panel-default">
							        <div class="panel-heading">Out Of Stock Products Details</div>              

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>pid</th>
                                                    <th>pimg</th>	
                                                    <th>pname</th>	
                                                    <th>price($)</th>										
                                                </tr>
                                            </thead>
                                            
                                            <tbody>

<?php
if($result)
    while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC))
        {
            ?>
                                            <tr>
                                                <td><?php echo $row["PID"]; ?></td>
                                                <td><img class="outofstock-img" src="<?php echo $row["PIMG"]; ?>"></td>
                                                <td><?php echo $row["PNAME"]; ?></td>
                                                <td><?php echo $row["PRICE"]; ?></td>
                                            </tr>
    <?php } ?>
												
									    </tbody>
								    </table>
						    	</div>
					    	</div>
				        </row>

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
