<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Shop</title>

    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&family=Tajawal:wght@200&family=Voltaire&display=swap" rel="stylesheet">

    <script src="https://code.iconify.design/2/2.1.0/iconify.min.js"></script>

    <link rel="stylesheet" href="./CSS/header.css">
    <link rel="stylesheet" href="./CSS/footer.css">
    <link rel="stylesheet" href="./CSS/index.css">

</head>

<body>
    <div class="container">
        <!-- Header -->
        <?php include('./includes/header.php'); ?> 

        <main id="main">
            <div class=title>
                <h1 id="title">VICTORIA'S SECRET</h1>
            </div>
            
            <!-- Services -->
            <div class="services">
                    <div class="logo">
                          <span id=logo1 class="iconify" data-icon="subway:world-1" data-width="30"  style="color: rgba(0, 0, 0, 0.7);" ></span> DUTY & TAXES    
                    </div>
    
                    <div class="logo"> 
                        <span class="iconify" data-icon="ic:outline-local-shipping" style="color: rgba(0, 0, 0, 0.7);" data-width="30"></span> SHIPPING OPTIONS   
                    </div>
                       
                    <div class=logo>    
                        <span class="iconify" data-icon="bi:arrow-counterclockwise" style="color: rgba(0, 0, 0, 0.7);" data-width="30"></span> RETURNS INFORMATION
                    </div>
    
                    <div class=logo>    
                        <span class="iconify" data-icon="healthicons:ui-secure-outline" style="color: rgba(0, 0, 0, 0.7);" data-width="30"></span> SECURE PAYMENT
                    </div> 
            </div>

            <!-- Slider -->
            <div class="slider">
                <img id="slideimg" src="img/img1.jpeg">

                <button class="prev" id="prev">
                    <span class="iconify-inline" data-icon="grommet-icons:form-previous" style="color: gray;" data-width="40"></span>
                </button>

                <button class="next" id="next">
                    <span class="iconify-inline" data-icon="grommet-icons:form-previous" style="color: gray;" data-width="40" data-flip="horizontal"></span>
                </button>
            </div>

            <!-- Latest Products -->
            <div class="Latest-products">
                <h3>LATEST PRODUCTS</h3>
            </div>

            <!-- Products -->
            <div class="products_container">
            <fieldset class="product">
                   <legend><span>Pure</span> Seduction</legend>
                   <img src="img/v1.jpeg">
                </fieldset>

                <fieldset class="product">
                    <legend><span>Velvet</span> Petals</legend>
                   <img src="img/v2.jpeg">
                </fieldset>

                <fieldset class="product">
                    <legend><span>Spring</span> Poppies</legend>
                   <img src="img/v3.jpeg">
                </fieldset>

                <fieldset class="product">
                    <legend><span>Blushing</span> Berry Magnolia</legend>
                   <img src="img/v4.jpeg">
                </fieldset>

                <fieldset class="product">
                    <legend><span>Velvet</span> Petals Decadent</legend>
                   <img src="img/v5.jpeg">
                </fieldset>

                <fieldset class="product">
                    <legend><span>Dreamy</span> Plum Dahlia</legend>
                   <img src="img/v6.jpeg">
                </fieldset>
            </div>
            
            <!-- About -->
            <div class="about">
                <h3>ABOUT US</h3>
            </div>

            <!-- Not tested on animals -->
            <div class="not-tested-on-animals">

                <div class="not-tested-logos">
                    <img src="./img/cruelty-free-logo-3515D2992B-seeklogo.com.png" alt="cruelty free logo">
                    <img src="./img/not-tested-on-animals-cruelty-free-pink-banner-vector-31017402-removebg-preview.png" alt="not tested on animals logo">
                </div>
    
                <fieldset class="not-tested-text">
                    <legend><span>Victoria's Secret</span> does not test on animals</legend>
    
                    <p>Victoria’s Secret & Co. is against animal testing, and no branded products, formulations or ingredients are tested on animals. To be clear, as of April 2021, all personal care products that we sell in China are made in China to avoid animal testing. Victoria’s Secret & Co. personal care products sold in the rest of the world are produced in North America and Europe.</p>
                </fieldset>
            </div>


            <div class="general-offer" id="offer">
                <div class=aside>
                    
                    <!-- Offer -->
                    <fieldset id="offer">
                        <legend>UP TO <span>30%</span> OFF</legend>
    
                        <p>Have you heard? The event of the season is in full swing with markdowns on your favorite perfumes and body splashes.</p>
                    </fieldset>
    
                    <div class="subscription">
                        
                        <!-- Social media -->
                        <div class="social-media-icons">
                            <a href="#"> <span class="iconify" data-icon="brandico:facebook"  data-width="10"></span> </a>
                          
                            <a href="#"> <span class="iconify" data-icon="ant-design:twitter-outlined"  data-width="25"></span> </a>
                           
                            <a href="#"> <span class="iconify" data-icon="akar-icons:instagram-fill" data-width="25"></span> </a>
                           
                            <a href="#"> <span class="iconify" data-icon="cib:pinterest-p"  data-width="25"></span> </a>
                        </div>
            
                        <!-- Subscription -->
                        <div class="email">
            
                            <div class="sign-up">
                                
                                <span class="iconify" data-icon="clarity:email-line"  data-width="27"></span>
                                <h3>EMAIL SUBSCRIPTION</h3>
                                
                            </div>
            
                            <div class="email-sign-up">
            
                                <p>Get the inside scoop from Victoria’s Secret and Victoria’s Secret PINK on exclusive online and in-store offers, new product alerts, store events and store openings in your area. You can unsubscribe any time. View <a href="https://www.victoriassecret.com/lb/privacy-and-security"> Contact Info </a> and <a href="https://www.victoriassecret.com/lb/privacy-and-security"> Privacy Policy</a> </p>
            
                                <form id="form">
                                    <input type="email" id="email" placeholder="Email Address *" required>
            
                                    <input type="submit" id="submit" value="SUBMIT">
                                </form>
            
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="gif">
                     <img src="./img/prod.gif" >           
                </div>
               
    
            </div> 
        </main>

        <!-- Footer -->
        <?php include('./includes/footer.php'); ?>
    </div>
    

<script src="./JS/js.js"></script>
</body>
</html>