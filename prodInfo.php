<!DOCTYPE html>
<html>
    <head>
        <title>Product Information &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/prodInfoStyle.css" rel="stylesheet" type="text/css" />
        <link href="ratingfiles/ratings.css" rel="stylesheet" type="text/css" />
        <script src="ratingfiles/ratings.js" type="text/javascript"></script>
        <script type="text/javascript" src="javascript/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="javascript/jquery.cycle.all.js"></script>
        <script type="text/javascript" src="javascript/jquery.easing.1.3.js"></script>
        
         <script type="text/javascript">
             $.fn.cycle.updateActivePagerLink = function(pager, currSlideIndex) {
                 $(pager).find('li').removeClass('activeLI')
                 .filter('li:eq('+currSlideIndex+')').addClass('activeLI');
             };
             
             $.fn.cycle.updateActivePagerLink = function(pager, currSlide, clsName) {
                 $(pager).each(function() {
                     console.log(clsName + '; ' + currSlide ); 
                     $(this).children().removeClass('activeLI').filter(':eq('+currSlide+')').addClass('activeLI');
                 });
             };
             
            $(document).ready(
                function()
                {
                    $('#prodSlides').cycle(
                        {
                            fx:     'fade',
                            speed:  'slow',
                            timeout: 0,
                            pager: '#prodThumbs',
                            pagerAnchorBuilder: function(idx, slide) 
                            {
                                return '<li><a href="#"><img src="' + slide.src + '" width="50" height="50" /></a></li>';
                            }
                            
                        }
                    );       
                }
            )
        </script>
        
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
            
            <div id="prodInfoDiv">
                <?php
                include_once ("connect.php");
                $type = $_GET["type"];
                $query = "SELECT * FROM products where type=\"$type\"";
                $resultSet = mysql_query($query);
                if (!$resultSet)
                    die("<ERROR: Cannot execute $query>");

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
                        $BigImgNames = $fetchedRow[6];
                        $bigImgNamesArray = explode(":", $BigImgNames);
                        $size = sizeof($bigImgNamesArray);
                        $prodFound = true;
                        echo "  <hr class='thickLine'/>
                                <div id='imgDivBg'>
                                    <div id='imgDiv'>
                                        <h2>$name</h2>
                                        <div id='stars'> <div class='srtgs' id='rt_$id'></div> </div>
                                        <div id='prodSlides'>";
                        for ($i = 0; $i < $size; $i++)
                        {
                            echo "<img src='css/images/chairs/$bigImgNamesArray[$i]' alt='Big chair image'/>";
                        }
                        echo "          </div>
                                        <ul id='prodThumbs'></ul>
                                    </div>
                                </div>";
                        $descArray = explode("!!stop!!", $prodDesc);
                        echo "$descArray[0]";
                        echo "<form id='frmAddBasket' action='basket.php'>
                              <input type='hidden' name='hidId' value='$id'/>
                              <input type='hidden' name='hidName' value='$name'/>
                              <input type='hidden' name='hidPrice' value='$price'/>
                            <p>GBP &pound;$price
                                <input type='text' name='txtQty' value='1'/>
                                <input type='submit' name='btnAddToBasket' value='Add to Basket'></p>
                            </form>";
                        echo "$descArray[1]";
                    }
                    $fetchedRow = mysql_fetch_row($resultSet);
                }
                if (!$prodFound)
                {
                    echo "<div id=\"notFound\">";
                    echo "<p>Sorry we couldn't find the item you are looking for, maybe it is no longer available.</p>";
                    echo "</div>";
                }
                ?>
            </div> <!--    end of product info Panel   -->
            
            
            

   
   
   
   
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

