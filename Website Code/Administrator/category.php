<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>Category</title>
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
    $name = $_GET['cat'];

    $delete = "DELETE from Category where cat_id=?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $delete, $params);

    $createPro = "create procedure change_id
                        @id int,
                        @offset int
                        as begin
                        declare cursor_change CURSOR  for SELECT cat_id from Category WHERE cat_id>@id
                        declare @cat_id int
                        open cursor_change
                        fetch next from cursor_change into @cat_id
                        while @@fetch_status=0
                        begin
                            update Category set cat_id=cat_id-@offset where cat_id=@cat_id
                        fetch next from cursor_change into @cat_id
                        end
                        end";

    $exec = sqlsrv_query($conn, $createPro);

    $offset = 100;

    $param = array(array($id, SQLSRV_PARAM_IN), array($offset, SQLSRV_PARAM_IN));
    $changeID = "{CALL change_id(?,?)}";
    $st = sqlsrv_query($conn, $changeID, $param);

    sqlsrv_next_result($st);

    $drop = "drop procedure change_id";

    $exec2 = sqlsrv_query($conn, $drop);

    header("location:category.php");
}


if (isset($_POST['submit'])) {

    $categoryName = trim($_POST['cn']);

    $query = "Insert into Category(CAT_NAME) values('$categoryName')";

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
						<h2 class="page-title">Category</h2>

                        <row>
                            <!-- ADD CATEGORY -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Add Categories</div>
                                    <div class="panel-body">

                                        <form method="post" class="form-horizontal">
                                            
                                            <div class="hr-dashed"></div>                                       

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Category Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="cn" id="cns" value="" required="required">                     
                                                </div>
                                            </div>

                                            <div class="col-sm-8 col-sm-offset-2">
                                                <input class="btn btn-primary" type="submit" name="submit" value="Add category">
                                            </div>                          
                                        </form>
                                    </div>
                                 </div>
                            </div>

                            <!-- LIST CATEGORY -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
							        <div class="panel-heading">All Categories Details</div>

                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>cat_id</th>
                                                    <th>cat_name</th>	
                                                    <th>Action</th>											
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
<?php

//$aid=$_SESSION['id'];

$sql = "SELECT cat_id,cat_name FROM Category";
$result = sqlsrv_query($conn, $sql);

if ($result)
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
?>
                                            <tr>
                                                <td><?php echo $row["cat_id"]; ?></td>
                                                <td><?php echo $row["cat_name"]; ?></td>
                                                <td>
                                                <a href="edit-category.php?id=<?php echo $row["cat_id"]; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                <a href="category.php?del=<?php echo $row["cat_id"]; ?>&cat=<?php echo $row["cat_name"]; ?>"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
    <?php
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
