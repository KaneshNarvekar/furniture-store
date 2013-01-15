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
                <p>
                   <a href="#">login</a>
                   &#124;
                   <a href="#">my account</a>
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

<!--////////////////////////////// LOGIN BOX DIV ////////////////////////////-->            
            <div id="loginBoxDiv">
                <h3> Login or Create Account </h3>
                <hr class="loginThinLine"/>
<!--////////////////////////////// HAS ACCOUNT ////////////////////////////-->
                <div id="hasAccountDiv">
                    <h5>Existing Customers</h5>
                    <form>
                        
                        <span class="spanInputs">Email Address:</span>
                        <input type="text" value=""/>
                        
                        <span class="spanInputs">Password:</span>
                        <input type="text" value=""/>
                        
                        <input type="submit" value="Login"/>
                    </form>
                </div>
<!--////////////////////////////// HAS NOT ACCOUNT ////////////////////////////-->               
                <div id="hasNotAccountDiv">
                    <h5>New Customers</h5>
                    <p>To create an account, please complete the following fields.</p>
                    <form>
                        <span class="spanInputs">First Name:</span>
                        <input type="text" value=""/>
                        
                        <span class="spanInputs">Last Name:</span>
                        <input type="text" value=""/>
                        
                        <span class="spanInputs">Email Address:</span>
                        <input type="text" value=""/>
                        
                        <span class="spanInputs">Create Password:</span>
                        <input type="text" value=""/>
                        
                        <span class="spanInputs">Verify Password:</span>
                        <input type="text" value=""/>
                        
                        <span class="spanInputs">Address:</span>
                        <input type="text" value=""/>
                        
                        <input type="submit" value="Register"/>
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

