<?php
include('includes/checklogin.php');
include('includes/config.php');

if($_POST['submit'])
{

    $supplierName=$_POST['sn'];
    $supplierTel=$_POST['pn'];
    $supplierEmail=$_POST['em'];
    $supplierAddress=$_POST['ad'];
    $id=$_GET['id'];

    $query="update Supplier set sname=?,sphone=?,semail=?,saddress=? where sid=?";
    $params2=array($supplierName,$supplierTel,$supplierEmail,$supplierAddress,$id);

    $stmt2 =sqlsrv_query($conn,$query,$params2);
  
    header("location:supplier.php");
}

if(isset($_POST['cancel']))
{
    header("location:supplier.php");
}

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
	<title>Edit Supplier</title>
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
<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
	
        <div class="content-wrapper">
			<div class="container-fluid">
                <div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Edit Supplier </h2>
	
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Edit Suppliers</div>
									<div class="panel-body">

										<form method="post" class="form-horizontal">
<?php	
	$id=$_GET['id'];
    $ret="SELECT sid,sname,sphone,semail,saddress FROM Supplier WHERE sid=?";
    $param=array($id);
    $stmt = sqlsrv_query($conn,$ret,$param);
	
	   while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC))
	  {
	  	?>
                                            <div class="hr-dashed"></div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Supplier ID </label>

                                                <div class="col-sm-8">
                                                    <input type="text"  name="ci" value="<?php echo $row["sid"];?>"  class="form-control" readonly> 
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Supplier Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="sn" value="<?php echo $row["sname"];?>" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Phone Number</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="pn" value="<?php echo $row["sphone"];?>" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Email Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="em" value="<?php echo $row["semail"];?>" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="ad" value="<?php echo $row["saddress"];?>" id="cns" value="" required="required">                     
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