<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summer Section</title>

    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&family=Tajawal:wght@200&family=Voltaire&display=swap" rel="stylesheet">

    <script src="https://code.iconify.design/2/2.1.0/iconify.min.js"></script>
    
   
    <link rel="stylesheet" href="./CSS/header.css">
    <link rel="stylesheet" href="./CSS/productSection.css">
    <link rel="stylesheet" href="./CSS/footer.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Connect to database -->
    <?php include('./includes/db_connect.php'); ?> 

</head>

<body>
    <div class="container">
        <!-- Header -->
        <?php include('./includes/header.php'); ?> 
       
        <main id="main">
            <div class=title>
                <h1 id="title">SUMMER COLLECTION</h1>
            </div>

            <?php 
                // import all the products in winter collection
                $sql = "SELECT pid,pname,pimg,price, description From dbo.on_stock WHERE cat_id=200";

                // prepare and execute the query -> return a statement recource on success and false if an error occurred
                $result = sqlsrv_query($conn , $sql);
            
                if($result){
                    // returns a row as an associative array
                    while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
            ?>

            <div class="productContainer">
                
                <fieldset class="PRODUCT">
                    <legend id="legend"> <?php echo $row["pname"] ?>  </legend>
                    <img id="img" src="<?php echo $row["pimg"] ?>">
                </fieldset>
                
                <div class="productInfo">
                    <div class="price"> 
                        <p> <b>Price:</b> <span id="PRICE" ><?php echo $row["price"] ?></span> <span class="iconify-inline" data-icon="noto:heavy-dollar-sign" data-width="30"></span></p>     
                    </div>

                    <div class="description">
                        <h3>Description</h3>
                        <?php echo $row["description"] ?>
                    </div>

                    <div class="CART">
                        <div class="quantity">
                            <h3>Select Quantity</h3>

                            <div class="qtybtns">
                                <input type="button" value="-" class="QTY" id="sus" >
                                    <span id="counter" name="quantity">1</span>
                                 <input type="button" value="+" class="QTY" id="addq">
                            </div>  

                            <?php 
                               
                                $id = $row["pid"];

                                $sql3 = "SELECT [dbo].[GET_QT](".$id.") as Q";
                                $result3 = sqlsrv_query($conn, $sql3);
                                $row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
                            ?>
                            <span style="display:none;" id="prodID"><?php echo "$id" ?></span>
                             <span style="display:none;" id="availableQty"><?php echo $row3['Q'] ?></span>
                             <span  id="warning_quantity"></span>    
                        </div>

                        <div class="AddToCart">    
                            <button class="cartbtn" id="addToCart">
                                <span class="iconify-inline" data-icon="ant-design:shopping-cart-outlined" style="color: black;" data-width="20"></span> ADD TO CART
                            </button> 
                        </div>
                    </div>
                </div>
            </div>

            <?php }} ?> 
        </main>

        <!-- Footer -->
        <?php include('./includes/footer.php'); ?>
    </div>

<script src="./JS/js.js"></script>
</body>
</html>