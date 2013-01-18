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
        <title>Thank you &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link href="css/home.css" rel="stylesheet" type="text/css" />
        <link href="css/thankyou.css" rel="stylesheet" type="text/css" />
<!--///////////////////////////////END OF STYLE SHEET ///////////////////////-->
        <script src="javascript/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="javascript/validation.js" type="text/javascript"></script>
        <script src="javascript/snow.js" type="text/javascript"></script>
    </head>
    
    <body>
        <div id="container">
            <div id="headerDiv">
<!--/////////////////////////// WELCOME USER ////////////////////////////////-->  
                
                <?php
                if (!isset($_SESSION["customer"]))
                {
                    header("Location: index.php");
                }
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
                <div id="thankyouDiv">
                    <h2> Thank you your order has been placed!!!</h2>
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

