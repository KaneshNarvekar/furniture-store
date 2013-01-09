<!DOCTYPE html>
<html>
    <head>
        <title>Beds &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/productStyle.css"/>
        <link rel="stylesheet" type="text/css" href="css/pagination.css"/>
	<link rel="stylesheet" type="text/css" href="css/grey.css"/>
        
    </head>
    <body>
        <div id="container">
            <div id="headerPanel">
                <p>
                   <a href="#">login</a>
                   &#124;
                   <a href="#">my account</a>
                   &#124;
                   <a href="#">my cart 0 items</a>
                </p>
            </div>
            <form>
            <div id="navPanel">
                <ul>
                    <li><a class="logo" href="index.html"></a></li>
                    <li><a class="button" href="chairs.php">CHAIRS</a></li>
                    <li><a class="button" href="chests.php">CHESTS</a></li>
                    <li><a class="button" href="beds.php">BEDS</a></li>
                    <li class="txtNav"><input type="text" name="txtSearch"/></li>
                    <li class="searchNav"><input type="submit" name="btnSearch" value=""/></li>
                </ul>
            </div>
            </form>
            
            <div id="productPanel">
                
                <div class="prodImages">
                    <a href="prodInfo.php?prodId=bed12&amp;type=bed"><img src="css/images/beds/imgBed1W300xH439.jpg" alt="Bed images"/></a>
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
                                $displayImage = "<img src=\"css/images/beds/$imageName\" alt=\"tableImage\"/>";
                                echo " <td><a href=\"prodInfo.php?prodId=$id&type=$type\"> $displayImage <p>$name <span class=\"price\">£$price</span></p></a></td> ";
                                $fetchedRow = mysql_fetch_row($resultSet);
                            }
                        }
                        echo "</tr>";
                    }
                    ?>    
                </table>
                
                <div class="prodImages">
                    <img src="css/images/beds/imgBed2W300xH439.jpg" alt="Bed images"/>
                </div>
                
                <div id="pagination">
                    <?php echo pagination($statement,$limit,$page); ?>
                </div>
            </div> <!--    end of product Panel   -->
            
            
            
            <div id="footer">
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
            
            
            
        </div> <!--    end of container   -->
    </body>
</html>
