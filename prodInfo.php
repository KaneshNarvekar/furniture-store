<?php 
session_start();
$_SESSION["allow"] = true;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Product Information &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link href="ratingfiles/ratings.css" rel="stylesheet" type="text/css"/>
        
        <link href="css/home.css" rel="stylesheet" type="text/css"/>
        <link href="css/prodInfo.css" rel="stylesheet" type="text/css"/>
<!--///////////////////////////////END OF STYLE SHEET ///////////////////////-->

        <script src="ratingfiles/ratings.js" type="text/javascript"></script>
        <script src="javascript/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="javascript/jquery.cycle.all.js" type="text/javascript"></script>
        
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
                    
                });       
            })
        </script>
    </head>
<!--///////////////////////////////END OF HEAD///////////////////////////////-->
    
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
<!--///////////////////////////////END OF NAVIGATION/////////////////////////-->
            
            <div id="prodInfoBoxDiv">
<?php
    include_once ("connect.php");

    $type = $_GET["type"];
    $prodId = $_GET["prodId"];
    $query = "SELECT * FROM products where type=\"$type\"";
    $resultSet = mysql_query($query);
    if (!$resultSet) die("<ERROR: Cannot execute $query>");

    $fetchedRow = mysql_fetch_assoc($resultSet);
    $prodFound = false;

    while ($fetchedRow && !$prodFound)   //BY GIVEN ID FIND THE ITEM AND DISPLAY IT
    {
        $id = $fetchedRow["prodId"];
        if ($id == $prodId)
        {
            $name = $fetchedRow["prodName"];
            $imgName = $fetchedRow["prodImage"];
            $prodDesc = $fetchedRow["prodDesc"];
            $types = $type."s";
            $price = $fetchedRow["price"];
            $BigImgNames = $fetchedRow["bigImageNames"];
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
                if ($i == 0) 
                    { 
                        $className = "firstProdSlide"; 
                    }
                else 
                    { 
                        $className = "otherProdSlides"; 
                    }
                echo "<img class='$className' src='css/images/$types/$bigImgNamesArray[$i]' alt='Big $type image'/>";
            }
            echo "          </div>
                            <ul id='prodThumbs'></ul>
                        </div>
                    </div>";
            $descArray = explode("!!stop!!", $prodDesc);
            echo "$descArray[0]";
            echo "<form id='frmAddBasket'>
                    <input type='hidden' name='prodId' value='$id'/>
                    <input type='hidden' name='type' value='$type'/>
                    <p>
                      GBP &pound;$price
                      <input type='text' name='txtQty' value='1'/>
                      <input type='submit' name='btnAddToBasket' value='Add to Basket'>
                    </p>
                </form>";

            echo "$descArray[1]";
        }
        $fetchedRow = mysql_fetch_assoc($resultSet);
    } 
    /////////////// END OF WHILE LOOP ///////////////

    if (!$prodFound)    //IF PRODUCT IS NOT FOUND DISPLAY NOT FOUND DIV
    {
        echo "<div id=\"notFound\">";
        echo "<p>Sorry we couldn't find the item you are looking for, maybe it is no longer available.</p>";
        echo "</div>";
    }
    else
    {
        if (isset($_REQUEST["btnAddToBasket"])) //ELSE SEE IF ADD TO BASKET BUTTON CLICKED
        {
            $basket = $_SESSION["basket"]; 
            $qty = $_REQUEST["txtQty"];
            $item = array("id"=>$id, "name"=>$name, "price"=>$price, "qty"=>$qty, "imageName"=>$imgName, "types"=>$types);

            if ($_SESSION["addToBasket"]) //IF COMING FROM PRODUCT LIST
            {
                $itemFound = false;
                $size = sizeof($basket);
                $i = 0;
                while ($i < $size && !$itemFound)
                {
                    $oldId = $basket[$i]["id"];
                    if ($id == $oldId)              // IF PRODUCT ALREADY EXIST ADD QUANTITY
                    {
                        $oldQty = $basket[$i]["qty"];
                        $basket[$i]["qty"] = $oldQty + $qty;
                        $itemFound = true;
                    }
                    $i++;
                }
                if (!$itemFound)  // IF PRODUCT NOT FOUND THEN ADD IT TO THE BASKET
                {
                    $basket[] = $item;
                }    
                $_SESSION["addToBasket"] = false;  //DISABLE REFRESH

            }
            $_SESSION["basket"] = $basket;
            $nItems = sizeof($_SESSION["basket"]);      // TO DISPLAY CURRENT BASKET SIZE
        echo "<script>                              
                $(function() 
                {
                    $('#nItems').replaceWith('<strong>$nItems</strong>');
                }) 
             </script>";
        }
    }
?>
            </div>
<!--///////////////////////////////END OF PRODUCT INFO BOX //////////////////-->
            
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

