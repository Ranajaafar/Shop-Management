<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Supply</title>
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


if(isset($_GET['del'])){
	$id= (int) $_GET['del'];
    $pid= (int) $_GET['pid'];
    $date=  $_GET['sdate'];
  

	$delete="DELETE from Supply where sid=? and pid=? and sdate=?";
    $params=array($id,$pid,$date);
	$stmt= sqlsrv_query($conn,$delete,$params);


    header("location:supply.php");
}


if($_POST['submit']){

    $supplierID=trim($_POST['si']);
    $productID=trim($_POST['pi']);
    $date=trim($_POST['dt']);
    $quantity=trim($_POST['qt']);

    $params2=array($supplierID,$productID,$date,$quantity);
    $query="insert into Supply values (?,?,?,?)";
    
    $stmt2=sqlsrv_query($conn,$query,$params2);

    if ($stmt2 === false) {
        if (($errors = sqlsrv_errors()) != null) {
            echo '<script>
                    alert("Insert Failed! Please check if your inputs are valid informations!")
                 </script>';
        }
    }
    
    sqlsrv_next_result($stmt2);}
  

    
 


?>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>

		<div class="content-wrapper">
			<div class="container-fluid">

					<div class="col-md-12">
						<h2 class="page-title">Supply</h2>

                            <!-- LIST SUPPLY -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
							        <div class="panel-heading">All Supplies Details</div>

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>supplier</th>
                                                    <th>sid</th>
                                                    <th>product</th>
                                                    <th>pid</th>	
                                                    <th>date</th>	
                                                    <th>quantity</th>	
                                                    <th>Action</th>											
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
<?php	
//$aid=$_SESSION['id'];

$sql="SELECT sid,pid,sdate,quantity FROM Supply";
$result = sqlsrv_query($conn,$sql);



if($result)
    while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC))
        {
            $sql2="SELECT sname FROM Supplier where sid=".$row['sid'];
            $result2 = sqlsrv_query($conn,$sql2);
            $row2=sqlsrv_fetch_array($result2,SQLSRV_FETCH_ASSOC);

            $sql3="SELECT pname FROM Products where pid=".$row['pid'];
            $result3 = sqlsrv_query($conn,$sql3);
            $row3=sqlsrv_fetch_array($result3,SQLSRV_FETCH_ASSOC);
            ?>
                                            <tr>
                                                <td><?php echo $row2['sname']; ?> </td>
                                                <td><?php echo $row['sid']; ?></td>
                                                <td><?php echo $row3["pname"]; ?></td>
                                                <td><?php echo $row['pid']; ?></td>
                                                <td><?php echo date_format($row["sdate"],'Y-n-j'); ?></td>
                                                <td><?php echo $row["quantity"]; ?></td>
                                                <td>
                                                    <a href="edit-supply.php?sid=<?php echo $row["sid"];?>&pid=<?php echo $row["pid"];?>&sdate=<?php echo date_format($row["sdate"],'Y-n-j');?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="supply.php?del=<?php echo $row["sid"];?>&pid=<?php echo $row["pid"];?>&sdate=<?php echo date_format($row["sdate"],'Y-n-j');?>"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
    <?php } ?>
												
									    </tbody>
								    </table>

                                    <hr />

                                    <form method="post" style="margin-bottom:2em;">
                                <h4>Get total number of today's supplies for a specific supplier</h4>
                                <input type="text" name="sinfo" placeholder="Supplier id" required>
                                <input type="submit" name="getNbSupplies" value="go">
                            
                            <?php

if(isset($_POST['getNbSupplies'])){
    $supid = trim($_POST['sinfo']);

    $sql = "SELECT sid from supplier where sid=".$supid;
    $result =  sqlsrv_query($conn, $sql);
 
    
    if(sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){


    $sql = "SELECT [dbo].[NB_OFSUPPLY](".$supid.") as nb";
    $result =  sqlsrv_query($conn, $sql);

    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    
    echo "<h4>Total: ".$row['nb']."</h4>";
    }
    else{
       echo "<script> alert(\"Please enter a valid sid!\") </script>";
    }
}
?>      
                </form>

                <hr />

                <form method="post" style="margin-bottom:2em;">
                    <h4>Transfer Supplies</h4>
                    <input type="text" name="s1" placeholder="From Supplier id" required>
                    <input type="text" name="s2" placeholder="To Supplier id" required>
                    <input type="submit" name="transfer" value="Transfer">

                    <?php

                    if(isset($_POST['transfer'])){
                        $s1 = trim($_POST['s1']);
                        $s2 = trim($_POST['s2']);

                        $sql = "SELECT count(*) as count from supplier s1, supplier s2 where s1.sid=".$s1." AND s2.sid=".$s2;
                        $result =  sqlsrv_query($conn, $sql);
                        $row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                        
                        if($row['count'] == 1){

                
                        $parameters = array( array($s1,SQLSRV_PARAM_IN) ,
                        array($s2,SQLSRV_PARAM_IN));

                        $call_proc = "{CALL TRANSFORME(?,?)}";
                        $stmtt =  sqlsrv_query($conn, $call_proc, $parameters);

                        if(sqlsrv_next_result($stmtt)===false){ 
                            if( ($errors = sqlsrv_errors()) != null){
                                foreach($errors as $error){
                                    echo "sqlstate:".$error['SQLSTATE']."<br>";
                                    echo "code:".$error['code']."<br>";
                                    echo "message:".$error['message']."<br>";
                                    echo "result error";}}}
                        }
                        else{
                            echo "<script> alert('Please enter a valid sid!')</script>";
                        }}
                                    ?>      
                </form>

						    	</div>
					    	</div>
  


                            <!-- ADD SUPPLY -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Add Supplies</div>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal">
                                            
                                            <div class="hr-dashed"></div>                                       

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Supplier ID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="si" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Product ID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="pi" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Date</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="dt" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Quantity</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="qt" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="col-sm-8 col-sm-offset-2">
                                                <input class="btn btn-primary" type="submit" name="submit" value="Add Supply">
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
