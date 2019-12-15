<?php
require("connect.php");
require("xcoin_api_client.php");

session_start();

//관리자 접속
if($_SESSION['admin'])
{
    echo "
        <script>
            location.href='admin/index.php';
        </script>
    ";
}
    
$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);

// ======== API 연동 ========
$api = new XCoinAPI("api connect key", "api secret key");

//{currency} = 빗썸 거래 가능 코인, ALL(전체), 기본값 BTC
$rgParams['order_currency'] = 'all';
$rgParams['payment_currency'] = 'all';

//19.08.26(월)
//OpenAPI 변경
$xrp_public = $api->xcoinApiCall("/public/orderbook/XRP", $rgParams);

//19.08.26(월)
//리플 시세가 → 가장 최근에 거래된 기록(0번 째 index)
//정확한 구매가는 아닌듯 함... +-0 ~ 5원정도의 차액 발생
$xrp_buy_price = $xrp_public->data->bids[0]->price;
?>
<!DOCTYPE html>
<html>
<head>
<title>MegaCoinShop</title>
</head>
<style>
</style>
<body>
<!-- top.php 파일 Include -->
<?php
  include "top.php";
?>  
<!-- 배너 -->
<header class="w3-display-container" style="max-width:2000px;">
    <br><br>
    <div class="mySlides w3-display-container w3-center">
        <img class="w3-image" src="imgs/banners/banner_first.jpg" style="width:100%;">
        <div class="w3-display-bottomleft w3-margin-bottom w3-center">
            <h1 class="w3-xxlarge w3-text-white">
                <span class="w3-padding w3-yellow w3-opacity-min w3-hide-small">
                    <b>Welcome to MegaCoinShop!</b>
                </span>
            </h1>
        </div>
    </div>
        
    <div class="mySlides w3-display-container w3-center">
        <img class="w3-image" src="imgs/banners/banner_second.jpg" style="width:100%;">
    </div>
        
    <div class="mySlides w3-display-container w3-center">
        <img class="w3-image" src="imgs/banners/banner_third.jpg" style="width:100%;">
    </div>
</header>

<!-- 내용 시작 -->
<div class="w3-content" style="max-width:1500px;">
        
    <!-- 인기상품 항목 -->
    <div class="w3-container" style="padding-top:0px; padding-bottom:8px">
        <div class="w3-hide-small" style="padding-top:48px;">
        </div>
        <h3 class="w3-border-bottom w3-border-light-grey w3-padding-8" style="padding-top:0;">
            인기상품
        </h3>
    </div>
        
    <div class="w3-row-padding">
    <?php
        while($row = mysqli_fetch_array($result))
        {
            $xrp_price = $row['product_price'] / $xrp_buy_price;
            $xrp_price = round($xrp_price, 6);
            $discount_price = floor($xrp_price) - 2;
    
            echo "<div class='w3-col l2 s6 w3-container' style='margin-bottom:15px;'>";
            echo "<div class='w3-display-container w3-border w3-hover-border-red' style='padding-right:0; padding-left:0; padding-top:0; background-color:#F9F9F9;'>";
            echo "<a href='products/productDetail.php?pNum=".$row['product_num']."' style='text-decoration:none'>";
                    
            echo "<div class='w3-display-topleft w3-red w3-text-white w3-padding'>BEST</div>";
    
            echo "<img src='imgs/products/".$row['intro_img']."' style='width:100%'><br><br>";
            echo "<p class='stringHidden' style='padding-left:10px; padding-right:10px; margin-bottom:0px; font-size:15px;'><b>".$row['product_name']."</b><br><br>";
            echo "<b class='w3-text-grey' style='font-size:12px;'>판매가 &nbsp".number_format($row['product_price'])." KRW</b><br>";
            echo "<b style='font-size:15px;'>시세가 &nbsp".$xrp_price." XRP</b><br>";
            echo "<b class='w3-text-red' style='font-size:15px;'>할인가</b> &nbsp";
            echo "<b class='w3-text-red' style='font-size:25px;'>".$discount_price."</b><b class='w3-text-red' style='font-size:15px;'> XRP ~</b></p>";
            echo "<hr style='margin:0;'>";
            echo "<p style='margin-top:3px; margin-bottom:7px; padding-left:10px;'><a class='optionFont'>".$row['delivery_if']."</a></p>";
                    
            echo"</a>";
            echo "</div>";
            echo "</div>";
                    
            if(!$row) break;
        }
            
    ?>
    </div>
</div>
<!-- 내용 끝 -->
    
<!-- 하단 -->
<footer class="w3-center w3-black w3-padding-16 w3-margin-top">
    <p>Contacted by
        <a href="index.php" title="www.megacoinshop.com" target="_blank" class="w3-hover-text-green" style="text-decoration:none">
            www.MegaCoinShop.com
        </a>
    </p>
</footer>
<script>
    // 카테고리 항목 → 하위 항목 호버효과로 펼쳐 줌
    $('#myAccFunc').hover(function() {
        var menu_select_icon = document.createElement("i");
        menu_select_icon.className = "w3-margin-left fa fa-caret-down";
            
        var x = document.getElementById("demoAcc");
        var y = document.getElementById("myBtn");
            
        if (x.className.indexOf("w3-show") == -1)
        {
            x.className += " w3-show";
            y.append(menu_select_icon);
        } 
        else 
        {
            x.className = x.className.replace(" w3-show", "");
            $('i.fa-caret-down').remove();
        }
    });
            
    // 상단바에 있는 카데고리 펼쳐주는 효과
    function show_category() {
        var x = document.getElementById("category");
            
        if (x.className.indexOf("w3-show") == -1)
        {
            x.className += " w3-show";
                
        }
        else
        {
            x.className = x.className.replace(" w3-show", "");
        }
    }

    //document.getElementById("myBtn").click(); 
    // 안씀, 그러나 필요할 수도 있음
    
    // 배너 슬라이드 효과 - 3.5초 간격
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
            
        for (i = 0; i < x.length; i++) 
        {
            x[i].style.display = "none";
        }
        myIndex++;
            
        if (myIndex > x.length)
        {
            myIndex = 1
        }
            
        x[myIndex-1].style.display = "block";
        setTimeout(carousel, 3500);
    }
</script>
</body>
</html>
