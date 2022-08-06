<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Depot</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<?php
include('includes/checklogin.php');
include('includes/config.php');


if(isset($_GET['del'])){
	$id= (int) $_GET['del'];
  

	$delete="DELETE from Depot where did=?";
    $params=array($id);
	$stmt= sqlsrv_query($conn,$delete,$params);

    $createPro = "create procedure change_id
                    @id int,
                    @offset int
                    as begin
                    declare cursor_change CURSOR  for SELECT did from Depot WHERE did>@id
                    declare @did int
                    open cursor_change
                    fetch next from cursor_change into @did
                    while @@fetch_status=0
                    begin
                        update DEPOT set did=did-@offset where did=@did
                    fetch next from cursor_change into @did
                    end
                    end";

    $exec=sqlsrv_query($conn,$createPro);

    $offset=1000;

    $param=array( array($id,SQLSRV_PARAM_IN),array($offset,SQLSRV_PARAM_IN) );
    $changeID="{CALL change_id(?,?)}";
    $st=sqlsrv_query($conn,$changeID,$param);

    sqlsrv_next_result($st);

    $drop="drop procedure change_id";

    $exec2=sqlsrv_query($conn,$drop);

    header("location:depot.php");
}


if($_POST['submit']){

    $depotName= trim($_POST['dn']);
    $depotAddress= trim($_POST['da']);

    $query="Insert into Depot(DNAME,DADDRESS)
    values('$depotName','$depotAddress');";
    
    $stmt2=sqlsrv_query($conn,$query);

    if($stmt2 === false){
        if( ($errors = sqlsrv_errors()) != null){
            echo '<script>
                    alert("Insert Failed! Please check if your inputs are valid informations!")
                 </script>';   }}
    
    sqlsrv_next_result($stmt2);
 
}

?>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>

		<div class="content-wrapper">
			<div class="container-fluid">

					<div class="col-md-12">
						<h2 class="page-title">Depot</h2>

                        <row>
                            <!-- ADD DEPOT -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Add Depot</div>
                                    <div class="panel-body">

                                        <form method="post" class="form-horizontal">
                                            
                                            <div class="hr-dashed"></div>                                       

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Depot Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="dn" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Depot Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="da" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="col-sm-8 col-sm-offset-2">
                                                <input class="btn btn-primary" type="submit" name="submit" value="Add Depot">
                                            </div>                          
                                        </form>
                                    </div>
                                 </div>
                            </div>

                            <!-- LIST DEPOT -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
							        <div class="panel-heading">All Depots Details</div>

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>did</th>
                                                    <th>dname</th>	
                                                    <th>daddress</th>
                                                    <th>Action</th>											
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
<?php	
//$aid=$_SESSION['id'];

$sql="SELECT did,dname,daddress FROM Depot";
$result = sqlsrv_query($conn,$sql);

if($result)
    while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC))
        {
            ?>
                                            <tr>
                                                <td><?php echo $row["did"]; ?></td>
                                                <td><?php echo $row["dname"]; ?></td>
                                                <td><?php echo $row["daddress"]; ?></td>
                                                <td>
                                                    <a href="edit-depot.php?id=<?php echo $row["did"];?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="depot.php?del=<?php echo $row["did"];?>"><i class="fa fa-close"></i></a>
                                                </td>
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
