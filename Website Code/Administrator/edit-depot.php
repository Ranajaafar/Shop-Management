<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Edit Depot</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
</head>

<?php
include('includes/checklogin.php');
include('includes/config.php');



if(isset($_POST['submit']))
{

    $depotName=$_POST['dn'];
    $depotAddress=$_POST['da'];
    $id=$_GET['id'];

    $query="update Depot set dname=?, daddress=? where did=?";
    $params2=array($depotName,$depotAddress,$id);

    $stmt2 =sqlsrv_query($conn,$query,$params2);
  
    header("location:depot.php");
}

if(isset($_POST['cancel']))
{
    header("location:depot.php");
}

?>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
	
        <div class="content-wrapper">
			<div class="container-fluid">
                <div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Edit Depot </h2>
	
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Edit Depots</div>
									<div class="panel-body">

										<form method="post" class="form-horizontal">
<?php	
	$id=$_GET['id'];
	$ret="SELECT did,dname,daddress FROM Depot WHERE did=?";
    $param=array($id);
    $stmt = sqlsrv_query($conn,$ret,$param);
	
	   while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC))
	  {
	  	?>
                                            <div class="hr-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Depot ID </label>

                                                <div class="col-sm-8">
                                                    <input type="text"  name="di" value="<?php echo $row["did"];?>"  class="form-control" readonly> 
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Depot Name</label>

                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="dn" id="cns" value="<?php echo $row["dname"];?>" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Depot Address</label>

                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="da" id="cns" value="<?php echo $row["daddress"];?>" required="required">
                                                </div>
                                            </div>

<?php } ?>
                                            <div class="col-sm-8 col-sm-offset-2">							
                                                <input class="btn btn-primary" type="submit" name="submit" value="Update">
                                                
                                                <input class="btn btn-primary" type="submit" name="cancel" value="Cancel">
                                            </div>
			                        	</form>
                                    </div>
	                            </div>
                            </div>
						</div>
					</div>
            </div>
		</div> 					
	</div>
	
	
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>

</script>
</body>

</html>