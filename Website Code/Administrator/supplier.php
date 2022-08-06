<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Supplier</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<?php
include('includes/checklogin.php');
include('includes/config.php');


if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];


    $delete = "DELETE from Supplier where sid=?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $delete, $params);

    $createPro = "create procedure change_id
                    @id int,
                    @offset int
                    as begin
                    declare cursor_change CURSOR  for SELECT sid from Supplier WHERE sid>@id
                    declare @sid int
                    open cursor_change
                    fetch next from cursor_change into @sid
                    while @@fetch_status=0
                    begin
                        update Supplier set sid=sid-@offset where sid=@sid
                    fetch next from cursor_change into @sid
                    end
                    end";

    $exec = sqlsrv_query($conn, $createPro);

    $offset = 1;

    $param = array(array($id, SQLSRV_PARAM_IN), array($offset, SQLSRV_PARAM_IN));
    $changeID = "{CALL change_id(?,?)}";
    $st = sqlsrv_query($conn, $changeID, $param);

    sqlsrv_next_result($st);

    $drop = "drop procedure change_id";

    $exec2 = sqlsrv_query($conn, $drop);

    header("location:supplier.php");
}


if ($_POST['submit']) {

    $supplierName = trim($_POST['sn']);
    $supplierTel = trim($_POST['pn']);
    $supplierEmail = trim($_POST['em']);
    $supplierAddress = trim($_POST['ad']);

    $query = "Insert into Supplier(SNAME,SPHONE,SEMAIL,SADDRESS)
    values('$supplierName','$supplierTel','$supplierEmail','$supplierAddress');";

    $stmt2 = sqlsrv_query($conn, $query);

    if ($stmt2 === false) {
        if (($errors = sqlsrv_errors()) != null) {
            echo '<script>
                    alert("Insert Failed! Please check if your inputs are valid informations!")
                 </script>';
        }
    }

    sqlsrv_next_result($stmt2);
}

?>

<body>
	<?php include('includes/header.php'); ?>

	<div class="ts-main-content">
		<?php include('includes/sidebar.php'); ?>

		<div class="content-wrapper">
			<div class="container-fluid">

					<div class="col-md-12">
						<h2 class="page-title">Supplier</h2>

                            <!-- LIST SUPPLIER -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
							        <div class="panel-heading">All Suppliers Details</div>

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>sid</th>
                                                    <th>sname</th>	
                                                    <th>stel</th>
                                                    <th>semail</th>	
                                                    <th>saddress</th>	
                                                    <th>Action</th>											
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
<?php

//$aid=$_SESSION['id'];

$sql = "SELECT sid,sname,sphone,semail,saddress FROM Supplier";
$result = sqlsrv_query($conn, $sql);

if ($result)
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
?>
                                            <tr>
                                                <td><?php echo $row["sid"]; ?></td>
                                                <td><?php echo $row["sname"]; ?></td>
                                                <td><?php echo $row["sphone"]; ?></td>
                                                <td><?php echo $row["semail"]; ?></td>
                                                <td><?php echo $row["saddress"]; ?></td>
                                                <td>
                                                    <a href="edit-supplier.php?id=<?php echo $row["sid"]; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="supplier.php?del=<?php echo $row["sid"]; ?>"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
    <?php
    }?>
												
									    </tbody>
								    </table>
						    	</div>
					    	</div>

                            <!-- ADD SUPPLIER -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Add Suppliers</div>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal">
                                            
                                            <div class="hr-dashed"></div>                                       

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Supplier Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="sn" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Phone Number</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="pn" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Email Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="em" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="ad" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="col-sm-8 col-sm-offset-2">
                                                <input class="btn btn-primary" type="submit" name="submit" value="Add Supplier">
                                            </div>                          
                                        </form>
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
