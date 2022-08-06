<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Info</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./CSS/checkout.css">

    <!-- Connect to database -->
    <?php include('./includes/db_connect.php'); ?> 

</head>
<body>

<?php 

$list = $_COOKIE['prodd'];         // JSON string
$data = json_decode($list,true);   //associative array of the products that the client added to the cart
$lenght=count($data);


if(isset($_POST["placeOrder"])){  

    echo '<script>swal("Thank you for your order!", "Your order has been received, and its now being processed.", "success")</script>';

    $name = "".trim($_POST["Fname"])." ".trim($_POST["Lname"]);
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $country = $_POST["country"];
    $address = $_POST["address"];
    
    //CALLING A PROCEDURE TO PLACE THE ORDER (add the client info and the order info)
    $dis_idd=$_SESSION['discount'];
    $price_final = $_SESSION['price_final'];

    $parameters = array( array($name,SQLSRV_PARAM_IN) ,
                         array($phone,SQLSRV_PARAM_IN), 
                         array($email,SQLSRV_PARAM_IN) ,
                         array($country,SQLSRV_PARAM_IN), 
                         array($dis_idd,SQLSRV_PARAM_IN),
                         array($address,SQLSRV_PARAM_IN));

    $call_proc = "{CALL PLACE_ORDER(?,?,?,?,?,?)}";
    $stmtt =  sqlsrv_query($conn, $call_proc, $parameters);
   
    if($stmtt === false) {
        if( ($errors = sqlsrv_errors()) != null){
            foreach($errors as $error){
                echo "sqlstate:".$error['SQLSTATE']."<br>";
                echo "code:".$error['code']."<br>";
                echo "message:".$error['message']."<br>";
                echo "stmt error";}}} 


    if(sqlsrv_next_result($stmtt)===false){ 
        if( ($errors = sqlsrv_errors()) != null){
            foreach($errors as $error){
                echo "sqlstate:".$error['SQLSTATE']."<br>";
                echo "code:".$error['code']."<br>";
                echo "message:".$error['message']."<br>";
                echo "result error";}}}

    // after inserting data into costumer and order_info table we need to get the id of the order

    $query3="SELECT max(oid) as max from order_info";
    $result3 =  sqlsrv_query($conn, $query3);
    $row3 = sqlsrv_fetch_array($result3,SQLSRV_FETCH_ASSOC);
    $oid = $row3['max'];


    for($k=0; $k<$lenght; $k++){
  
        $query= "insert into Contain VALUES(".$data[$k]['id'].",".$oid.",".$data[$k]['qty'].")";                     
                            
        $stmtt2 =  sqlsrv_query($conn, $query);
    
        if($stmtt2  === false) {
            if( ($errors = sqlsrv_errors()) != null){
                foreach($errors as $error){
                    echo "sqlstate:".$error['SQLSTATE']."<br>";
                    echo "code:".$error['code']."<br>";
                    echo "message:".$error['message']."<br>";
                    echo "stmt error";}}} 


        if(sqlsrv_next_result($stmtt2)===false){ 
            if( ($errors = sqlsrv_errors()) != null){
                foreach($errors as $error){
                    echo "sqlstate:".$error['SQLSTATE']."<br>";
                    echo "code:".$error['code']."<br>";
                    echo "message:".$error['message']."<br>";
                    echo "result error";}}}}

        //The total amount in contain table is without the delivery and the discount            

        $sql2= 'UPDATE Order_Info set total_amount = ? WHERE oid = ?';
        $params = array(array($price_final,SQLSRV_PARAM_IN) , array($oid,SQLSRV_PARAM_IN));

        $stmt2 = sqlsrv_query($conn , $sql2, $params);

        if($stmt2 === false) {
            if( ($errors = sqlsrv_errors()) != null){
                foreach($errors as $error){
                    echo "sqlstate:".$error['SQLSTATE']."<br>";
                    echo "code:".$error['code']."<br>";
                    echo "message:".$error['message']."<br>";
                    echo "stmt error";}}} 

        // go to home page after 3 sec
        header("refresh:2 ; url=index.php");               
}
?>
    

<div class="container d-flex justify-content-center ">      
        <div class="col-md-8 col-sm-11 ">
             <h1 class="bllingDetails  ">Billing Details</h1>
            <form method=post id=form>

                 <div class="mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-sm-3">  
                            <label class="form-label"><b>Name*</b></label>
                        </div>
                        <div class="col-4">
                            <input name="Fname" type="text" class="form-control" placeholder="First name" aria-label="First name" required>
                        </div>
                        <div class="col-4">
                            <input name="Lname" type="text" class="form-control" placeholder="Last name" aria-label="Last name" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-sm-3">  
                             <label class="form-label"><b>Country*</b></label>
                        </div>
                        <div class="col-4">
                            <select name="country" class="form-select" aria-label="Default select example">
                                <option selected>Lebanon</option>
                                <option value="France">France</option>
                                <option value="USA">USA</option>
                                <option value="ITALY">Italy</option>
                                <option value="GERMANY">Germany</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-sm-3">  
                             <label for="inputAddress" class="form-label"><b>Address*</b></label>
                        </div>
                        <div class="col">
                             <input name="address" type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row ">
                        <div class="col-md-4 col-sm-3">  
                          <label for="exampleInputEmail" class="form-label"><b>Email address</b></label>
                        </div>
                        <div class="col">
                             <input name="email" type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp">
                             <div id="emailHelp" class="form-text">We'll inform you about the tracking informations via Email or mobile number.</div>
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-sm-3">  
                             <label class="form-label"><b>Mobile Number*</b></label>
                        </div>
                        <div class="col-4">
                             <input  name="phone" type="text" class="form-control" id="inputAddress" placeholder="03123456" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                      <p class="cond">Your personal data will be used to process your order and support your experience throughout this website.</p>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                    <label class="form-check-label" for="exampleCheck1">I have read and agree to the website <b>terms and conditions *</b></label>
                </div>

                <button type="submit" class="btn btn-primary" name="placeOrder">Place Order</button>
            </form>
        </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="./JS/js.js"></script>
</body>
</html>
