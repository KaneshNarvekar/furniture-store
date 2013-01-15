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
        <title>Your Basket &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link href="css/home.css" rel="stylesheet" type="text/css" />
        <link href="css/basket.css" rel="stylesheet" type="text/css" />
<!--///////////////////////////////END OF STYLE SHEET ///////////////////////-->
        <script src="javascript/jquery-1.8.3.min.js" type="text/javascript"></script>
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
<!--///////////////////////////////END OF NAVIGATION/////////////////////////-->
            
            <div id="basketDiv">
                <h2 id="basketHeading"> Your Basket </h2>
                
<!--/////////////////////////////// BASKET TABLE ////////////////////////////-->
                <table id="basketTable">
                        <tr>
                            <th colspan="2">Product Name</th> <th>Quantity</th> <th>Price</th>
                        </tr>
                        <?php
                        $update = false;
                        $basket = $_SESSION["basket"];    

                        if (isset($_REQUEST["qtyUpdate"]))  // IF UPDATE CLICKED THEN GET UPDATE ID, QUANTITY VALUE
                        {
                            $idToUpdate = $_REQUEST["hidIdUpdate"];
                            $qtyToUpdate = $_REQUEST["qtyUpdate"];
                            $update = true;
                        }
                        
                        foreach ($basket as $key => $item)      // DISPLAY EVERYTHING IN BASKET
                        {
                            $id = $item["id"];
                            $remove = false;
                            if ($update && ($id == $idToUpdate))    // IF EXISTING ID MATCHES UPDATE ID
                            {
                                if ($qtyToUpdate == 0)      // IF UPDATE QUANTITY IS 0 THEN PLACE jQUERY TO REMOVE ITEM AND SET $REMOVE TRUE 
                                {
                                    echo "<script>
                                        $(function() 
                                        {
                                            var fade = $('#tr$id');
                                            fade.fadeOut();
                                        }) 
                                        </script>";
                                    $remove = true;
                                }
                                else
                                {
                                    $basket[$key]["qty"] = $qtyToUpdate;
                                }
                            }
                            $types = $item["types"];
                            $imgName = $item["imageName"]; 
                            $name = $item["name"];
                            $price = $item["price"];
                            $qty = $basket[$key]["qty"];
                            echo "<tr id='tr$id'>
                                    <td class='basketImg'> <img src='css/images/$types/$imgName' alt='image $imgName'/> </td>
                                    <td class='tableName'> $name </td>
                                    <td class='tableQty'> <form> <input type='hidden' name='hidIdUpdate' value='$id'/> <input type='text' name='qtyUpdate' value='$qty'/> <input type='submit' value='update'> </form></td>
                                    <td class='tablePrice'> &pound$price </td>
                                  </tr>";
                            if ($remove)
                            {
                                unset($basket[$key]);   // REMOVING ITEM FROM THE BASKET
                                $_SESSION["basket"] = array_values($basket);    // UPDATE SESSION BASKET
                                $nItems = sizeof($_SESSION["basket"]);
                                echo "  <script>
                                            $(function() 
                                            {
                                                $('#nItems').slideUp('slow', function() 
                                                {
                                                    $('#nItems').replaceWith('<span>$nItems</span>');
                                                });
                                            }); 
                                        </script>";
                            }
                        }
                        /////////////// END OF DISPLAYING BASKET DATA //////////

                        if($basket == null)     // IF BASKET IS EMPTY THEN REMOVE TABLE, DISPLAY MESSAGE
                        {
                            echo "<script>
                                    $(function() 
                                    {
                                        $('#basketHeading').append('<strong>Is Empty</strong>');
                                        $('#basketTable').remove();
                                    }) 
                                  </script>";
                        }
                        else
                        {
                            $total = 0;
                            foreach ($basket as $key => $item)      // DISPLAY TOTAL, VAT, SHIPPING
                            {
                                $price = $item["price"];
                                $qty = $item["qty"];
                                $total = $total + ($price * $qty);
                            }
                            $shippingCost = 50;
                            $vatRate = 0.2;
                            $vat = $vatRate * $total;
                            $grandTotal = $total + $shippingCost + $vat; 
                            echo "<tr>  <td><!-- 1 --></td>  <td><!-- 2 --></td>  <td>  Subtotal      </td>   <td>&pound;$total         </td>  </tr>";
                                 
                            echo "<tr>  <td><!-- 1 --></td>  <td><!-- 2 --></td>  <td>  Shipping Cost  </td>  <td>&pound;$shippingCost  </td>  </tr>";
                                    
                            echo "<tr>  <td><!-- 1 --></td>  <td><!-- 2 --></td>  <td>  VAT            </td>  <td>&pound;$vat           </td>  </tr>";
                                 
                            echo "<tr>  <td><!-- 1 --></td>  <td><!-- 2 --></td>  <td>  Grand Total    </td>  <td>&pound;$grandTotal    </td>  </tr>";
                        }
                        ?>
                    </table>
            </div>
<!--///////////////////////////////END OF BASKET TABLE DIV/////////////////////////-->
            
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





<!--                        <tr><td class='basketImg'>$id</td><td>$name</td><td class='tableQty'>$qty</td><td class='tablePrice'>&pound$price</td> </tr>-->

