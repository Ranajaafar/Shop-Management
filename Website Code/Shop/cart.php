<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART</title>

    <script src="https://code.iconify.design/2/2.1.0/iconify.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&family=Tajawal:wght@200&family=Voltaire&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" href="./CSS/AddToCart.css">

    <!-- Connect to database -->
    <?php include('./includes/db_connect.php'); ?> 
</head>

<body>

<?php

if(isset($_COOKIE['prodd'])){
    $list = $_COOKIE['prodd'];  // JSON string
    $data = json_decode($list,true); //associative array
    //var_dump($data);

    if($data != 0){
        for($k=0; $k<count($data); $k++){
            $index = 'b'.$k;

            if(isset($_POST[$index])){
                // we remove the selected product
                array_splice($data,$k,1);  

                //if we remove all the items from the cart
                if(count($data) == 0){   ?>

                    <!-- HTML CODE FOR EMPTY CART -->
                    <div class="container">
                    <main class="main2">
                        <div class="return">
                            <button onclick="location.href='index.php';">
                                <span class="iconify-inline" data-icon="ion:arrow-back-outline" style="color: black;" data-width="50"></span>
                            </button>
                                <h1>Cart (0)</h1>       
                        </div>
                        <div>
                             <span class="iconify" data-icon="fluent:shopping-bag-24-regular" style="color: gray;" data-width="150"></span>
                        </div>
                
                        <h1>No products in the cart.</h1>
                
                    </main>
                </div>

<?php
                }   
                else{
                    $data2 = json_encode($data);  //JSON string
                    setcookie('prodd',$data2);
                    
                    break;}}}    


        $carttotal = 0;
        for($l=0; $l<count($data); $l++)
            $carttotal = $carttotal + (int)$data[$l]["price"]*(int)$data[$l]["qty"];

       
        //CALLING A PROCEDURE TO KNOW IF THERE'S A DISCOUNT OR NOT
        $price_final = 0;  // result + discount + delivery
        $pourcentage = 0;  //int
        $dis_id = 0;
     
        $parameters = array( array($carttotal,SQLSRV_PARAM_IN) , 
                             array(&$price_final,SQLSRV_PARAM_OUT), 
                             array(&$pourcentage,SQLSRV_PARAM_OUT), 
                             array(&$dis_id,SQLSRV_PARAM_OUT));

        $call_proc = "{CALL FETCH_DIS(?,?,?,?)}";
        $stmtt =  sqlsrv_query($conn, $call_proc, $parameters);                 
     
        // to put the result in the out parameter
        if(sqlsrv_next_result($stmtt)===false){ 
            if( ($errors = sqlsrv_errors()) != null){
                foreach($errors as $error){
                    echo "sqlstate:".$error['SQLSTATE']."<br>";
                    echo "code:".$error['code']."<br>";
                    echo "message:".$error['message']."<br>";
                    echo "result error";}}}
   

       $_SESSION["discount"]=$dis_id;
       $_SESSION["price_final"]=$price_final;
      
?> 
    
    <div class="container">
        <main id="main">
         <div class="return">
            <button onclick="location.href='index.php';">
                  <span class="iconify-inline" data-icon="ion:arrow-back-outline" style="color: black;" data-width="50"></span>
            </button>
            <h1>Cart (<?php echo count($data) ?>)</h1>
        </div>

        <?php for($i=0; $i<count($data);$i++){ ?>
                
            <div class=product>
                <img src="<?php echo $data[$i]["image"] ?>" >
                
                <div class=details>
                    <div class="title">
                        <h3 class=name><?php echo $data[$i]["name"] ?></h3>
                        
                        <form id=form method="post">
                        <button class="rem" id="remP" name="b<?php echo $i ?>" onclick='form.submit();'>
                            <span class="iconify-inline" data-icon="carbon:close-outline" style="color: darkgray;" data-width="20"></span>
                        </button>
                        </form> 
                    </div>
                    
                    <div class="info">
                        <span class="qty">Qty <?php echo $data[$i]["qty"] ?></span>
                        <span class="price"><?php echo $data[$i]["price"] ?><span class="iconify-inline" data-icon="noto:heavy-dollar-sign" data-width="20"></span></span>
                    </div>
                </div>
            </div>

            <?php } ?>

            <div class=totalPrice>
                <div class=cartTotal>
                    <h2>Cart Total</h2>

                    <p>
                        <input type="checkbox" checked disabled=disabled>  <?php echo $carttotal ?><span class="iconify-inline" data-icon="noto:heavy-dollar-sign" data-width="20"></span>
                    </p>
                </div>

                <div class=discount>
                    <h2>Discount</h2>

                    <p>
                        <input type="checkbox" checked disabled=disabled> <?php echo $pourcentage ?>%<span class="iconify-inline" data-icon="noto:heavy-dollar-sign" data-width="20"></span>
                    </p>
                </div>

                <div class=shipping>
                    <h2>Shipping</h2>

                    <p>
                        <input type="checkbox" checked disabled=disabled>5<span class="iconify-inline" data-icon="noto:heavy-dollar-sign" data-width="20"></span>
                    </p>
                </div>
                
                <div class=total>
                    <h2>Total</h2>

                    <p>
                        <?php echo $price_final ?><span class="iconify-inline" data-icon="noto:heavy-dollar-sign" data-width="20"></span>
                    </p>
                </div>

                <div class=payment>
                    <h2>Payment</h2>

                    <p>
                        <input type="checkbox" checked  disabled=disabled> Cash on delivery
                    </p>
                </div>
            </div>

            <form method=post action=checkout.php>
                 <input type="submit" class="placeorder" value="Checkout" >
            </form>

        </main>
    </div>

<?php   //if the cart is emty from the beginning
    }
    else{ ?>

        <div class="container">
        <main class="main2">
            <div class="return">
                <button onclick="location.href='index.php';">
                    <span class="iconify-inline" data-icon="ion:arrow-back-outline" style="color: black;" data-width="50"></span>
                </button>
                    <h1>Cart (0)</h1>
                    
            </div>
            <div>
                 <span class="iconify" data-icon="fluent:shopping-bag-24-regular" style="color: gray;" data-width="150"></span>
            </div>
    
            <h1>No products in the cart.</h1>
    
        </main>
    </div>

<?php   }};   ?>

<script src="./JS/js.js"></script>
</body>
</html>


