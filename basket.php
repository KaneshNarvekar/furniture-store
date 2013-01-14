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
                   <a href="basket.php">my cart&nbsp;<?php $size = sizeof($_SESSION["basket"]); echo "$size"; ?>&nbsp;items</a>
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
//                            if($_SESSION["basket"] == null && !isset($_REQUEST["btnAddToBasket"])) // IF BASKET CONTAINS NOTHING DISPLAY EMPTY MESSAGE
//                            {
//                                echo "<script>
//                                            $(function() 
//                                            {
//                                                $('#basketHeading').append('<strong>Is Empty</strong>');
//                                                $('#basketTable').remove();
//                                            }) 
//                                      </script>";
//                            }
//                            else
//                            {
                                $basket = $_SESSION["basket"];    

                                if (isset($_REQUEST["qtyUpdate"]))
                                {
                                    $idToUpdate = $_REQUEST["hidIdUpdate"];
                                    $qtyToUpdate = $_REQUEST["qtyUpdate"];
                                    $update = true;
                                }
                                if (isset($_REQUEST["btnAddToBasket"]))
                                {
                                    $types = $_REQUEST["hidTypes"];
                                    $id = $_REQUEST["hidId"];
                                    $imgName = $_REQUEST["hidImgName"];
                                    $name = $_REQUEST["hidName"];
                                    $price = $_REQUEST["hidPrice"];
                                    $qty = $_REQUEST["txtQty"];
                                    $item = array("id"=>$id, "name"=>$name, "price"=>$price, "qty"=>$qty, "imageName"=>$imgName, "types"=>$types);

                                    if ($_SESSION["addToBasket"])
                                    {
                                    $itemFound = false;
                                    $size = sizeof($basket);
                                    $i = 0;
                                    while ($i < $size && !$itemFound)
                                    {
                                        $oldId = $basket[$i]["id"];
                                        if ($id == $oldId)
                                        {
                                            $oldQty = $basket[$i]["qty"];
                                            $basket[$i]["qty"] = $oldQty + $qty;
                                            $itemFound = true;
                                        }
                                        $i++;
                                    }
                                    if (!$itemFound)
                                    {
                                        $basket[] = $item;
                                    }    
                                    $_SESSION["addToBasket"] = false;

                                    }
                                }
                                $total = 0;
                                foreach ($basket as $key => $item)
                                {
                                    $id = $item["id"];
                                    $remove = false;
                                    if ($update && ($id == $idToUpdate))
                                    {
                                        if ($qtyToUpdate == 0)
                                        {
                                            echo "<script>
                                                $(function() 
                                                {
                                                    var fade = $('#tr$id');
                                                    fade.fadeOut();
                                                }
                                                ) 
                                                </script>";

                                            $remove = true;
                                        }
                                        else
                                        {
                                            $item["qty"] = $qtyToUpdate;
                                            $basket[$key]["qty"] = $item["qty"];
                                        }
                                    }
                                    $types = $item["types"];
                                    $imgName = $item["imageName"]; 
                                    $name = $item["name"];
                                    $price = $item["price"];
                                    $qty = $item["qty"];
                                    echo "<tr id='tr$id'>
                                            <td class='basketImg'> <img src='css/images/$types/$imgName' alt='image $imgName'/> </td>
                                            <td class='tableName'> $name </td>
                                            <td class='tableQty'> <form> <input type='hidden' name='hidIdUpdate' value='$id'/> <input type='text' name='qtyUpdate' value='$qty'/> <input type='submit' value='update'> </form></td>
                                            <td class='tablePrice'> &pound$price </td>
                                          </tr>";
                                    if ($remove)
                                    {
                                        unset($basket[$key]);
                                    }
                                }
                                $_SESSION["basket"] = array_values($basket);

                                if($_SESSION["basket"] == null)
                                {
                                    echo "<script>
//                                            $(function() 
//                                            {
//                                                $('#basketHeading').append('<strong>Is Empty</strong>');
//                                                $('#basketTable').remove();
//                                            }) 
//                                      </script>
                                          ASS HOLES";
                                    if ($basket == null)
                                    {
                                        echo "TRUE MOTHER FUCKER";
                                    }
                                }
                                else
                                {

                                foreach ($basket as $key => $item)
                                {
                                    $price = $item["price"];
                                    $qty = $item["qty"];
                                    $total = $total + ($price * $qty);
                                }
                                $shippingCost = 50;
                                $vatRate = 0.2;
                                $vat = $vatRate * $total;
                                $grandTotal = $total + $shippingCost + $vat; 
                                echo "<tr>
                                        <td></td>
                                        <td></td>
                                        <td>Subtotal</td>
                                        <td>$total</td>
                                     </tr>";
                                echo "<tr>
                                        <td></td>
                                        <td></td>
                                        <td>Shipping Cost</td>
                                        <td>&pound;$shippingCost</td>
                                     </tr>";
                                echo "<tr>
                                        <td></td>
                                        <td></td>
                                        <td>VAT</td>
                                        <td>$vat</td>
                                     </tr>";
                                echo "<tr>
                                        <td></td>
                                        <td></td>
                                        <td>Grand Total</td>
                                        <td>$grandTotal</td>
                                     </tr>";
                                }
//                            }
                        ?>
                    </table>
            </div>
<!--///////////////////////////////END OF BASKET DIV/////////////////////////-->
            
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

