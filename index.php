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
        <title>Furniture & House Decoration &#124; DAVA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link href="css/home.css" rel="stylesheet" type="text/css"/>
<!--///////////////////////////////END OF STYLE SHEET ///////////////////////--> 

        <script src="javascript/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="javascript/jquery.cycle.all.js" type="text/javascript"></script>
        <script src="javascript/jquery.easing.1.3.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            $(document).ready(
            function()
            {
                $('#imgSlides').cycle(
                {
                    fx:     'fade',
                    speed: 800,
                    timeout: 3000,
                    pager:  '#ulThumbs',
                    pagerAnchorBuilder: function(idx, slide) 
                    {
                        // return sel string for existing anchor
                        return '#ulThumbs li:eq(' + (idx) + ') a';
                    }
                });
                
                $('#featuredSlides').cycle(
                {
                    fx:     'scrollHorz',
                    timeout: 0,
                    next: '#right',
                    prev: '#left',
                    nowrap: 0
                });
            })
            
//            $(function() 
//            {
//                $('#fade').fadeOut().remove();
//            });
        </script>
    </head>
<!--///////////////////////////////END OF HEAD///////////////////////////////-->    

    <body>
        <div id="containerDiv">
            <div id="headerDiv">
                <p>
                    <a href="login.php">login</a>
                    &#124;
                    <a href="login.php">my account</a>
                    &#124;
                    <a id="cart" href="basket.php">my cart&nbsp;<?php $size = sizeof($_SESSION["basket"]); echo "$size"; ?>&nbsp;items</a>
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
        <div id="fade">
            <span id="dava">asdfdsdfsdfsd</span> 
        </div>
<!--///////////////////////////////END OF NAVIGATION/////////////////////////-->

        <div id="indexBoxDiv1">
            <div id="imgSlides">
                <img class="imgFirst" src="css/images/imgCenter1W650xH366.jpg" width="650" height="366" alt="centerImage"/>
                <img class="imgOthers" src="css/images/imgCenter2W650xH366.jpg" width="650" height="366" alt="centerImage"/>
                <img class="imgOthers" src="css/images/imgCenter3W650xH366.jpg" width="650" height="366" alt="centerImage"/>
                <img class="imgOthers" src="css/images/imgCenter4W650xH366.jpg" width="650" height="366" alt="centerImage"/>
                <img class="imgOthers" src="css/images/imgCenter5W650xH366.jpg" width="650" height="366" alt="centerImage"/>
            </div>

            <ul id="ulThumbs">
                <li><a href="#"><img src="css/images/imgThumb1W116xH65.jpg" width="116" height="65" alt="thumbImage"/></a></li>
                <li><a class="middleThumb" href="#"><img src="css/images/imgThumb2W116xH65.jpg" width="116" height="65" alt="thumbImage"/></a></li>
                <li><a class="middleThumb" href="#"><img src="css/images/imgThumb3W116xH65.jpg" width="116" height="65" alt="thumbImage"/></a></li>
                <li><a class="middleThumb" href="#"><img src="css/images/imgThumb4W116xH65.jpg" width="116" height="65" alt="thumbImage"/></a></li>
                <li><a href="#"><img src="css/images/imgThumb5W116xH65.jpg" width="116" height="65" alt="thumbImage"/></a></li>
            </ul>
        </div>
<!--///////////////////////////////END OF BOX DIV 1  /////////////////////////-->
         
        <div id="indexBoxDiv2">
            <div id="content1"><!--World Class Service--></div> 
            <div id="content2">
                <div id="prodNavBG">
                    <ul id="prodNav">
                        <li><a id="right" href=""></a></li>
                        <li><h6>FEATURED PRODUCTS </h6></li> 
                        <li><a id="left" href=""></a></li>
                    </ul>
                </div>

                <div id="featuredSlides">
                    <div class="slide">
                        <a href="prodInfo.php?prodId=bed04&amp;type=bed"> <img src="css/images/beds/bed4.jpg" width="158" height="158" alt="centerImage"/> </a>
                        <a href="prodInfo.php?prodId=bed08&amp;type=bed"> <img src="css/images/beds/bed8.jpg" width="158" height="158" alt="centerImage"/> </a>
                        <a href="prodInfo.php?prodId=bed03&amp;type=bed"> <img src="css/images/beds/bed3.jpg" width="158" height="158" alt="centerImage"/> </a>
                    </div>
                    
                    <div class="slide">
                        <a href="prodInfo.php?prodId=chair01&amp;type=chair">  <img src="css/images/chairs/chair1.jpg" width="158" height="158" alt="centerImage"/> </a>
                        <a href="prodInfo.php?prodId=chair02&amp;type=chair">  <img src="css/images/chairs/chair2.jpg" width="158" height="158" alt="centerImage"/> </a>
                        <a href="prodInfo.php?prodId=chair03&amp;type=chair">  <img src="css/images/chairs/chair3.jpg" width="158" height="158" alt="centerImage"/> </a>
                    </div>
                </div> 
            </div>

        </div> 
<!--///////////////////////////////END OF BOX DIV 2  /////////////////////////-->

        <div id="indexBoxDiv3">
            <h4>  <span class="orange"> DAVA&reg;</span> House Furniture and Decoration</h4>
            <p>   
                We are one of the most successful retailers of luxury house furniture in the UK. Our shop has established in 1989 and now 
                is a leading retailer of house and office furniture and decoration. Our online shop has large selection of beds, chairs, 
                and, storage cabinets. For those, who want to create most relaxing atmosphere and peace of mind in their homes, DAVA house furniture shop
                is the perfect place to start. We have over 80 branches all over the world and still we strive to offer best possible customer satisfaction 
                with unrivalled choice of products and peace of mind. Our sales teams are known for their highly reliable support and commitment.
            </p>
        </div>

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
