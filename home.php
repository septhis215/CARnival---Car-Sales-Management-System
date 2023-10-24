<?php

if(!isset($_SESSION)){
  session_start();
  
}

include_once("connections/connect.php");
$con=connect();

        $id=0;
        $fname = "";
        $lname = "";
        $email = "";
        $password = "";
        $address = "";
        $phone = "";
        $signup=false;
        $payment=false;
        $cod=false;
 
         
        $sql = "SELECT * FROM tbluser";
        $users = $con->query($sql) or die ($con->error);
        $row = $users->fetch_assoc();

        $sql = "SELECT * FROM tblinventory order by rand() LIMIT 12 ";
        $items1 = $con->query($sql) or die ($con->error);

        $sql = "SELECT * FROM tblinventory order by rand() LIMIT 12";
        $items2 = $con->query($sql) or die ($con->error);

        $sql = "SELECT * FROM tblinventory order by rand() LIMIT 12";
        $items3 = $con->query($sql) or die ($con->error);

        $sql=  "SELECT * FROM tbltransaction";
        $transaction = $con->query($sql) or die ($con->error);

        $sql = "SELECT * FROM tblinventory";
        $pr = $con->query($sql) or die ($con->error);
        $row = $pr->fetch_assoc();
    
        if(isset($_GET['searchitem'])){ 
            $searchkey=$_GET['searchitem'];
            if($searchkey==""){
                echo header("Location:home.php");
            }
           
            $sql = "SELECT * FROM tblinventory WHERE `productName` like '%$searchkey%' OR `type` like '%$searchkey%' OR `category` like '%$searchkey%' OR `subcategory` like '%$searchkey%' OR `itemdesc1` like '%$searchkey%' OR `itemdesc2` like '%$searchkey%' OR `itemdesc2` like '%$searchkey%'";
            $product = $con->query($sql) or die ($con->error);

    
            $sql = "SELECT COUNT(productID) AS 'found' FROM tblinventory WHERE `productName` like '%$searchkey%' OR `type` like '%$searchkey%'  OR `category` like '%$searchkey%' OR `subcategory` like '%$searchkey%' OR `itemdesc1` like '%$searchkey%' OR `itemdesc2` like '%$searchkey%' OR `itemdesc2` like '%$searchkey%'";
            $s = $con->query($sql) or die ($con->error);
            $result=mysqli_fetch_array($s);
            $found=$result['found'];
          
        }
        else{
          $sql = "SELECT * FROM tblinventory";
          $searchkey="";
        }

if(isset($_SESSION['UserLogIn'])&&($_SESSION['Access']=="User")){
    $signup=true;
    $user=$_SESSION['ID'];
    
    $sql="SELECT COUNT(tbltransaction.`transactionID`) AS 'NOTIF' FROM `tbltransaction` INNER JOIN `tbluser` ON `tbltransaction`.`userID`=`tbluser`.`userID` WHERE tbltransaction.`Status`='Added to cart' AND tbltransaction.`userID`='$user'";
    $cart = $con->query($sql) or die ($con->error);
    $notif = mysqli_fetch_assoc($cart);
    $count=$notif['NOTIF'];
    $photo=isset($row['photo']);

   


    if(isset($_GET['select'])){
        $ID=$_GET['select'];

        $sql = "SELECT * FROM tblinventory where productID=$ID";
        $pic = $con->query($sql) or die ($con->error);
        $row = $pic->fetch_assoc();
        $img=$row['photo'];
        $prodname=$row['productName'];
        $price=$row['price'];
        $left=$row['quantity'];
        $desc1=$row['itemdesc1'];
        $desc2=$row['itemdesc2'];
        $desc3=$row['itemdesc3'];


        if(isset($_POST['add'])){
            
            $quantity = $_POST['quan'];
            $prod=$_POST['prod'];
            $price=$_POST['price'];
            $itemleft=$_POST['itemleft'];
            $date=date('F d, Y');
            $id=$_SESSION['ID'];
            $fname=$_SESSION['firstname'];
            $lname=$_SESSION['lastname'];
            date_default_timezone_set('Asia/Manila');
            $time=date("h:i a");
            $photo=$_POST['photo'];
            $total=$price*$quantity;

            if($itemleft=="0"){
                $_SESSION['message'] = "<script>
            $(function() {
                $.notify({
                    message: 'Sorry the item is out of stock' 
                },{
                    animate: {
                        enter: 'animate__animated animate__fadeInDown',
                        exit: 'animate__animated animate__fadeOutLeft'
                    },
                    delay: 2000,
                    placement: {
                        from: 'bottom',
                        align: 'left'
                    },
                    type: 'danger'
                });
            });
            </script>";
                echo header("Refresh:4; url=home.php");
            }
            else if($quantity=="0"){
                $_SESSION['message'] = "<script>
                $(function() {
                    $.notify({
                        message: 'Please select quantity' 
                    },{
                        animate: {
                            enter: 'animate__animated animate__fadeInDown',
                            exit: 'animate__animated animate__fadeOutLeft'
                        },
                        delay: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'left'
                        },
                        type: 'danger'
                    });
                });
                </script>";
                echo header("Refresh:4; url=home.php?select=".$row['productID']);
            }
            else{
            

            $sql= "INSERT INTO `tbltransaction`(`transactionID`, `userID`, `productID`, `customerName`, `productName`, `photo`, `Price`, `Quantity`, `Total`, `Time`, `Date`,  `Status`) VALUES ('', '$id', '$ID','$fname $lname','$prod', '$photo', '$price', '$quantity', '$total', '$time', '$date', 'Added to cart')";
            $con->query($sql) or die ($con->error);

            $_SESSION['message'] = "<script>
            $(function() {
                $.notify({
                    message: 'Successfully added to cart!' 
                },{
                    animate: {
                        enter: 'animate__animated animate__fadeInDown',
                        exit: 'animate__animated animate__fadeOutLeft'
                    },
                    delay: 2000,
                    placement: {
                        from: 'bottom',
                        align: 'left'
                    },
                    type: 'success'
                });
            });
            </script>";
            
            echo header("Refresh:4; url=cart.php");
            }
        }

        if(isset($_POST['cod'])){
            
            $quantity = $_POST['quan'];
            $prod=$_POST['prod'];
            $price=$_POST['price'];
            $itemleft=$_POST['itemleft'];
            $date=date('F d, Y');
            $id=$_SESSION['ID'];
            $fname=$_SESSION['firstname'];
            $lname=$_SESSION['lastname'];
            date_default_timezone_set('Asia/Manila');
            $time=date("h:i a");
            $photo=$_POST['photo'];
            $total=$price*$quantity;
            
            if($itemleft=="0"){
                $_SESSION['message'] = "<script>
                $(function() {
                    $.notify({
                        message: 'Sorry the item is out of stock' 
                    },{
                        animate: {
                            enter: 'animate__animated animate__fadeInDown',
                            exit: 'animate__animated animate__fadeOutLeft'
                        },
                        delay: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'left'
                        },
                        type: 'danger'
                    });
                });
                </script>";
                echo header("Refresh:4; url=home.php");
            }
            else if($quantity=="0"){
                $_SESSION['message'] = "<script>
                $(function() {
                    $.notify({
                        message: 'Please select quantity' 
                    },{
                        animate: {
                            enter: 'animate__animated animate__fadeInDown',
                            exit: 'animate__animated animate__fadeOutLeft'
                        },
                        delay: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'left'
                        },
                        type: 'danger'
                    });
                });
                </script>";
                echo header("Refresh:4; url=home.php?select=".$row['productID']);
            }
            else{
       
                $sql= "UPDATE `tblinventory` SET `quantity`=`quantity`-'$quantity', `itemsold`=`itemsold`+'$quantity' where `productID`=$ID";
                $con->query($sql) or die ($con->error);

                $sql= "INSERT INTO `tbltransaction`(`transactionID`, `userID`, `productID`, `customerName`, `productName`, `photo`, `Price`, `Quantity`, `Total`, `Time`, `Date`,  `Status`, `Payment`) VALUES ('', '$id', '$ID','$fname $lname','$prod', '$photo', '$price', '$quantity', '$total', '$time', '$date', 'Purchased', 'COD')";
                $con->query($sql) or die ($con->error);

                $_SESSION['message'] = "<script>
                                $(function() {
                                    $.notify({
                                        message: 'Security Advisory: Protect Yourself! Avoid engaging in car auto dealings outside of our official platform to ensure your safety and security. Never share sensitive information or make payments to unauthorized individuals.' 
                                    },{
                                        animate: {
                                            enter: 'animate__animated animate__fadeInDown',
                                            exit: 'animate__animated animate__fadeOutLeft'
                                        },
                                        delay: 2000,
                                        placement: {
                                            from: 'bottom',
                                            align: 'left'
                                        },
                                        type: 'warning'
                                    });
                                });
                                </script>";
                echo header("Refresh:4; url=user-account.php");
                }
        }

        if(isset($_POST['online'])){
            $quantity = $_POST['quan'];
            $prod=$_POST['prod'];
            $price=$_POST['price'];
            $itemleft=$_POST['itemleft'];
            $date=date('F d, Y');
            $id=$_SESSION['ID'];
            $fname=$_SESSION['firstname'];
            $lname=$_SESSION['lastname'];
            date_default_timezone_set('Asia/Manila');
            $time=date("h:i a");
            $photo=$_POST['photo'];
            $total=$price*$quantity;
            
            if($itemleft=="0"){
                $_SESSION['message'] = "<script>
                $(function() {
                    $.notify({
                        message: 'Sorry the item is out of stock' 
                    },{
                        animate: {
                            enter: 'animate__animated animate__fadeInDown',
                            exit: 'animate__animated animate__fadeOutLeft'
                        },
                        delay: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'left'
                        },
                        type: 'danger'
                    });
                });
                </script>";
                echo header("Refresh:4; url=home.php");
            }
            else if($quantity=="0"){
                $_SESSION['message'] = "<script>
                $(function() {
                    $.notify({
                        message: 'Please select quantity' 
                    },{
                        animate: {
                            enter: 'animate__animated animate__fadeInDown',
                            exit: 'animate__animated animate__fadeOutLeft'
                        },
                        delay: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'left'
                        },
                        type: 'danger'
                    });
                });
                </script>";
                echo header("Refresh:4; url=home.php?select=".$row['productID']);
            }
            else{
       
                $sql= "UPDATE `tblinventory` SET `quantity`=`quantity`-'$quantity', `itemsold`=`itemsold`+'$quantity' where `productID`=$ID";
                $con->query($sql) or die ($con->error);

                $sql= "INSERT INTO `tbltransaction`(`transactionID`, `userID`, `productID`, `customerName`, `productName`, `photo`, `Price`, `Quantity`, `Total`, `Time`, `Date`,  `Status`, `Payment`) VALUES ('', '$id', '$ID','$fname $lname','$prod', '$photo', '$price', '$quantity', '$total', '$time', '$date', 'Purchased', 'Online Payment')";
                $con->query($sql) or die ($con->error);

                $_SESSION['message'] = "<script>
                $(function() {
                    $.notify({
                        message: 'Thank you for buying' 
                    },{
                        animate: {
                            enter: 'animate__animated animate__fadeInDown',
                            exit: 'animate__animated animate__fadeOutLeft'
                        },
                        delay: 2000,
                        placement: {
                            from: 'bottom',
                            align: 'left'
                        },
                        type: 'success'
                    });
                });
                </script>";
                echo header("Refresh:4; url=https://www.paypal.com/ph/signin");
                }
        }
    
           
    }
   
    
}
else if(isset($_SESSION['UserLogIn'])&&($_SESSION['Access']=="Admin"&&"Supervisor")){
    echo header("Location: accounts.php");
}
else{

    if(isset($_GET['select'])){

        $ID=$_GET['select'];

        $sql = "SELECT * FROM tblinventory where productID=$ID";
        $pic = $con->query($sql) or die ($con->error);
        $row = $pic->fetch_assoc();
        $img=$row['photo'];
        $prodname=$row['productName'];
        $price=$row['price'];
        $left=$row['quantity'];
        $desc1=$row['itemdesc1'];
        $desc2=$row['itemdesc2'];
        $desc3=$row['itemdesc3'];



        if(isset($_POST['add'])||isset($_POST['cod'])||isset($_POST['online'])){
            echo header("Refresh:0; url=LogIn.php");
        }
        

    }
   
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARnival | Autodeals</title>
    <link rel="shortcut icon" type=image/x-icon href=images/icon.png>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/animate.min.css">

    <script src="js/jquery.min.js"></script>
   
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
</head>
<body onload="document.getElementById('ratings').innerHTML = getRndInteger(50,100)" style="color:#fff; background-color:gold;">





    <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-md sticky-top navigation">
        <div class="container-fluid">
            <a href="home.php" class="navbar-brand logo-container">
                <div class="logo"><span>CARnival</span></div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="fas fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <hr class="dropdown-divider">

                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['UserLogIn'])){ ?>
                        <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="cars.php" class="nav-link dropbtn">Cars</a>
                        <!-- <div class="dropdown-content">
                            <a href="hot-deals.php">Hot Deals</a>
                            <a href="new-arrival.php">New Arrival</a>
                            <a href="jdm-classics.php">Classic Cars</a>
                        </div> -->
                    </li>
                
                    <!-- <li class="nav-item dropdown">
                        <a href="merchandise.php" class="nav-link dropbtn">Merchandise</a>
                        <div class="dropdown-content">
                            <a href="best-sellers.php">Best Sellers</a>
                            <a href="car-accessories.php">Accessories</a>
                            <a href="jdm-clothing.php">Jdm Clothing</a>
                        </div>
                    </li> -->
                
                    <li class="nav-item dropdown">
                        <a href="about.php" class="nav-link dropbtn">About</a>
                    </li>
                </ul>
                      
                    <?php } else{ ?>
                        <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="cars.php" class="nav-link dropbtn">Cars</a>
                        <!-- <div class="dropdown-content">
                            <a href="hot-deals.php">Hot Deals</a>
                            <a href="new-arrival.php">New Arrival</a>
                            <a href="jdm-classics.php">Classic Cars</a>
                        </div> -->
                    </li>
                
                    <!-- <li class="nav-item dropdown">
                        <a href="merchandise.php" class="nav-link dropbtn">Merchandise</a>
                        <div class="dropdown-content">
                            <a href="best-sellers.php">Best Sellers</a>
                            <a href="car-accessories.php">Accessories</a>
                            <a href="jdm-clothing.php">Jdm Clothing</a>
                        </div>
                    </li> -->
                
                    <li class="nav-item dropdown">
                        <a href="about.php" class="nav-link dropbtn">About Us</a>
                    </li>
                </ul>
                    <?php }?>
                    <?php if($signup==true){?>
                        <li class="nav-item" id="account">
                            <div class="navbar-collapse" id="navbar-list-4">
                                <ul class="navbar-nav ">
                                    <?php if (isset($_SESSION['UserLogIn'])){ ?>
                                    <li class="dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="<?php echo 'images/avatars/'.$_SESSION['photo']?>" width="30" height="30" class="rounded-circle">
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <a href="user-account.php" class="dropdown-item"><i class="fas fa-shopping-bag"></i>&nbsp&nbspMy Orders</a>  
                                            <a href="LogOut.php?logout=<?php echo $_SESSION['ID']?>" class="dropdown-item" name=logout><span class="fas fa-sign-out-alt"></span>&nbsp&nbspLogout</a>
                                        </div>
            
                                    </li>
                                    <?php } else { ?>
                                    <li class="nav-item">
                                        <a href="LogIn.php" class="nav-link">Login</a>
                                    </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </li>
                    <?php } else{ ?>
                        <li class="nav-item" id="signup">
                            <a href="sign-up.php"  class="nav-link">Sign Up</a>
                        </li>
                    <?php }?>
                    <?php if (isset($_SESSION['UserLogIn'])){ ?>
                        <?php if($count!='0'){?>
                            <style>.cart-button:before {content: "<?php echo $count ?>"}</style>
                        <?php }?>
                        <li class="nav-item" id=name>
                            <a href="user-account.php"  class="nav-link"><?php echo $_SESSION['surname']?></a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="LogIn.php" class="nav-link">Login</a>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>


    <!-- ALERT -->
    <?php if(isset($_SESSION['message'])){?>
       
           <?php 
               echo $_SESSION['message'];
               unset($_SESSION['message']);
           ?>
      
    <?php }?>
    

    <!-- SINGLE ITEM CONTAINER -->
    <?php if(isset($_GET['select'])){?>
        <br><br><br>
        <form method=post >
            <div class="container single-item-container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 item-frame text-center ">
                        <img src="<?php echo "images/products/".$img?>" class="image-fluid">
                    </div>
                    <div class="col-sm-12 col-md-6 item-description-frame">
                        <div class="container">
                            <h1 class="item-description-name"><?php echo $prodname?></h1>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star-half-alt"></span>
                            &emsp;
                            <span class="item-description-ratings"><label id=ratings></label>% Ratings | 
                            <?php if($left!=0){?>
                                <?php echo $left." items left"?></span>
                            <?php } else{?>
                                <span style="color: red"><?php echo "Out of stock"?></span> 
                            <?php }?>
                            <hr>
                           
                            <h1 class="item-description-price"><?php echo "RM ".$price.".00"?></h1>
                            <input type=hidden name=photo value="<?php echo $img ?>">
                            <input type=hidden name=prod value="<?php echo $prodname?>">
                            <input type=hidden name=price value="<?php echo $price?>">
                            <input type=hidden name=itemleft value="<?php echo $left?>">
                          
                            <hr>
                            <p class="lead">
                                &#9679; <?php echo $desc1?> <br>
                                &#9679; <?php echo $desc2?> <br>
                                &#9679; <?php echo $desc3?> <br>
                            </p>
                            
                            <hr>
                            <p class="lead">
                                Estimated Time of Arrival: <br>
                                To NCR = 2-3 Days <br>
                                To Luzon = 3-4 Days <br>
                                To Visayas = 5-6 Days <br>
                                To Mindanao = 6-7 Days <br>
                                
                            </p>
                            <hr>
                            <div class="row text-center">
                                <div class="col-12 quantity-counter">
                                    <p class="lead">Quantity: </p>
                                    &emsp;
                                    <div class="col-md-7 quantity">
                                        <input type="number" class="form-control text-center lead" name=quan min="0" max="<?php echo $left?>" step="1" value="0" readonly>
                                    </div>
                                    </div>
                            </div>
                            <br>
                            

                        <div class="row checkout-express" id=buy>
                                <div class="col-12">
                                <button class="btn btn-primary btn-block add" style="border-color:#bf2e2e; background-color:#bf2e2e;" type=submit name=add>Add To Cart <i class="fas fa-cart-plus align-middle"></i></button>
                                </div>
                                <div class="col-6">
                                    <!-- <button class="btn btn-success btn-block" onclick="enablepayment()" type=submit name=buy>Buy Now</button> -->
                                 </div>
                        </div>
                        <hr>
                        
                            <div class="row" id=payment>
                                <div class="col-12 ">
                                    <p class="lead">Payment Methods</p>
                                </div>
                                <div class="col-6">
                                <button class="btn btn-block btn-primary cod" style="border-color:#bf2e2e; background-color:#bf2e2e;" type=submit id="btn-cod" name=cod>Cash On Delivery <i class="fas fa-truck align-middle"></i></button>
                                </div>

                                <div class="col-6">
                                 <button class="btn btn-block btn-success ol" type=submit id="btn-express" name=online>Express Payment <i class="fab fa-bitcoin align-middle"></i></button>
                                </div>
                            </div>
                        
                           
                                    <!-- CASH ON DELIVERY -->
                                    <!-- <div id="cod">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                        <br>
                                            <p class="lead">Cash On Delivery</p>
                                        </div>
                                        <div class="col-12">
                                            <p class="lead">
                                                Security Advisory: Lifestyle Clothing Co. Sellers are NOT allowed to ask you to order and transact your payments outside the platform.

                                                When using our Cash on Delivery service, payment is given to our official delivery partner upon receipt of item.
                                            </p>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-4 mx-auto">
                                            <button class="btn btn-block btn-success" name=buy type=submit>Confirm Order</button>
                                        </div>

                                    </div>
                                    </div> -->

                         
<!-- EXPRESS PAYMENT -->
<div id="online" style="display: none">
    <div class="row checkout-express">
        <br><br>
      
        <br><br>
        <div class="col-3 bank-logo-container mx-auto">
                <img src="images/payment/paypal logo.png" alt="">
        </div>
        <div class="col-3 bank-logo-container mx-auto">
                <img src="images/payment/master-card logo.png" alt="" style="width: 85px">
        </div>
        <div class="col-3 bank-logo-container mx-auto">
                <img src="images/payment/visa logo.png" alt="">
        </div>
        <div class="col-3 bank-logo-container mx-auto">
                <img src="images/payment/gcash.png" style="width: 85px" alt="">
        </div>
    </div>
    <br><br>
    

    <br><br><br>
</div>
  
          
                    
            </form>
                        </div>
                    </div>
                </div>
            </div>
       

    <?php } else {?>

    

    <!-- CAROUSEL -->
    <div id="slides" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#slides" data-slide-to="0" class="active"> </li>
            <li data-target="#slides" data-slide-to="1"> </li>
            <li data-target="#slides" data-slide-to="2"> </li>
        </ul>
        <div class="carousel-inner">
       
        <!-- VIDEO BANNER -->
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="video-wrapper">
        <video class="img-fluid" autoplay muted loop>
          <source src="images/home/jdm home 1.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
      <div class="carousel-caption">
        <h1 class="display-4">CARnival Collections</h1>
        <p class="lead">Classic vehicle exporters located in Malaysia</p>
        <!-- <a href="home.php#about">
          <button type="button" class="btn btn-primary btn-md" style="background-color: #bf2e2e; border-color: #bf2e2e;">Learn More</button>
        </a> -->
      </div>
    </div>

    <div class="carousel-item">
      <div class="video-wrapper">
        <video class="img-fluid" autoplay muted loop>
          <source src="images/home/jdm home 2.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
      <div class="carousel-caption">
        <h1 class="display-4">Take a look at our finest collection</h1>
        <p class="lead">Explore the Finest Car Imports in Malaysia</p>
        <!-- <a href="home.php#about">
          <button type="button" class="btn btn-primary btn-md" style="background-color: #bf2e2e; border-color: #bf2e2e;">Learn More</button>
        </a> -->
      </div>
    </div>
    <div class="carousel-item">
      <div class="video-wrapper">
        <video class="img-fluid" autoplay muted loop>
          <source src="images/home/jdm home 3.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
      <div class="carousel-caption">
        <h1 class="display-4">Unleash the Power. Unleash the Style.</h1>
        <p class="lead">Experience Unmatched Performance and Style at CARnival</p>
        <!-- <a href="home.php#about">
          <button type="button" class="btn btn-primary btn-md" style="background-color: #bf2e2e; border-color: #bf2e2e;">Learn More</button>
        </a> -->
      </div>
    </div>
  </div>
</div>


            <div class="carousel-item">
                <img src="images/home/carousel-3.jpg" alt="Back Half Store" class="img-fluid">
                <div class="carousel-caption">
                    <h1 class="display-4">You won't regret buying from us</h1>
                    <p class="lead">Our products can last forever</p>
                    <a href="home.php#about"><button type="button" class="btn btn-primary btn-md" style="background-color: #bf2e2e; border-color: #bf2e2e;">Learn More</button></a>
                </div>
            </div>
          <form method=get>
                    <div class="search-boxitem">
                    <input class="search-inputhome" name=searchitem minlength=3 value="<?php $searchkey?>" type="text" placeholder="Search something..">
                     <button class="search-btn"><i class="fas fa-search"></i></button>
                     <?php if (isset($_SESSION['UserLogIn'])){ ?>
                        <a href="cart.php" class="nav-link cart-button">
                                <i class="fas fa-shopping-cart" style="font-size: 25px"></i>
                            </a>
                        <?php } else{?>
                            <a href="LogIn.php" class="nav-link cart-button">
                                <i class="fas fa-shopping-cart" style="font-size: 25px"></i>
                            </a>
                            <?php }?>
                    </div>
            </form>
           
        </div>
        
        <a class="carousel-control-prev" href="#slides" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a> 
        <a class="carousel-control-next" href="#slides" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a> 
    </div>
    <br><br><br>

    <?php if(isset($_GET['searchitem'])){?>




    <!-- SEARCH ITEMS -->
    <div class="container text-center">
    <h5 class="display-4" style="text-align: left;" id=searchkey><?php echo $searchkey?></h5>
    <h5 class="display-6" style="text-align: left;" id=count><?php echo $found.' item(s) found for "'.$searchkey.'"'?></h5>
    <div class="header-container" id=h>
        
    </div>
      
        <div class="row">

            <?php if($found==0){?>
                <div class="container text-center">
                    <br><br>
                <div class="col-12">
                    <h1 class="display-3">Search No Result</h1>
                    <h5 class="display-5">We're sorry. We cannot find any matches for your search term.</h1>
                </div>
                        <div class="row">
                            <div class="col-12">
                            <img src="images/background/nosearch.png" style="width: 100%">
                            </div>
                        </div> 
                </div>
            
            <?php }else{?>

            
            <?php while($rows = $product->fetch_array()){?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <br><br>
                        <div class="item-container">
                            <div class="item-image-container">
                                <a href="home.php?select=<?php echo $rows['productID']?>"><button type=submit name=select id=select>< src="<?php echo "images/products/".$rows['photo']?>" alt=""></button></a>
                                     <?php if($rows['category']=="Men"){?>
                                        <div class="shape men"><?php echo "RM".$rows['price']?></div>
                                    <?php } else if($rows['category']=="Merchandise"){?>
                                        <div class="shape about"><?php echo "RM".$rows['price']?></div>
                                    <?php }?>
                        
                            </div>
                            
                             <div class="item-description-container" style="color:white;">
                                    <h5><?php echo $rows['productName']?></h5>
                                    <p><?php echo $rows['itemdesc1']?></p>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-alt"></span>
                                    <label class="quantity-label"><?php echo $rows['quantity']?> Left</label>
                            </div>
                         </div>
                    </div>
            <?php }?>
            <?php }?>
        </div>
    </div>
    <br><br><br>
   
<?php } else {?>

    <!-- OUR CATEGORIES -->
    <div class="container" style="color:white;">
        <div class="header-container">
            <span class="header">Car Categories</span>
        </div>
        <br><br><br>
        <div class="row text-center categories">
            <div class="col-xs-12 col-sm-6 col-lg-4 overlay">
                <a href="cars.php?subcategory=Ford">
                    <img src="images/products/ford everest.png" alt="Ford Cars">
                </a>
                <h4>Ford Cars</h4>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 overlay">
                <a href="cars.php?subcategory=Honda"><img src="images/products/honda city.png" alt="Honda Cars"></a>
                <h4>Honda Cars</h4>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 overlay">
                <a href="cars.php?subcategory=Lancer"><img src="images/products/lancer evo 3.png" alt="Lancer Cars"></a>
                <h4>Lancer Cars</h4>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 overlay">
                <a href="cars.php?subcategory=Mazda"><img src="images/products/mazda rx3.png" alt="Mazda Cars"></a>
                <h4>Mazda Cars</h4>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 overlay">
                <a href="cars.php?subcategory=Nissan"><img src="images/products/nissan 180sx.png" alt="Nissan Cars"></a>
                <h4>Nissan Cars</h4>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 overlay">
                <a href="cars.php?subcategory=Subaru"><img src="images/products/subaru impreza white.png" alt="Subaru Cars"></a>
                <h4>Subaru Cars</h4>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 overlay">
                <a href="cars.php?subcategory=Toyota"><img src="images/products/toyota raize.png" alt="Toyota Cars"></a>
                <h4>Toyota Cars</h4>
            </div>

            </div>
        </div>
    </div>
    <br><br><br>




    <!-- FEATURED PRODUCTS -->
    <!-- <div class="container" style="color:white;">
        <div class="header-container">
            <span class="header">Featured Products</span>
        </div>
        <br><br><br>
        <div class="row text-center">
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    <?php while($row = $items1->fetch_array()){ ?>
                        <div class="item-container">
                            <a href="home.php?select=<?php echo $row['productID']?>">
                                <div class="item-image-container">
                                    <img src="<?php echo "images/products/".$row['photo']?>" alt="">
                                    <?php if($row['category']=="Men"){?>
                                        <div class="shape men"><?php echo "RM".$row['price']?></div>
                                    <?php } else if($row['category']=="Merchandise"){?>
                                        <div class="shape merchandise"><?php echo "RM".$row['price']?></div>
                                    <?php }?>
                                </div>
                                <div class="item-description-container" style="color:white;">
                                    <h5><?php echo $row['productName']?></h5>
                                    <p><?php echo $row['itemdesc1']?></p>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-alt"></span>
                                    <span class="far fa-star"></span>
                                    
                                    <div class="container-label">
                                        <label>&nbsp;(<?php echo $row['quantity']; ?> Left)</label>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>              
            </div>        
        </div>
    </div> -->
    <br><br><br>
    




    <!-- BEST SELLERS -->
    <!-- <div class="container" style="color:white;">
        <div class="header-container">
            <span class="header">Best Sellers</span>
        </div>
        <br><br><br>
        <div class="row text-center">
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    <?php while($row = $items2->fetch_array()){ ?>
                        <div class="item-container">
                            <a href="home.php?select=<?php echo $row['productID']?>">
                                <div class="item-image-container">
                                    <img src="<?php echo "images/products/".$row['photo']?>" alt="">
                                    <?php if($row['category']=="Men"){?>
                                        <div class="shape men"><?php echo "RM".$row['price']?></div>
                                    <?php } else if($row['category']=="Merchandise"){?>
                                        <div class="shape merchandise"><?php echo "RM".$row['price']?></div>
                                    <?php }?>
                                </div>
                                <div class="item-description-container" style="color:white;">
                                    <h5><?php echo $row['productName']?></h5>
                                    <p><?php echo $row['itemdesc2']?></p>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-alt"></span>
                                    <div class="container-label">
                                    <label>&nbsp;(<?php echo $row['quantity']?> Left)</label> 
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>              
            </div>        
        </div>
    </div> -->
    <br><br><br>
    





    <!-- DAILY DISCOVER -->
    <!-- <div class="container" style="color:white;">
        <div class="header-container">
            <span class="header">Daily Discover</span>
        </div>
        <br><br><br>
        <div class="row text-center">
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    <?php while($row = $items3->fetch_array()){ ?>
                        <div class="item-container">
                            <a href="home.php?select=<?php echo $row['productID']?>">
                                <div class="item-image-container">
                                    <img src="<?php echo "images/products/".$row['photo']?>" alt="">
                                    <?php if($row['category']=="Men"){?>
                                        <div class="shape men"><?php echo "RM".$row['price']?></div>
                                    <?php } else if($row['category']=="Merchandise"){?>
                                        <div class="shape merchandise"><?php echo "RM".$row['price']?></div>
                                    <?php } else if($row['category']=="Kids"){?>
                                        <div class="shape kids"><?php echo "RM".$row['price']?></div>
                                    <?php }?>
                                </div>
                                <div class="item-description-container" style="color:white;">
                                    <h5><?php echo $row['productName']?></h5>
                                    <p><?php echo $row['itemdesc3']?></p>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star-half-alt"></span>
                                    <span class="far fa-star"></span>
                                    <span class="far fa-star"></span>
                                    
                                    <div class="container-label">
                                    <label>&nbsp;(<?php echo $row['quantity']?> Left)</label>
                                    </div> 
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>              
            </div>        
        </div>
    </div> -->
    <br><br><br>





    <!-- SHOP DESCRIPTION -->
    <div class="text-center fixed-banner">
        <br><br><br>
        <h4 class="display-4" id=about>About Our Shop</h4>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="lead">
                            Welcome to our Carnival Car shop, where the love for automotive artistry takes the driver's seat!<br>
                        We are dedicated to offering a handpicked collection of Malaysian vehicles that seamlessly merge performance, style, and heritage.<br>
                        From cherished classics to cutting-edge local gems, our aim is to provide enthusiasts with an electrifying experience ignited by the mastery and precision of Malaysian car craftsmanship.
                    </p>
                </div>
            </div>
        </div>
        <br><br><br>
    </div>
    <br><br><br>
    <?php }?>
    <?php }?>

    <!-- FOOTER -->
    <footer>
        <div class="container-fluid footer">
            <div class="row" style="justify-content: space-around;">
                <div class="col-sm-6 col-lg-3" align="left">
                    <h4 class="display-4 name">CARnival Auto Deals</h4>
                    <p class="lead">
                        Welcome to CARnival Auto Deals, your premier destination for CARnival enthusiasts. 
                    Our passion is to offer a carefully curated selection of top-tier CARnival vehicles that will ignite your senses. 
                    From iconic classics that evoke nostalgia to cutting-edge performance machines that deliver heart-pounding excitement, 
                    we invite you to experience the essence of CARnival culture with us. Join the ride where horsepower meets passion, 
                    creating a symphony of excitement and entertainment in perfect harmony.
                    </p>
                </div>

                <div class="col-sm-6 col-lg-3" align="center">
                    <p class="lead">Follow Us On:</p>
                    <div class="col-12 social">
                        <a href="#"><span class="fab fa-facebook"></span> Facebook</a><br>
                        <a href="#"><span class="fab fa-instagram"></span> Instagram</a><br>
                        <a href="#"><span class="fab fa-twitter"></span> Twitter</a><br>
                        <a href="#"><span class="fab fa-youtube"></span> YouTube</a><br>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" align="center">
                    <p class="lead">Email Us:</p>
                    <div class="textbox">
                        <input type="text" placeholder="Write Your Thoughts">
                    </div>
                    <div class="button">
                        <a href="mailto:" class="btn btn-primary" style="background-color: #bf2e2e; border-color: #bf2e2e;">Send</a>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <div class="row text-center">
                <div class="col-12">
                   <p>Copyright © 2023 | All Rights Reserved</p>
                   <p>By Group Vroom</p>
                </div>
            </div>
        </div>
    </footer>
</body>
<script>
     jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });

    function getRndInteger(min, max) {
  return Math.floor(Math.random() * (max - min + 1) ) + min;
}




</script>
<script src="js/script.js"></script>
</html>