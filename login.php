<?php
    session_start();
    if (!isset($_SESSION["basket"]))
    {
        $basket = array();
        $_SESSION["basket"] = $basket;
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link href="css/home.css" rel="stylesheet" type="text/css" />
        <link href="css/login.css" rel="stylesheet" type="text/css" />
<!--///////////////////////////////END OF STYLE SHEET ///////////////////////-->
        <script src="javascript/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="javascript/validation.js" type="text/javascript"></script>
        
    </head>
    
    <body>
        <div id="container">
            <div id="headerDiv">
<!--/////////////////////////// WELCOME USER ////////////////////////////////-->  
                
                <?php
                if (isset($_POST["btnLogout"]))
                {
                    unset($_SESSION["customer"]);
                }
                if (isset($_SESSION["customer"]))
                {
                    $custName = $_SESSION["customer"]["name"];
                    echo "<span id='welcomeSpan'><a id='aWelcome' href='account.php'>Welcome, $custName</a></span>";
                    echo "  <script> 
                            $(function() 
                                {
                                    $('#login').remove();
                                })
                            </script>";
                }
                ?>
<!--///////////////////////// END OF WELCOME USER ///////////////////////////--> 
                <p>
                    <a id="login" href="login.php">login &#124;</a>
                    <a id="cart" href="basket.php">
                        <img src="css/images/imgCartW26xH26.png" width="26" height="26" alt="Cart Image"/>
                        my cart&nbsp;<?php $size = sizeof($_SESSION["basket"]); echo "$size"; ?>&nbsp;items
                    </a>
                </p>
            </div>
<!--///////////////////////////////NAVIGATION PANEL//////////////////////////-->
            <form action="search.php" method="post">
                <div id="navigationDiv">
                    <ul>
                        <li>                      <a class="logo" href="index.php"></a>               </li>
                        <li>                      <a class="button" href="beds.php">BEDS</a>          </li>
                        <li>                      <a class="button" href="chairs.php">CHAIRS</a>      </li>
                        <li>                      <a class="button" href="chests.php">CHESTS</a>      </li>
                        <li class="txtNav">       <input type="text" name="txtSearch"/>               </li>
                        <li class="searchNav">    <input type="submit" name="btnSearch" value=""/>    </li>
                    </ul>
                </div>
            </form>
            <?php
                include_once ("connect.php");
                
                //////////////////////// HAS NOT ACCOUNT ///////////////////////
                $errorMessage = "";
                $firstName = "";
                $lastName = "";
                $email = "";
                $pwd = "";
                $verifyPwd = "";
                $address = "";
                $postCode = "";
                $cardNo = "";
                
                //////////////////////// HAS ACCOUNT //////////////////////////
                $hasEmail = "";
                $hasPwd = "";
                $hasErrorMessage = "";
                
                 //////////////////////// BUTTON LOGIN /////////////////////
                if (isset($_POST["btnLogin"]))
                {
                    $hasEmail = $_POST["txtEmail"];
                    $hasPwd = $_POST["txtPwd"];
                    
                    /////////////////// QUERY EMAIL EXISTS ? ///////////////
                    $query = "SELECT * FROM customers where email='$hasEmail'";   
                    $resultSet = mysql_query($query);
                    if (!$resultSet) die("<ERROR: Cannot execute $query>");
                    $fetchedRow = mysql_fetch_assoc($resultSet);
                    /////////////////// END OF UERY EMAIL EXISTS ///////////
                    
                    if ($fetchedRow == null)
                    {
                        $hasErrorMessage = "ERROR: No such email exists in our database";
                    }
                    else
                    {
                        $hashedPwd = md5($hasPwd);
                        $query = "SELECT * FROM customers where email='$hasEmail' and password = '$hashedPwd'";   
                        $resultSet = mysql_query($query);
                        if (!$resultSet) die("<ERROR: Cannot execute $query>");
                        $fetchedRow = mysql_fetch_assoc($resultSet);
                        
                        if ($fetchedRow != null)
                        {
                            $firstName = $fetchedRow["firstName"];
                            $lastName = $fetchedRow["lastName"];
                            $custName = $firstName." ".$lastName;
                            $hasAddress = $fetchedRow["address"];
                            $hasPostCode = $fetchedRow["postCode"];
                            $hasCardNo = $fetchedRow["cardNo"];
                            $_SESSION["customer"] = array("firstName" => $firstName, "lastName" => $lastName, "name" => $custName, "email" => $hasEmail, "password" =>$hasPwd, "address" => "$hasAddress", "postCode" => "$hasPostCode", "cardNo" => "$hasCardNo");;
                            header("Location: index.php");
                        }
                        else
                        {
                            $hasErrorMessage = "ERROR: Password is incorrect";;                           
                        }
                    }
                }
                 //////////////////////// BUTTON REGISTER /////////////////////
                if (isset($_POST["btnRegister"]))
                {
                    $firstName = $_POST["txtFirstName"];
                    $lastName = $_POST["txtLastName"];
                    $email = $_POST["txtEmail"];
                    $pwd = $_POST["txtPwd"];
                    $verifyPwd = $_POST["txtVerifyPwd"];
                    $address = $_POST["txtAddress"];
                    $postCode = $_POST["txtPostCode"];
                    $cardNo = $_POST["txtCardNo"];

                    $rdyAddress = preg_replace('/\s+/', '', $address);

                    include_once "phpValidation.php";
                    if (!preg_match("/^[A-Z]+$/i", $firstName) || strlen($firstName) > 30)
                    {
                        $errorMessage = "ERROR: First name must contain only letters";
                        if (strlen($firstName) > 30)
                        {
                            $errorMessage = "ERROR: First name length must be less than 30 characters";
                        }
                    }
                    else if (!preg_match("/^[A-Z]+$/i", $lastName) || strlen($lastName) > 30)
                    {
                        $errorMessage = "ERROR: Last name must contain only letters";
                        if (strlen($lastName) > 30)
                        {
                            $errorMessage = "ERROR: Last name length must be less than 30 characters";
                        }
                    }
                    else if (!isEmail($email) || strlen($email) > 50)
                    {
                        $errorMessage = "ERROR: Email is not valid email!";
                        if (strlen($email) > 50)
                        {
                            $errorMessage = "ERROR: Email length must be less than 50 characters";
                        }
                    }
                    else if (!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $pwd) || strlen($pwd) > 30 || preg_match('/\s+/', $pwd))
                    {
                        $errorMessage = "ERROR: Password is invalid! password length must be 8, it must contain at least one upper case letter and one number";
                        if (strlen($pwd) > 30)
                        {
                            $errorMessage = "ERROR: Password length must be less than 30 characters";
                        }
                        if(preg_match('/\s+/', $pwd))
                        {
                            $errorMessage = "ERROR: Password must not contain spaces";
                        }
                    }
                    else if ($pwd != $verifyPwd)
                    {
                        $errorMessage = "ERROR: Passwords doesn't match!";
                    }
                    else if (!preg_match("/^([0-9]+)([A-Z',])+$/i", $rdyAddress) || strlen($rdyAddress) > 50)
                    {
                        $errorMessage = "ERROR: Address is invalid, it must be in the format: houseNo street city";
                        if(strlen($rdyAddress) > 50)
                        {
                            $errorMessage = "ERROR: Address length must be less than 50 characters";
                        }
                    }
                    else if (!preg_match("/^([A-Z])([A-Z0-9]+)\s([0-9])([A-Z])([A-Z])$/i", $postCode) || strlen($postCode) > 8)
                    {
                        $errorMessage = "ERROR: Post code is invalid!";
                        if(strlen($postCode) > 8)
                        {
                            $errorMessage = "ERROR: Post code length be less than 8 characters";
                        }
                    }
                    else if (!isCardNo($cardNo))
                    {
                        $errorMessage = "ERROR: Card number not valid!";
                    }
                    else
                    {
                        /////////////////// QUERY EMAIL EXISTS ? ///////////////
                        $query = "SELECT * FROM customers where email='$email'";   
                        $resultSet = mysql_query($query);
                        if (!$resultSet) die("<ERROR: Cannot execute $query>");
                        $fetchedRow = mysql_fetch_assoc($resultSet);
                        /////////////////// END OF UERY EMAIL EXISTS ///////////

                        if ($fetchedRow != null)
                        {
                            $errorMessage = "ERROR: Cannot register with this email, because it already exists in our system";
                        }
                        else
                        {
                            $hashedPassword = md5($pwd);
                            $createQuery = "INSERT INTO customers VALUES ('$firstName', '$lastName', '$email', '$hashedPassword', '$address', '$postCode', '$cardNo')";
                            $createResult = mysql_query($createQuery);
                            if (!$createResult) die("<ERROR: Cannot execute $createQuery>");
                            echo "  <script> 
                                        $(function() 
                                            {
                                                $('#frmHasNot').fadeOut('slow');
                                                $('#hasNotH5').replaceWith('<h2>Congratulation</h2>');
                                                $('#hasNotPara').replaceWith('<p>Your account has been created, please login now.</p>');
                                            })
                                    </script>
                                    ";
                        }
                    }
                }
            ?>
<!--////////////////////////////// LOGIN BOX DIV ////////////////////////////-->            
            <div id="loginBoxDiv">
                <h3> Login or Create Account </h3>
                <hr class="loginThinLine"/>
<!--///////////////////// DISPLAY HAS ACCOUNT ERROR MESSAGE ///////////////////--> 
                    <?php
                        if ($hasErrorMessage != "")
                        {
                            echo "  <div id='errorDiv'>
                                        $hasErrorMessage 
                                    </div>
                            <script> 
                            $(function() 
                                {
                                    $('#errorDiv').fadeIn('slow');
                                })
                           </script>";
                        }
                    ?>
<!--////////////////////////////// HAS ACCOUNT ////////////////////////////-->
                <div id="hasAccountDiv">
                    <h5>Existing Customers</h5>
                    <form id="frmHas" method="post">
                        <span class="spanInputs">Email Address:</span>
                        <input type="text" name="txtEmail" value="<?php echo $hasEmail ?>"/>
                        
                        <span class="spanInputs">Password:</span>
                        <input id="hasPassword" type="password" name="txtPwd" value="<?php echo $hasPwd ?>"/>
                        
                        <input type="submit" name="btnLogin" value="Login"/>
                    </form>
                </div>
<!--////////////////////////////// HAS NOT ACCOUNT ////////////////////////////-->               
                <div id="hasNotAccountDiv">
                    <h5 id="hasNotH5">New Customers</h5>
                    <p id="hasNotPara">To create an account, please complete the following fields.</p>
<!--///////////////////// DISPLAY ERROR MESSAGE ///////////////////--> 
                    <?php
                        if ($errorMessage != "")
                        {
                            echo "  <div id='errorDiv'>
                                        $errorMessage 
                                    </div>
                            <script> 
                            $(function() 
                                {
                                    $('#errorDiv').fadeIn('slow');
                                })
                           </script>";
                        }
                    ?>
<!--///////////////////// END OF DISPLAYING ERROR MESSAGE ///////////////////-->  
                        <form id="frmHasNot" method="post">
                        <span class="spanInputs">First Name:</span>
                        <input type="text" name="txtFirstName" value="<?php echo $firstName ?>"/>
                        
                        <span class="spanInputs">Last Name:</span>
                        <input type="text" name="txtLastName" value="<?php echo $lastName ?>"/>
                        
                        <span class="spanInputs">Email Address:</span>
                        <input type="text" name="txtEmail" value="<?php echo $email?>"/>
                        
                        <span class="spanInputs">Create Password:</span>
                        <input type="password" name="txtPwd" value="<?php echo $pwd ?>"/>
                        
                        <span class="spanInputs">Verify Password:</span>
                        <input type="password" name="txtVerifyPwd" value="<?php echo $verifyPwd ?>"/>
                        
                        <span class="spanInputs">Address:</span>
                        <input type="text" name="txtAddress" value="<?php echo $address ?>"/>
                        
                        <span class="spanInputs">Post Code:</span>
                        <input type="text" name="txtPostCode" value="<?php echo $postCode ?>"/>
                        
                        <span class="spanInputs">Card No:</span>
                        <input type="text" name="txtCardNo" value="<?php echo $cardNo ?>"/>
                        
                        <input type="submit" name="btnRegister" value="Register"/>
                    </form>
                
                </div>

                <div id="loginThickLine">
                    
                </div>     
            </div>
<!--////////////////////////////// END OF LOGIN BOX DIV /////////////////////-->
            
            <div id="footerDiv">
                <p>
                    <a href="#">Page Last Updated: December 31, 2012</a>
                    &#124;
                    <a href="#">Page Editor: Davaasuren Dorjdagva</a>
                    &#124;
                    <a href="#">Terms of Use</a>
                    &#124;
                    <a href="#">Privacy Policy</a>
                    &#124;
                    <a href="#">&copy;2013 All Rights Reserved.</a>
                </p>
            </div>
        </div>
<!--///////////////////////////////END OF CONTAINER/////////////////////////-->
    </body>
</html>

