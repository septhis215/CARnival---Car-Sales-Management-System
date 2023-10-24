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
         
        $sql = "SELECT * FROM tbluser";
        $users = $con->query($sql) or die ($con->error);
        $row = $users->fetch_assoc();

        $sql = "SELECT * FROM tblinventory where `category`='Cars' order by productName ASC ";
        $data1 = $con->query($sql) or die ($con->error);
        $sql = "SELECT * FROM tblinventory where `type`='New' AND `category`='Cars' order by rand() LIMIT 9";
        $data2 = $con->query($sql) or die ($con->error);
        $sql = "SELECT * FROM tblinventory where `type`='Classic' AND `category`='Cars' order by rand() LIMIT 9";
        $data3 = $con->query($sql) or die ($con->error);

        $subcategoryFilter = isset($_GET['subcategory']) ? $_GET['subcategory'] : 'all';

        if ($subcategoryFilter === 'all') {
            $sql = "SELECT * FROM tblinventory WHERE `category`='Cars'";
            } else {
            $subcategoryFilter = $con->real_escape_string($subcategoryFilter);
            $sql = "SELECT * FROM tblinventory WHERE `category`='Cars' AND `subcategory`='$subcategoryFilter'";
            }
            $data4 = $con->query($sql) or die($con->error);

        $sql=  "SELECT * FROM tbltransaction";

        $transaction = $con->query($sql) or die ($con->error);
        
        

if(isset($_SESSION['UserLogIn'])&&($_SESSION['Access']=="User")){
    $signup=true;
    $user=$_SESSION['ID'];
    
    $sql="SELECT COUNT(tbltransaction.`transactionID`) AS 'NOTIF' FROM `tbltransaction` INNER JOIN `tbluser` ON `tbltransaction`.`userID`=`tbluser`.`userID` WHERE tbltransaction.`Status`='Added to cart' AND tbltransaction.`userID`='$user'";
    $cart = $con->query($sql) or die ($con->error);
    $notif = mysqli_fetch_assoc($cart);
    $count=$notif['NOTIF'];

    $photo=$row['photo'];
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
            $time=date("h:i a");
            $photo=$_POST['photo'];
            $total=$price*$quantity;

            if($itemleft=="0"){
                $_SESSION['message']="We're sorry the item is out of stock";
                $_SESSION['msg_type']="danger";
                echo header("Refresh:1; url=home.php");
            }
            else if($quantity=="0"){
                $_SESSION['message']="Please select quantity";
                $_SESSION['msg_type']="danger";
                echo header("Refresh:1; url=home.php?select=".$row['productID']);
            }
            else{
            

            $sql= "INSERT INTO `tbltransaction`(`transactionID`, `userID`, `productID`, `customerName`, `productName`, `photo`, `Price`, `Quantity`, `Total`, `Time`, `Date`,  `Status`) VALUES ('', '$id', '$ID','$fname $lname','$prod', '$photo', '$price', '$quantity', '$total', '$time', '$date', 'Added to cart')";
            $con->query($sql) or die ($con->error);
            
            echo header("Refresh:1; url=cart.php");
            }
        }
        // $sql= "UPDATE tblinventory SET quantity=quantity-'$quantity' where productID=$ID";
        //     $con->query($sql) or die ($con->error);
           
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

        if(isset($_POST['add'])||isset($_POST['buy'])){
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
    <title>CARnival | Cars</title>
    <link rel="shortcut icon" type=image/x-icon href=images/icon.png>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <script src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.js"></script>
</head>
<body style="background-color:gold;">


    <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-md sticky-top navigation">
        <div class="container-fluid">
            <a href="home.php" class="navbar-brand logo-container"><div class="logo"><span>CARnival</span></div></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="fas fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
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
                                <a href="about.php" class="nav-link dropbtn">About</a>
                            </li>
                        </ul>
                    <?php }?>

                    <?php if($signup==true){?>
                    <li class="nav-item" id="account">
                    <div class="navbar-collapse" id="navbar-list-4">
                            <ul class="navbar-nav">
                            <?php if (isset($_SESSION['UserLogIn'])){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo 'images/avatars/'.$_SESSION['photo']?>" width="30" height="30" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a href="user-account.php" class="dropdown-item"><i class="fas fa-shopping-bag"></i> &nbspMy Orders</a>
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

                    <li class="nav-item">
                     <a href="user-account.php"  class="nav-link"><?php echo $_SESSION['surname'] ?></a>
                    </li>
                    <?php } else { ?>
                        <li class="nav-item">
                        <a href="LogIn.php" class="nav-link">Login</a>
                    </li>
                    <?php }?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br>


    <!-- BANNER CARS -->
    <div class="inline">
            <div class="col-12 men banner-image-container" style="color:white;">
                <h4 class="display-4">Car</h4>
            <form action=home.php method=get>
                <div class="search-boxmen">
                    <input class="search-input" name=searchitem  value="" type="text" placeholder="Search something..">
                    <button class="search-btn"><i class="fas fa-search"></i></a></button>
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
            
        </div>
        
    </div>
    <br><br><br>





    <!-- PRODUCT CAROUSEL -->

    <div class="container text-center">
        <div class="row">
            <?php while($row = $data4->fetch_array()){?>
            <div class="col-xs-12 col-sm-6 col-lg-4 overlay">
                <div class="item-wc">
                <a href="home.php?select=<?php echo $row['productID']?>">
                <button type=submit name=select id=select>
                    <img src="<?php echo "images/products/".$row['photo']?>" alt="">
                </button>
                </a>
                    <div class="item-description-container">
                                <h5><?php echo $row['productName']?></h5>
                                <p><?php echo "RM".$row['price'].".00"?></p>
                        </div>
                </div>
            </div>
            <?php }?>
            
        </div>
    </div>
    
    <!-- <div class="inline">
        <div class="header-container" style="color:white;">
            <span class="header">Hot Deals</span>
        </div>
        <br><br><br>
       
        <div class="row text-center" style="color:#fff;">
        
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    
                <?php while($row = $data1->fetch_array()){ ?>
                    <div class="item">
                        <div class="item-container">
                        <div class="item-image-container">
                        <a href="home.php?select=<?php echo $row['productID']?>"><button type=submit name=select id=select><img src="<?php echo "images/products/".$row['photo']?>" alt=""></button></a>
                            <?php if($row['category']=="Cars"){?>
                                    <div class="shape cars"><?php echo "RM".$row['price']?></div>
                                <?php } else if($row['category']=="Merch"){?>
                                    <div class="shape merch"><?php echo "RM".$row['price']?></div>
                                <?php }?>
                    
                        </div>
                        
                             <div class="item-description-container">
                                <h5><?php echo $row['productName']?></h5>
                                <p><?php echo $row['itemdesc1']?></p>
                        </div>
                        </div>
                    </div>
                    <?php } ?>
                    </div> -->
                    <!-- <div class="row text-center">
                        <div class="col-12">
                        <a href="hot-deals.php"><button class="btn btn-primary btn-md" style="background-color: #bf2e2e; border-color: #bf2e2e;">See More</button></a>
                        </div>
                     </div> -->
                </div>
                
            </div>
        </div>
    
    <br><br><br>





    

    <!-- PRODUCT CAROUSEL -->
    <!-- <div class="inline">
        <div class="header-container" style="color:white;">
            <span class="header">New Arrival</span>
        </div>
        <br><br><br>
       
        <div class="row text-center" style="color:white;">
        
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    
                <?php while($row = $data2->fetch_array()){ ?>
                    <div class="item">
                        <div class="item-container">
                        <div class="item-image-container">
                        <a href="home.php?select=<?php echo $row['productID']?>"><button type=submit name=select id=select><img src="<?php echo "images/products/".$row['photo']?>" alt=""></button></a>
                            <?php if($row['category']=="Cars"){?>
                                    <div class="shape cars"><?php echo "RM".$row['price']?></div>
                                <?php } else if($row['category']=="Merch"){?>
                                    <div class="shape merch"><?php echo "RM".$row['price']?></div>
                                <?php }?>
                    
                        </div>
                        
                             <div class="item-description-container">
                                <h5><?php echo $row['productName']?></h5>
                                <p><?php echo $row['itemdesc1']?></p>
                        </div>
                        </div>
                       
                           
                    </div>
                    <?php } ?>
                    </div>
                    <div class="row text-center">
                        <div class="col-12">
                        <a href="new-arrival.php"><button class="btn btn-primary btn-md" style="background-color: #bf2e2e; border-color: #bf2e2e;">See More</button></a>
                        </div>
                     </div>
                </div>
                
            </div>
                </div>
    
    <br><br><br> -->







    <!-- PRODUCT CAROUSEL -->
    <!-- <div class="inline">
        <div class="header-container" style="color:white;">
            <span class="header">Jdm Classics</span>
        </div>
        <br><br><br>
       
        <div class="row text-center" style="color:white;">
        
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    
                <?php while($row = $data3->fetch_array()){ ?>
                    <div class="item">
                        <div class="item-container">
                        <div class="item-image-container">
                        <a href="home.php?select=<?php echo $row['productID']?>"><button type=submit name=select id=select><img src="<?php echo "images/products/".$row['photo']?>" alt=""></button></a>
                            <?php if($row['category']=="Cars"){?>
                                    <div class="shape cars"><?php echo "RM".$row['price']?></div>
                                <?php } else if($row['category']=="Merch"){?>
                                    <div class="shape merch"><?php echo "RM".$row['price']?></div>
                                <?php }?>
                    
                        </div>
                        
                             <div class="item-description-container">
                                <h5><?php echo $row['productName']?></h5>
                                <p><?php echo $row['itemdesc1']?></p>
                            </div>
                        </div>
                       
                           
                    </div>
                    <?php } ?>
                    </div>
                    <div class="row text-center">
                        <div class="col-12">
                        <a href="jdm-classics.php"><button class="btn btn-primary btn-md" style="background-color: #bf2e2e; border-color: #bf2e2e;">See More</button></a>
                        </div>
                     </div>
                </div>
                
            </div>
                </div>
    
    <br><br><br> -->








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
</html>