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
        <link href="css/account.css" rel="stylesheet" type="text/css" />
<!--///////////////////////////////END OF STYLE SHEET ///////////////////////-->
        <script src="javascript/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="javascript/validation.js" type="text/javascript"></script>
        
    </head>
    
    <body>
        <div id="container">
            <div id="headerDiv">
<!--/////////////////////////// WELCOME USER ////////////////////////////////-->  
                <form id='frmLogout' method="post">
                <?php
                if (isset($_POST["btnLogout"]))
                {
                    unset($_SESSION["customer"]);
                }
                if (isset($_SESSION["customer"]))
                {
                    $custName = $_SESSION["customer"]["name"];
                    $custEmail = $_SESSION["customer"]["email"];
                    echo "<span id='custName'>
                                Welcome,&nbsp;<a id='aCustName' href='account.php?custEmail=$custEmail'>$custName</a>
                                &nbsp;&nbsp;&nbsp;
                                <input type='submit' name='btnLogout' value='(Logout)'/>
                          </span>";
                    echo "  <script> 
                                $(function() 
                                    {
                                        $('#login').remove();
                                    })
                            </script>";
                }
                ?>
                </form>
<!--///////////////////////// END OF WELCOME USER ///////////////////////////--> 
                <p>
                   <a id="login" href="#">login</a>
                   &#124;
                   <a href="basket.php">my cart&nbsp;<?php $size = sizeof($_SESSION["basket"]); echo "<span id='nItems'>$size</span>"; ?>&nbsp;items</a>
                </p>
            </div>
<!--///////////////////////////////NAVIGATION PANEL//////////////////////////-->
            <form>
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
                
                $email = $_SESSION["customer"]["email"];
                $query = "SELECT * FROM customers where email='$email'";   
                $resultSet = mysql_query($query);
                if (!$resultSet) die("<ERROR: Cannot execute $query>");
                $fetchedRow = mysql_fetch_assoc($resultSet);

                if ($fetchedRow == null)
                {
                    echo "<div id='accountBoxDiv'>
                            <div id='accountThickLine'></div> 
                            <div id='accountDiv'>
                                <h3>There is something wrong with your account.</h3>
                                <p>Please contact customer service for more information.</p>
                                <div id='accountImage'>
                                    <img src='css/images/davaW340xH600.jpg' width='340' height='600' alt='account image'/>
                                </div>
                                <div id='loginThickLine'></div>    
                             </div>
                          </div>";
                }
                else if (isset($_REQUEST["btnUpdate"]))           
                {
                    $firstName = $_GET["txtFirstName"];
                    $lastName = $_GET["txtLastName"];
                    $postEmail = $_GET["txtEmail"];
                    $pwd = $_GET["txtPwd"];
                    $verifyPwd = $_GET["txtVerifyPwd"];
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
                        $query = "SELECT * FROM customers where email='$postEmail' AND email != '$email'";   
                        $resultSet = mysql_query($query);
                        if (!$resultSet) die("<ERROR: Cannot execute $query>");
                        $fetchedRow = mysql_fetch_assoc($resultSet);
                        /////////////////// END OF UERY EMAIL EXISTS ///////////

                        if ($fetchedRow != null)
                        {
                            $errorMessage = "ERROR: Cannot register with this email, it is already registered.";
                        }
                        else
                        {
                            $createQuery = "UPDATE customers 
                                             SET firstName = '$firstName', 
                                                 lastName = '$lastName', 
                                                 email = '$postEmail', 
                                                 password = '$pwd', 
                                                 address = '$address', 
                                                 postCode = '$postCode', 
                                                 cardNo = '$cardNo'
                                                 where email = '$email'";
                            $createResult = mysql_query($createQuery);
                            if (!$createResult) die("<ERROR: Cannot execute $createQuery>");
                            $tempName = $firstName." ".$lastName;
                            $_SESSION["customer"]["name"] = $tempName;
                            $_SESSION["customer"]["email"] = $postEmail;
                            header("Location: account.php?congrat=yes");
                        }
                    }
                }
                else // IF UPDATE BUTTON NOT CLICKED
                {
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
                    $firstName = $fetchedRow["firstName"];
                    $lastName = $fetchedRow["lastName"];
                    $pwd = $fetchedRow["password"];
                    $verifyPwd = $pwd;
                    $address = $fetchedRow["address"];
                    $postCode = $fetchedRow["postCode"];
                    $cardNo = $fetchedRow["cardNo"];
                }
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
                        
                        <span class="spanInputs">Create Password:</span>
                        <input type="text" name="txtPwd" value="<?php echo $pwd ?>"/>
                        
                        <span class="spanInputs">Verify Password:</span>
                        <input type="text" name="txtVerifyPwd" value="<?php echo $verifyPwd ?>"/>
                        
                        <span class="spanInputs">Address:</span>
                        <input type="text" name="txtAddress" value="<?php echo $address ?>"/>
                        
                        <span class="spanInputs">Post Code:</span>
                        <input type="text" name="txtPostCode" value="<?php echo $postCode ?>"/>
                        
                        <span class="spanInputs">Card No:</span>
                        <input type="text" name="txtCardNo" value="<?php echo $cardNo ?>"/>
                        
                        <input type="submit" name="btnUpdate" value="Update"/>
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

