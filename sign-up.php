<?php

if(!isset($_SESSION)){
    session_start();
}
    include_once("connections/connect.php");
    $con=connect();

    if(isset($_POST['register'])){
        
        
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        // $house = $_POST['house'];
        // $street = $_POST['street'];
        // $brgy = $_POST['brgy'];
        // $city = $_POST['city'];
        // $province = $_POST['province'];
        // $phone = $_POST['contact'];
        $ImageName = $_FILES["profileImage"]['name'];
        $target_file = "images/avatars/".$ImageName;

        //.JPG .PNG .GIF 
        $allowed_ext=array('gif', 'png', 'jpg', 'jpeg', 'jfif');
        $filename=$_FILES["profileImage"]['name'];
        $file_ext=pathinfo($filename, PATHINFO_EXTENSION);
      

        $sql= "SELECT * FROM tbluser where email = '$email'";
        $users = $con->query($sql) or die ($con->error);
        $row = mysqli_fetch_assoc($users);
        
        
        if($fname==""||$lname==""||$surname==""||$email==""||$password==""){
            
            $_SESSION['message'] = "<script>
            $(function() {
                $.notify({
                    message: 'Please Fill Up The Form Completely' 
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
            
        }
        
        else if($email==isset($row['email'])){
            $_SESSION['message'] = "<script>
            $(function() {
                $.notify({
                    message: 'Email Address Already Exist And Taken' 
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
        }
        else{
          
            if($_FILES['profileImage']['name']!=''){
               
                if($_FILES['profileImage']['size'] > 200000) {
                    $_SESSION['message'] = "<script>
                        $(function() {
                            $.notify({
                                message: 'Image Size Should Not Be Greater Than 200KB' 
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
                    }
               
                
                if (empty($error)) {
                    if(!in_array($file_ext, $allowed_ext)){
                        $_SESSION['message'] = "<script>
                        $(function() {
                            $.notify({
                                message: 'Uploaded File Is Not A Valid Image File Type. Only JPG, PNG And GIF Files Are Allowed' 
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
                    }
                   else if(file_exists($target_file)) {
                        $_SESSION['message'] = "<script>
                            $(function() {
                                $.notify({
                                    message: 'File Already Exists' 
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
                    }
                    else if(move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
                        $sql= "INSERT INTO `tbluser`(`userID`, `photo`, `Firstname`, `Lastname`, `Surname`, `email`, `Password`, `status`, `Access`) VALUES ('', '$ImageName', '$fname','$lname', '$surname', '$email','$password', 'offline.png', 'User')";
                        $con->query($sql) or die ($con->error);

                        $_SESSION['message'] = "<script>
                        $(function() {
                            $.notify({
                                message: 'You Have Been Registered Successfully!' 
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
                        echo header("Refresh:1; url=LogIn.php");
                    }
                    
                }
            }
            else{
                $sql= "INSERT INTO `tbluser`(`userID`, `photo`, `Firstname`, `Lastname`, `Surname`, `email`, `Password`, `status`, `Access`) VALUES ('', 'default.png', '$fname','$lname', '$surname', '$email','$password','offline.png', 'User')";
                $con->query($sql) or die ($con->error);

                $_SESSION['message'] = "<script>
                        $(function() {
                            $.notify({
                                message: 'You Have Been Registered Successfully!' 
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
                echo header("Refresh:1; url=LogIn.php");
            }

        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
<body>


    <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-md sticky-top navigation">
        <div class="container-fluid">
            <a href="home.php" class="navbar-brand logo-container"><div class="logo"><span>CARnival</span></div></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="fas fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                
                <ul class="navbar-nav ml-auto">
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
                                <a href="car-accessories.php">Car Accessories</a>
                                <a href="jdm-clothing.php">Jdm Clothing</a>
                            </div>
                        </li> -->
                
                        <li class="nav-item dropdown">
                            <a href="about.php" class="nav-link dropbtn">About</a>
                        </li>
                    </ul>
                    <li class="nav-item">
                        <a href="sign-up.php" class="nav-link">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a href="LogIn.php" class="nav-link">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    


    <!-- SIGN-UP -->
    


    <!-- ALERT -->
    <div class="signup-background">
    
    <?php if(isset($_SESSION['message'])){?>
        <?php 
               echo $_SESSION['message'];
               unset($_SESSION['message']);
           ?>
    <?php }?>

    <br><br><br>
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h4 class="display-Sign">Sign Up</h4>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-12">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-row">
                    <div class="form-group img-profile text-center col-12" style="position: relative;" >
                        <span class="img-div">
                        <div class="text-center img-placeholder"  onClick="triggerClick()">
                            <h4>Upload Image</h4>
                        </div>
                        <img src="images/avatars/default.png" onClick="triggerClick()" id="profileDisplay">
                        </span>
                        <br>
                        <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
                        <label>Profile Image</label>
                    </div>
                    <br><br>


                       
                    <div class="form-group col-sm-12 col-md-4">
                            <label for="inputFirstname">Firstname: </label>
                            <input type="text" name="firstname" id="signupinputFirstname" class="form-control" placeholder="Firstname">
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="inputLastname">Lastname: </label>
                            <input type="text" name="lastname" id="signupinputLastname" class="form-control" placeholder="Lastname">
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="inputSurname">Surname: </label>
                            <input type="text" name="surname" id="signupinputSurname" class="form-control" placeholder="Surname">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="inputEmail">Email Address: </label>
                            <input type="email" name="email" id="signupinputEmail" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="inputPassword">Password: </label>
                            <input type="password" name="password" id="signupinputPassword" class="form-control" placeholder="Password">
                        </div>
                        <!-- <div class="form-group col-sm-12 col-md-4">
                            <label for="inputContactNumber">Contact Number: </label>
                            <input type="text" name="contact" id="signupinputContactNumber" minlength="10" maxlength="10" onkeypress="return onlyNumberKey(event)" class="form-control" placeholder="+63">
                        </div> -->
                    </div>
                    <!-- <div class="form-row">
                        <div class="form-group col-12">
                            <label for="inputAddress">Address: </label>
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <input type="text" name="house" id="signupinputHouseNumber" onkeypress="return onlyNumberKey(event)" class="form-control" placeholder="House Number">
                        </div>
                        <div class="form-grop col-sm-12 col-md-4">
                            <input type="text" name="street" id="signupinputStreet" class="form-control" placeholder="Street">
                        </div>
                        <div class="form-grop col-sm-12 col-md-4">
                            <input type="text" name="brgy" id="signupinputBarangay" class="form-control" placeholder="Barangay">
                        </div>
                        <div class="form-grop col-sm-12 col-md-6">
                            <input type="text" name="city" id="signupinputCity" class="form-control" placeholder="City">
                        </div>
                        <div class="form-grop col-sm-12 col-md-6">
                            <input type="text" name="province" id="signupinputProvince" class="form-control" placeholder="Province">
                        </div>
                    </div> -->
                    <br><br>
                    <div class="form-row">
                        <div class="col-6 mx-auto button-container">
                        <button type="submit" name="register" class="btn btn-primary btn-md form-control" style="border-color:#bf2e2e; background-color:#bf2e2e;">Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
    <br><br>
    </div>
    

    

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
    function onlyNumberKey(evt) { 
              
              // Only ASCII charactar in that range allowed 
              var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
              if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
              return false; 
              return true;
      }
      
      function triggerClick(e) {
            document.querySelector('#profileImage').click();
            }
            function displayImage(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e){
                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
                }
            }
            
      </script>
</html>