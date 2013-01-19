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
        <title>Account &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link href="css/home.css" rel="stylesheet" type="text/css" />
        <link href="css/login.css" rel="stylesheet" type="text/css" />
        <link href="css/account.css" rel="stylesheet" type="text/css" />
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
                        <li>                      <a class="button" href="chairs.php">CHAIRS</a>      </li>
                        <li>                      <a class="button" href="chests.php">CHESTS</a>      </li>
                        <li>                      <a class="button" href="beds.php">BEDS</a>          </li>
                        <li class="txtNav">       <input type="text" name="txtSearch"/>               </li>
                        <li class="searchNav">    <input type="submit" name="btnSearch" value=""/>    </li>
                    </ul>
                </div>
            </form>
            <?php
                include_once ("connect.php");
                $errorMessage = "";
                
                if ((isset($_REQUEST["btnLogout"])))
                {
                    unset($_SESSION["customer"]);
                    header("Location: index.php");
                }
                
                if (!isset($_SESSION["customer"]))
                {
                    header("Location: index.php");
                }
                else if (isset($_REQUEST["btnUpdate"]))           
                {
                    
                    $firstName = $_GET["txtFirstName"];
                    $lastName = $_GET["txtLastName"];
                    $postEmail = $_GET["txtEmail"];
                    $pwd = $_GET["txtPwd"];
                    $address = $_GET["txtAddress"];
                    $postCode = $_GET["txtPostCode"];
                    $cardNo = $_GET["txtCardNo"];

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
                    else if (!isEmail($postEmail) || strlen($postEmail) > 50)
                    {
                        $errorMessage = "ERROR: Email is not valid email!";
                        if (strlen($postEmail) > 50)
                        {
                            $errorMessage = "ERROR: Email length must be less than 50 characters";
                        }
                    }
                    else if (!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $pwd) || strlen($pwd) > 30)
                    {
                        $errorMessage = "ERROR: Password is invalid! password length must be 8, it must contain at least one upper case letter and one number";
                        if (strlen($pwd) > 30)
                        {
                            $errorMessage = "ERROR: Password length must be less than 30 characters";
                        }
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
                        $currentEmail = $_SESSION["customer"]["email"];
                        
                        $query = "SELECT * FROM customers where email = '$postEmail' and email != '$currentEmail'";   
                        $resultSet = mysql_query($query);
                        if (!$resultSet) die("<ERROR: Cannot execute $query>");
                        $fetchedRow = mysql_fetch_assoc($resultSet);
                        if ($fetchedRow != null)
                        {
                            $errorMessage = "ERROR: Email you want to change is already registered with another account.";
                        }
                        else
                        {
                            $salt= "pg!@*";
                            $hashedPwd = md5($salt.$pwd);
                            $createQuery = "UPDATE customers 
                                             SET firstName = '$firstName', 
                                                 lastName = '$lastName',
                                                 email = '$postEmail', 
                                                 password = '$hashedPwd', 
                                                 address = '$address', 
                                                 postCode = '$postCode', 
                                                 cardNo = '$cardNo'
                                                 where email = '$currentEmail'";
                            $createResult = mysql_query($createQuery);
                            if (!$createResult) die("<ERROR: Cannot execute $createQuery>");
                            $tempName = $firstName." ".$lastName;
                            $_SESSION["customer"]["name"] = $tempName;
                            $_SESSION["customer"]["firstName"] = $firstName;
                            $_SESSION["customer"]["lastName"] = $lastName;
                            $_SESSION["customer"]["email"] = $postEmail;
                            $_SESSION["customer"]["password"] = $pwd;
                            $_SESSION["customer"]["address"] = $address;
                            $_SESSION["customer"]["postCode"] = $postCode;
                            $_SESSION["customer"]["cardNo"] = $cardNo;
                            header("Location: account.php?congrat=yes");
                        }
                    }
                }
                if (isset($_REQUEST["congrat"]))
                {
                    echo "  <script> 
                                    $(function() 
                                        {
                                            $('#frmHasNot').fadeOut('slow');
                                            $('#h3Id').replaceWith('<h3>Congratulation</h3>');
                                            $('#paraId').replaceWith('<p>Your account has been updated.</p>');
                                        })
                            </script>
                            ";
                }
                $firstName = $_SESSION["customer"]["firstName"];
                $lastName = $_SESSION["customer"]["lastName"];
                $email = $_SESSION["customer"]["email"];
                $pwd = $_SESSION["customer"]["password"];
                $address = $_SESSION["customer"]["address"];
                $postCode = $_SESSION["customer"]["postCode"];
                $cardNo = $_SESSION["customer"]["cardNo"];
            ?>
            <div id="accountBoxDiv">
                <div id="accountThickLine"></div> 
<!--////////////////////////////// ACCOUNT DIV //////////////////////////////-->               
                <div id="accountDiv">
                    <h3 id="h3Id">Your Account</h3>
                    <p id="paraId">Here you can edit your personal information.</p>
                    <?php
                        if ($errorMessage != "")    // IF ERROR IS NOT EMPTY DISPLAY ERROR MESSAGE
                        {
                            echo "  <div id='accountErrorDiv'>
                                        $errorMessage 
                                    </div>
                            <script> 
                            $(function() 
                                {
                                    $('#accountErrorDiv').fadeIn('slow');
                                })
                           </script>";
                        }
                    ?>
                    <form id="frmAccount">
                        <span class="spanInputs">First Name:</span>
                        <input type="text" name="txtFirstName" value="<?php echo $firstName ?>"/>

                        <span class="spanInputs">Last Name:</span>
                        <input type="text" name="txtLastName" value="<?php echo $lastName ?>"/>

                        <span class="spanInputs">Email Address:</span>
                        <input type="text" name="txtEmail" value="<?php echo $email?>"/>

                        <span class="spanInputs">Password:</span>
                        <input type="text" name="txtPwd" value="<?php echo $pwd ?>"/>

                        <span class="spanInputs">Address:</span>
                        <input type="text" name="txtAddress" value="<?php echo $address ?>"/>

                        <span class="spanInputs">Post Code:</span>
                        <input type="text" name="txtPostCode" value="<?php echo $postCode ?>"/>

                        <span class="spanInputs">Card No:</span>
                        <input type="text" name="txtCardNo" value="<?php echo $cardNo ?>"/>

                        <input type="submit" name="btnUpdate" value="Update"/>

                        <input id="btnLogout" type="submit" name="btnLogout" value="Logout"/>
                    </form>
                </div>
<!--/////////////////////////// END OF ACCOUNT DIV //////////////////////////-->
                <div id="accountImage">
                    <img src="css/images/davaW340xH600.jpg" width="340" height="600" alt="account image"/>
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

