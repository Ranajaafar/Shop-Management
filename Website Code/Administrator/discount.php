<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Discount</title>
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


    $update = "UPDATE ORDER_INFO SET DIS_ID=null WHERE DIS_ID=" . $id;
    $stmt3 = sqlsrv_query($conn, $update);

    if ($stmt3 === false) {
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "sqlstate:" . $error['SQLSTATE'] . "<br>";
                echo "code:" . $error['code'] . "<br>";
                echo "message:" . $error['message'] . "<br>";
                echo "stmt error";
            }
        }
    }

    if (sqlsrv_next_result($stmt3)) {
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "sqlstate:" . $error['SQLSTATE'] . "<br>";
                echo "code:" . $error['code'] . "<br>";
                echo "message:" . $error['message'] . "<br>";
                echo "result error";
            }
        }
    }




    $delete = "DELETE from Discount where dis_id=" . $id;
    $stmt = sqlsrv_query($conn, $delete);

    $createPro = "create procedure change_id
                        @id int,
                        @offset int
                        as begin
                        declare cursor_change CURSOR  for SELECT dis_id from Discount WHERE dis_id>@id
                        declare @dis_id int
                        open cursor_change
                        fetch next from cursor_change into @dis_id
                        while @@fetch_status=0
                        begin
                            update Discount set dis_id=dis_id-@offset where dis_id=@dis_id
                        fetch next from cursor_change into @dis_id
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

    header("location:discount.php");
}


if (isset($_POST['submit'])) {

    $pourcentage = trim($_POST['pr']);
    $price = trim($_POST['dp']);
    $startdate = $_POST['sd'];
    $enddate = $_POST['ed'];

    $query = "Insert into Discount(POURCENTAGE,DIS_PRICE,START_DATE,END_DATE)
values($pourcentage,$price,'$startdate','$enddate');";
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


if (isset($_POST['out-dated'])) {


    $query = "{CALL DELETE_DIS}";
    $stmt2 = sqlsrv_query($conn, $query);

    sqlsrv_next_result($stmt2);

    header("location:discount.php");
}

?>

<body>
	<?php include('includes/header.php'); ?>

	<div class="ts-main-content">
		<?php include('includes/sidebar.php'); ?>

		<div class="content-wrapper">
			<div class="container-fluid">

					<div class="col-md-12">
						<h2 class="page-title">Discount</h2>

                        <row>
                            <!-- ADD DISCOUNT -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Add Discount</div>
                                    <div class="panel-body">

                                        <form method="post" name="Filter" class="form-horizontal">
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">%</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="pr" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">price</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="dp" id="cns" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">startDate</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" name="sd" id="cns" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">endDate</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" name="ed" id="cns" required="required">                     
                                                </div>
                                            </div>

                                            <div class="col-sm-8 col-sm-offset-2">
                                                <input class="btn btn-primary" type="submit" name="submit" value="Add discount">
                                            </div>   

                                        </form>
                                    </div>
                                </div>

                                <form method="post" class="form-horizontal">
                                    <h3>Delete all out dated Discounts!</h3>
                                    <div class="col-sm-8">
                                         <input class="btn btn-primary" type="submit" name="out-dated" value="Delete">
                                    </div>  
                                </form>

                            </div>

                            <!-- list Discount -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
							        <div class="panel-heading">All Discounts Details</div>

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>dis_id</th>
                                                    <th>%</th>
                                                    <th>dis_price</th>	
                                                    <th>start_date</th>	
                                                    <th>end_date</th>
                                                    <th></th>										
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
<?php

//$aid=$_SESSION['id'];

$sql = "SELECT dis_id,pourcentage,dis_price,start_date,end_date FROM Discount";
$result = sqlsrv_query($conn, $sql);

if ($result)
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        if ($row["dis_id"] != 0) {


?>
                                            <tr>
                                                <td><?php echo $row["dis_id"]; ?></td>
                                                <td><?php echo $row["pourcentage"]; ?>%</td>
                                                <td><?php echo $row["dis_price"]; ?>$</td>
                                                <td><?php echo date_format($row["start_date"], 'Y-n-j'); ?></td>
                                                <td><?php echo date_format($row["end_date"], 'Y-n-j'); ?></td>

                                                <td>
                                                    <a href="discount.php?del=<?php echo $row["dis_id"]; ?>"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>

    <?php
        }
    }?>
												
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
