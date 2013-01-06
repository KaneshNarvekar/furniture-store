<!DOCTYPE html>
<html>
    <head>
        <title>Product Information &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/productStyle.css"/>
        <link rel="stylesheet" type="text/css" href="css/pagination.css"/>
	<link rel="stylesheet" type="text/css" href="css/grey.css"/>
        <link rel="stylesheet" type="text/css" href="css/prodInfoStyle.css"/>
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
                <?php
                include_once ("connect.php");
                $type = $_GET["type"];
                $query = "SELECT * FROM products where type=\"$type\"";
                $resultSet = mysql_query($query);
                if (!$resultSet) die("<ERROR: Cannot execute $query>");
                
                $prodId = $_GET["prodId"];
                $prodFound = false;
                $fetchedRow = mysql_fetch_row($resultSet);
                
                while ($fetchedRow != null && !$prodFound)
                {
                    $id = $fetchedRow[0];
                    if ($id == $prodId)
                    {
                        $name = $fetchedRow[1];
                        $prodDesc = $fetchedRow[3];
                        $price = $fetchedRow[5];
                        $bigImageName = $fetchedRow[6];
                        
                        echo "<div id=\"prodImage\">";
                        echo "<h2>$name</h2>";
                        echo "<img src=\"css/images/chairs/$bigImageName\" alt=\"Big chest image\"/>";
                        echo "</div>";
                        
                        echo "<div id=\"prodDesc\">";
                        echo "<h2>Product Description</h2>";
                        echo "<p>$prodDesc</p>";
                        echo " $price";
                        echo "</div>";
                        $prodFound = true;
                    }
                    $fetchedRow = mysql_fetch_row($resultSet);
                }
                if ( !$prodFound )
                {
                    echo "<div id=\"notFound\">";
                    echo "<p>Sorry we couldn't find the item you are looking for, maybe it is no longer available.</p>";
                    echo "</div>";
                }
                ?>
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
            

    <h2>Details and Dimensions</h2>
    <ul>
        <li>Eco-friendly construction</li>
        <li>Certified sustainable, kiln-dried solid maple and oak hardwood frame</li>
        <li>Tight seat and back with soy-based polyfoam and fiber cushioning</li>
        <li>Sinuous wire spring suspension</li>
        <li>Hardwood legs with a Deco finish</li>
        <li>100% polyester upholstery</li>
        <li>Self-welt detailing</li>
        <li>Benchmade</li>
        <li>Made in Virginia, USA</li>
    </ul>

    <h2>Overall Dimensions:</h2>
    <ul>
        <li>Width: 30.5&quot; </li>
        <li>Depth: 28&quot;</li> 
        <li>Height: 30.5&quot;</li> 
        <li>SeatDepth: 22&quot;</li> 
        <li>Height: 19.25&quot;</li>
    </ul>
            
            
        </div> <!--    end of container   -->
    </body>
</html>

