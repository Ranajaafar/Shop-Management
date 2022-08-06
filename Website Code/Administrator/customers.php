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
	
	<title>Customers</title>
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
	include('includes/config.php');

    <?php include("includes/header.php");?>

	<div class="ts-main-content">

	<?php include('includes/sidebar.php');?>

		<div class="content-wrapper">           
			<div class="container-fluid">  
				<div class="col-md-12">
						<h2 class="page-title">Customers</h2>

                            <!-- LIST Orders -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
							        <div class="panel-heading">All Customers</div>

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>cid</th>
                                                    <th>cname</th>	
                                                    <th>phone</th>
                                                    <th>cemail</th>	
                                                    <th>country</th>											
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
<?php

//$aid=$_SESSION['id'];

$sql = "SELECT cid,cname,phone,cemail,country FROM customer";
$result = sqlsrv_query($conn, $sql);

if ($result)
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
?>
                                            <tr>
                                                <td><?php echo $row["cid"]; ?></td>
                                                <td><?php echo $row["cname"]; ?></td>
												<td><?php echo $row["phone"]; ?></td>
                                                <td><?php echo $row["cemail"]; ?></td>
												<td><?php echo $row["country"]; ?></td>
                                            </tr>
    <?php
    }?>
												
									    </tbody>
								    </table>

						    	</div>
					    	</div>

            			</div>
       			</div>
   
		</div>
	</div>
</body>
</html>