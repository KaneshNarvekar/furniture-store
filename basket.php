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
        <script src="javascript/validation.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            
            //////// USING RAY'S JAVASCRIPT VALIDATION ///////
            function btnUpdate()
            {
                var frmUpdate = document.getElementById("frmUpdate");
                var qty = frmUpdate.qtyUpdate.value;

                if (isEmpty(qty))
                {
                    alert("Please enter quantity!");
                    return false;
                }

                if (!isInteger(qty))
                {
                    alert("Please enter whole number!");
                    return false;
                }

                if (qty < 0)
                {
                    alert("Please enter positive number!")
                    return false;
                }
            }
        </script>
    </head>
    
    <body>
        <div id="container">
            <div id="headerDiv">
<!--/////////////////////////// WELCOME USER ////////////////////////////////-->  
                <form id='frmLogout' method="post">
                <?php
                if (isset($_POST["btnLogout"]))
                {
                    unset($_SESSION["customer"]);
                }
                if (isset($_SESSION["customer"]))
                {
                    $custName = $_SESSION["customer"]["name"];
                    $custEmail = $_SESSION["customer"]["email"];
                    echo "<span id='custName'>
                                Welcome,&nbsp;<a id='aCustName' href='account.php?custEmail=$custEmail'>$custName</a>
                                &nbsp;&nbsp;&nbsp;
                                <input type='submit' name='btnLogout' value='(Logout)'/>
                          </span>";
                    echo "  <script> 
                                $(function() 
                                    {
                                        $('#login').remove();
                                    })
                            </script>";
                }
                ?>
                </form>
<!--///////////////////////// END OF WELCOME USER ///////////////////////////--> 
                <p>
                   <a id="login" href="login.php">login</a>
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
                <h3 id="basketHeading"> Shopping Basket </h3>
                
<!--/////////////////////////////// BASKET TABLE ////////////////////////////-->
                <table id="basketTable">
                        <tr>
                            <th id="thProdName" colspan="2">Product Name</th> <th>Price</th> <th>Quantity</th> <th id="thLineTotal">&nbsp;&nbsp;Line Total</th> 
                        </tr>
                        <tr><td class='tdFirstThinLine' colspan='5'> </td></tr>
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
                            $cost = $qty * $price;
                            echo "<tr id='tr$id'>
                                    <td class='tdProdImg'> <img src='css/images/$types/$imgName' width='50' height='52' alt='image $imgName'/> </td>
                                    <td class='tdName'> <p>$name</p> </td>
                                    <td class='tdPrice'> &pound$price </td>
                                    <td class='tdQty'> <form id='frmUpdate'> <input type='hidden' name='hidIdUpdate' value='$id'/> <input type='text' name='qtyUpdate' value='$qty'/> <input type='submit' value='update' onclick='return btnUpdate();'/> </form></td>
                                    <td class='tdLineTotal'>&nbsp;&nbsp;&pound$cost </td>
                                  </tr>
                                  <tr><td class='tdThinLine' colspan='5'> </td></tr>";
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
                                        $('#basketHeading').after('<h5>You have no items in your basket.</h5>');
                                        $('#basketTable').remove();
                                        $('#aCheckout').remove();
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
                            define("VATRATE", 0.2);
                            $vat = VATRATE * $total;
                            $grandTotal = $total + $shippingCost + $vat;
                            echo "<tr class='trEmptySpace'><td colspan='5'></td></tr> ";
                            echo "<tr>  <td colspan='2'></td>  <td class='tdEnd' colspan='2'>  Subtotal:       </td>  <td class='tdEndData'>&nbsp;&nbsp;&pound;$total         </td>  </tr>";
                                 
                            echo "<tr>  <td colspan='2'></td>  <td class='tdEnd' colspan='2'>  Shipping Cost:  </td>  <td class='tdEndData'>&nbsp;&nbsp;&pound;$shippingCost  </td>  </tr>";
                                    
                            echo "<tr>  <td colspan='2'></td>  <td class='tdEnd' colspan='2'>  VAT:            </td>  <td class='tdEndData'>&nbsp;&nbsp;&pound;$vat           </td>  </tr>";
                                 
                            echo "<tr>  <td colspan='2'></td>  <td class='tdGrandTotal' colspan='2'>  Grand Total:    </td>  <td class='tdGrandTotalData'>&nbsp;&nbsp;&pound;$grandTotal    </td>  </tr>";
                        }
                        ?>
                    </table>
                    <div id="checkOutDiv">
                        <a id="aContinueShop" href="index.php">Continue shopping</a>
                        <a id="aCheckout" href="checkout.php">Proceed to checkout</a>
                    </div>
                    <div id="basketThickLine">
                        
                    </div>
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

