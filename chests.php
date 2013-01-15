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
        <title>Chests &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link href="css/pagination.css" rel="stylesheet" type="text/css"/>
	<link href="css/grey.css" rel="stylesheet" type="text/css"/>
        
        <link href="css/home.css" rel="stylesheet" type="text/css"/>
        <link href="css/prodList.css" rel="stylesheet" type="text/css"/>
<!--///////////////////////////////END OF STYLE SHEET ///////////////////////-->
    </head>
    <body>
        <div id="container">
            <div id="headerDiv">
                <p>
                   <a href="login.php">login</a>
                   &#124;
                   <a href="#">my account</a>
                   &#124;
                   <a href="basket.php">my cart&nbsp;<?php $size = sizeof($_SESSION["basket"]); echo "$size"; ?>&nbsp;items</a>
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
                <div id="greyBG"> <h6> Luxury Chests </h6> </div>
                <div class="prodImages">
                    <img src="css/images/chests/imgChest1W300xH439.jpg" width="300" height="439" alt="Chest images"/>
                </div>
                <table id="productTable">
                    <?php
                    include_once ("connect.php");
                    include_once ("function.php");

                    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                    $limit = 9;
                    $startpoint = ($page * $limit) - $limit;
                    $statement = "FROM products where type=\"chest\"";
                    $type = "chest";
                    $query = "SELECT * FROM products where type = \"chest\" LIMIT {$startpoint} , {$limit}";
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
                                $displayImage = "<img src=\"css/images/chests/$imageName\" width='158' height='158' alt=\"tableImage\"/>";
                                echo " <td><a href=\"prodInfo.php?prodId=$id\"> $displayImage <p>$name <span class=\"price\">£$price</span></p></a></td> ";
                                $fetchedRow = mysql_fetch_row($resultSet);
                            }
                        }
                        echo "</tr>";
                    }
                    ?>    
                </table>
                <div class="prodImages">
                    <img src="css/images/chests/imgChest2W300xH439.jpg" width="300" height="439" alt="Chest images"/>
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
<!--///////////////////////////////END OF CONTAINER //////////////////////-->
    </body>
</html>
