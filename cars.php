<?php

if(!isset($_SESSION)){
  session_start();
  
}

include_once("connections/connect.php");
$con=connect();

        $id=0;
        $fname = "";
        $lname = "";
        $username = "";
        $password = "";
        $email = "";
        $phone = "";
        $address = "";
        $signup=false;
         
        $sql = "SELECT * FROM users";
        $users = $con->query($sql) or die ($con->error);
        $row = $users->fetch_assoc();

        $sql = "SELECT * FROM `inventory` INNER JOIN `carmodel` ON `inventory`.`modelID` = `carmodel`.`modelID` 
        INNER JOIN manufacturers ON `carmodel`.`manufacturerID` = `manufacturers`.`manufacturerID`
        INNER JOIN cartype ON `carmodel`.`carTypeID` = `cartype`.`carTypeID`  
        order by `inventory`.`modelID` ASC ";
        $data1 = $con->query($sql) or die ($con->error);
        $sql = "SELECT * FROM `inventory` INNER JOIN `carmodel` ON `inventory`.`modelID` = `carmodel`.`modelID` 
        INNER JOIN manufacturers ON `carmodel`.`manufacturerID` = `manufacturers`.`manufacturerID`
        INNER JOIN cartype ON `carmodel`.`carTypeID` = `cartype`.`carTypeID`  order by rand() LIMIT 9";
        $data2 = $con->query($sql) or die ($con->error);
        $sql = "SELECT * FROM `inventory` INNER JOIN `carmodel` ON `inventory`.`modelID` = `carmodel`.`modelID` 
        INNER JOIN manufacturers ON `carmodel`.`manufacturerID` = `manufacturers`.`manufacturerID`
        INNER JOIN cartype ON `carmodel`.`carTypeID` = `cartype`.`carTypeID`  order by rand() LIMIT 9";
        $data3 = $con->query($sql) or die ($con->error);

        // $subcategoryFilter = isset($_GET['manufacturerName']) ? $_GET['manufacturerName'] : 'all';
        $subcategoryFilter1 = isset($_GET['manufacturerName']) ? $con->real_escape_string($_GET['manufacturerName']) : 'all';
        $subcategoryFilter2 = isset($_GET['carTypeName']) ? $con->real_escape_string($_GET['carTypeName']) : 'all';

        if ($subcategoryFilter1 === 'all' && $subcategoryFilter2 === 'all') { 
            $sql = "SELECT * FROM `inventory` INNER JOIN `carmodel` ON `inventory`.`modelID` = `carmodel`.`modelID` 
                    INNER JOIN manufacturers ON `carmodel`.`manufacturerID` = `manufacturers`.`manufacturerID`
                    INNER JOIN cartype ON `carmodel`.`carTypeID` = `cartype`.`carTypeID`
                    WHERE `inventory`.`status`='0'";
        } else {
            $sql = "SELECT * FROM `inventory` INNER JOIN `carmodel` ON `inventory`.`modelID` = `carmodel`.`modelID` 
                    INNER JOIN manufacturers ON `carmodel`.`manufacturerID` = `manufacturers`.`manufacturerID`
                    INNER JOIN cartype ON `carmodel`.`carTypeID` = `cartype`.`carTypeID` 
                    WHERE (`cartype`.`carTypeName`='$subcategoryFilter2' OR `manufacturers`.`manufacturerName`='$subcategoryFilter1') AND `inventory`.`status`='0'";
        }
        
        $data4 = $con->query($sql) or die($con->error);

        $sql=  "SELECT * FROM transaction_list";
        $transaction = $con->query($sql) or die ($con->error);
        

if(isset($_SESSION['UserLogIn'])&&($_SESSION['Access']=="User")){
    $signup=true;
    $user=$_SESSION['ID'];
    
    $sql="SELECT COUNT(transaction_list.`id`) AS 'NOTIF' FROM `transaction_list` INNER JOIN `customer` ON `transaction_list`.`custID`=`customer`.`custID` WHERE transaction_list.`Status`='Added to cart' AND transaction_list.`custID`='$user'";
    $cart = $con->query($sql) or die ($con->error);
    $notif = mysqli_fetch_assoc($cart);
    $count=$notif['NOTIF'];

    $photo=$row['photo'];
    if(isset($_GET['select'])){

        $ID=$_GET['select'];

        $sql = "SELECT * FROM `inventory` INNER JOIN `carmodel` ON `inventory`.`modelID` = `carmodel`.`modelID` 
        INNER JOIN manufacturers ON `carmodel`.`manufacturerID` = `manufacturers`.`manufacturerID`
        INNER JOIN cartype ON `carmodel`.`carTypeID` = `cartype`.`carTypeID` where `inventory`.`status`='0' AND inventoryID=$ID";
        $pic = $con->query($sql) or die ($con->error);
        $row = $pic->fetch_assoc();
        $vr_number=$row['vr_number'];
        $variant=$row['variant'];
        $colors=$row['colors'];
        $engine=$row['engine_number'];
        $chasis=$row['chasis_number'];
        $prodname=$row['model'];
        $price=$row['price'];
        $img=$row['imagePath'];

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

        $sql = "SELECT * FROM `inventory` INNER JOIN `carmodel` ON `inventory`.`modelID` = `carmodel`.`modelID` 
        INNER JOIN manufacturers ON `carmodel`.`manufacturerID` = `manufacturers`.`manufacturerID`
        INNER JOIN cartype ON `carmodel`.`carTypeID` = `cartype`.`carTypeID` where `inventory`.`status`='0' AND inventoryID=$ID";
        $pic = $con->query($sql) or die ($con->error);
        $row = $pic->fetch_assoc();
        
        $prodname=$row['vr_number'];
        $variant=$row['variant'];
        $colors=$row['colors'];
        $engine=$row['engine_number'];
        $chasis=$row['chasis_number'];
        $price=$row['price'];
        $img=$row['imagePath'];

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
<body style="background-color:black;">


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
                        <!-- <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="cars.php" class="nav-link dropbtn">Cars</a>
                        <div class="dropdown-content">
                            <a href="hot-deals.php">Hot Deals</a>
                            <a href="new-arrival.php">New Arrival</a>
                            <a href="jdm-classics.php">Classic Cars</a>
                        </div>
                    </li>
                
                    <li class="nav-item dropdown">
                        <a href="merchandise.php" class="nav-link dropbtn">Merchandise</a>
                        <div class="dropdown-content">
                            <a href="best-sellers.php">Best Sellers</a>
                            <a href="car-accessories.php">Accessories</a>
                            <a href="jdm-clothing.php">Jdm Clothing</a>
                        </div>
                    </li>
                
                    <li class="nav-item dropdown">
                        <a href="about.php" class="nav-link dropbtn">About</a>
                    </li>
                </ul> -->
                      
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
                    <!-- <?php if($signup==true){?>
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
                    <?php }?> -->
                    <?php if (isset($_SESSION['UserLogIn'])){ ?>
                        <!-- <?php if($count!='0'){?>
                            <style>.cart-button:before {content: "<?php echo $count ?>"}</style>
                        <?php }?>
                        <li class="nav-item" id=name>
                            <a href="user-account.php"  class="nav-link"><?php echo $_SESSION['surname']?></a>
                        </li> -->
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="csms/admin/login.php" class="nav-link">Login</a>
                        </li>
                    <?php }?>
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
                    <!-- <?php if (isset($_SESSION['UserLogIn'])){ ?>
                        <a href="cart.php" class="nav-link cart-button">
                                <i class="fas fa-shopping-cart" style="font-size: 25px"></i>
                            </a>
                        <?php } else{?>
                            <a href="LogIn.php" class="nav-link cart-button">
                                <i class="fas fa-shopping-cart" style="font-size: 25px"></i>
                            </a>
                            <?php }?> -->
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
                <a href="home.php?select=<?php echo $row['inventoryID']?>">
                <button type=submit name=select id=select>
                    <img src="<?php echo $row['imagePath']?>" alt="">
                </button>
                </a>
                    <div class="item-description-container">
                                <h5><?php echo $row['manufacturerName']." ".$row['model']?></h5>
                                <p><?php echo "RM" . number_format($row['price'], 0, '', ',')?></p>
                        </div>
                </div>
            </div>
            <?php }?>
            
        </div>
    </div>
    
    <br><br><br>



    <!-- FOOTER -->
    <footer>
        <div class="container-fluid footer">
            <div class="row" style="justify-content: space-around;">
                <div class="col-sm-6 col-lg-3" align="left">
                    <!-- <h4 class="display-4 name">CARnival Auto Deals</h4>
                    <p class="lead">
                        Welcome to CARnival Auto Deals, your premier destination for CARnival enthusiasts. 
                    Our passion is to offer a carefully curated selection of top-tier CARnival vehicles that will ignite your senses. 
                    From iconic classics that evoke nostalgia to cutting-edge performance machines that deliver heart-pounding excitement, 
                    we invite you to experience the essence of CARnival culture with us. Join the ride where horsepower meets passion, 
                    creating a symphony of excitement and entertainment in perfect harmony.
                    </p> -->
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