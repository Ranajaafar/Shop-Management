<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Products</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
    <style>
        .products-img{width:40%;
                        heigh:60px;
                        object-fit:cover;
                        }

    </style>
</head>

<?php
include('includes/checklogin.php');
include('includes/config.php');


if(isset($_GET['del'])){
	$id= (int) $_GET['del'];
  

	$delete="DELETE from Products where pid=?";
    $params=array($id);
	$stmt= sqlsrv_query($conn,$delete,$params);

    $createPro = "create procedure change_id
                    @id int,
                    @offset int
                    as begin
                    declare cursor_change CURSOR  for SELECT pid from Products WHERE pid>@id
                    declare @pid int
                    open cursor_change
                    fetch next from cursor_change into @pid
                    while @@fetch_status=0
                    begin
                        update Products set pid=pid-@offset where pid=@pid
                    fetch next from cursor_change into @pid
                    end
                    end";

    $exec=sqlsrv_query($conn,$createPro);

    $offset=1;

    $param=array( array($id,SQLSRV_PARAM_IN),array($offset,SQLSRV_PARAM_IN) );
    $changeID="{CALL change_id(?,?)}";
    $st=sqlsrv_query($conn,$changeID,$param);

    sqlsrv_next_result($st);

    $drop="drop procedure change_id";

    $exec2=sqlsrv_query($conn,$drop);

    header("location:products.php");
}


if($_POST['submit']){

    $pname=trim($_POST['pn']);
    $pimage=trim($_POST['pim']);
    $cat_id=trim($_POST['ci']);
    $price=trim($_POST['pr']);
    $description=trim($_POST['ds']);
    $quantity=trim($_POST['qt']);
    $did=trim($_POST['di']);

    $query="Insert into Products(PNAME,PIMG,CAT_ID,PRICE,DESCRIPTION,QUANTITY,DID)
    values('$pname','$pimage',$cat_id,$price,'$description',$quantity,$did);";
    
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
						<h2 class="page-title">Products</h2>

                            <!-- LIST PRODUCTS -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
							        <div class="panel-heading">All Products Details</div>

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>pid</th>
                                                    <th>pname</th>	
                                                    <th>pimg</th>
                                                    <th>cat_id</th>	
                                                    <th>price($)</th>	
                                                    <th>description</th>
                                                    <th>quantity</th>
                                                    <th>did</th>
                                                    <th>Action</th>											
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
<?php	
// $aid=$_SESSION['id'];

$sql="SELECT pid,pname,pimg,cat_id,price,description,quantity,did FROM Products";
$result = sqlsrv_query($conn,$sql);

if($result)
    while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC))
        {
            ?>
                                            <tr>
                                                <td><?php echo $row["pid"]; ?></td>
                                                <td><?php echo $row["pname"]; ?></td>
                                                <td style="display:flex; justify-content:center;"><img class="products-img" src='<?php echo $row["pimg"]; ?>'></td>
                                                <td><?php echo $row["cat_id"]; ?></td>
                                                <td><?php echo $row["price"]; ?>$</td>
                                                <td><?php echo $row["description"]; ?></td>
                                                <td><?php echo $row["quantity"]; ?></td>
                                                <td><?php echo $row["did"]; ?></td>
                                                <td>
                                                    <a href="edit-products.php?id=<?php echo $row["pid"];?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="products.php?del=<?php echo $row["pid"];?>"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
    <?php } ?>
												
									    </tbody>
								    </table>
                                    <form method="post" style="margin-bottom:2em;">
                                        <h3>Get number of products in a specific depot</h3>
                                        <input type="text" name="pinfo" placeholder="Depot id" required>
                                        <input type="submit" name="getNbProducts" value="go">
                                        

<?php

if(isset($_POST['getNbProducts'])){
    $did = trim($_POST['pinfo']);

    $sql = "SELECT did from depot where did=".$did;
    $result =  sqlsrv_query($conn, $sql);
    
    if(sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){

    $sql = "SELECT [dbo].[NB_OFPRODUCT](".$did.") as nb";
    $result =  sqlsrv_query($conn, $sql);

    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    
    echo "<h4>Total: ".$row['nb']."</h4>";
    }
    else{
       echo "<script> alert('Please enter a valid did!')</script>";
    }
}
?>
                                    </form> 
						    	</div>
					    	</div>

                           


                            <!-- ADD PRODUCTS -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Add Products</div>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal">
                                            
                                            <div class="hr-dashed"></div>                                       
                              

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Product Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="pn" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Product Image</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="pim" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Category ID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="ci" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Price</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="pr" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Description</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="ds" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Quantity</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="qt" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Depot ID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="di" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                           

                                            <div class="col-sm-8 col-sm-offset-2">
                                                <input class="btn btn-primary" type="submit" name="submit" value="Add Product">
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
