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
        <title>Beds &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link href="css/pagination.css" rel="stylesheet" type="text/css"/>
	<link href="css/grey.css" rel="stylesheet" type="text/css"/>
        
        <link href="css/home.css" rel="stylesheet" type="text/css"/>
        <link href="css/prodList.css" rel="stylesheet" type="text/css"/>
<!--///////////////////////////////END OF STYLE SHEET ///////////////////////-->
        <script src="javascript/jquery-1.8.3.min.js" type="text/javascript"></script>
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
<!--///////////////////////////////NAVIGATION DIV ///////////////////////////-->
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
<!--///////////////////////////////END OF NAVIGATION ////////////////////////-->
            
            <div id="prodListDiv">
                <div id="greyBG"> <h6> Luxury Beds </h6> </div>
                <div class="prodImages">
                    <a href="prodInfo.php?prodId=bed12&amp;type=bed"><img src="css/images/beds/imgBed1W300xH439.jpg" width="300" height="439" alt="Bed images"/></a>
                </div>
                
                <table id="productTable">
                    <?php
                    include_once ("connect.php");
                    include_once ("function.php");

                    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                    $limit = 9;
                    $startpoint = ($page * $limit) - $limit;
                    $statement = "FROM products where type=\"bed\"";
                    $type = "bed";
                    $query = "SELECT * FROM products where type = \"bed\" LIMIT {$startpoint} , {$limit}";
                    $resultSet = mysql_query($query);
                    if (!$resultSet) die("<ERROR: Cannot execute $query>");
                    $fetchedRow = mysql_fetch_row($resultSet);

                    for ($rowNumber = 0; $rowNumber < 3; $rowNumber++)
                    {
                        echo "<tr>";
                        for ($columnNumber = 0; $columnNumber < 3; $columnNumber++)
                        {
                            if ($fetchedRow == null) 
                            {
                                echo "<td></td>";
                            }
                            else
                            {
                                $id = $fetchedRow[0];
                                $name = $fetchedRow[1];
                                $imageName = $fetchedRow[2];
                                $price = $fetchedRow[5];
                                $displayImage = "<img src=\"css/images/beds/$imageName\" width='158' height='158' alt=\"tableImage\"/>";
                                echo " <td><a href=\"prodInfo.php?prodId=$id\"> $displayImage <p>$name <span class=\"price\">£$price</span></p></a></td> ";
                                $fetchedRow = mysql_fetch_row($resultSet);
                            }
                        }
                        echo "</tr>";
                    }
                    ?>    
                </table>
                
                <div class="prodImages">
                    <img src="css/images/beds/imgBed2W300xH439.jpg" width="300" height="439" alt="Bed images"/>
                </div>
                
                <div id="paginationBoxDiv">
                    <div id="paginationDiv"><?php echo pagination($statement,$limit,$page); ?></div>
                </div>
            </div>
<!--///////////////////////////////END OF PRODUCT LIST //////////////////////-->
            
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
<!--///////////////////////////////END OF CONTAINER /////////////////////////-->
    </body>
</html>
