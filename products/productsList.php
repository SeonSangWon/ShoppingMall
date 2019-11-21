<?php
$conn = mysqli_connect('localhost', 'coin', '0000', 'mcs');
if(!$conn)
{
	echo "DataBase Error";
	exit;
}
require("../xcoin_api_client.php");

$pCode = $_GET['pCode'];

$query = "SELECT * FROM product where category_code = '$pCode'";
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
<title>MegaCoinShop</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" type="text/css" href="../css/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    
<script src="../js/jquery-3.3.1.min.js"></script>

<style>
    a,.w3-sidebar {font-family: "Roboto", sans-serif}
    body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
    .stringHidden {white-space: nowrap; overflow: hidden; text-overflow: ellipsis;}
    .freeDelivery {background-color: darkgrey; color: white; font-size: 11px; font-family: "돋움", sans-serif; padding: 2px;}
</style>

<body class="w3-content" style="max-width:1500px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
    
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <a href="../index.php" style="text-decoration:none"><h3 class="w3-wide"><b>LOGO</b></h3></a>
  </div>
    
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
      
    <a href="#" class="w3-bar-item w3-button">패션의류/잡화</a>
      
    <a href="#" class="w3-bar-item w3-button">문구/오피스</a>
      
    <a onclick="myAccFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">식품</a>
      
    <div id="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium">
      <a onclick="menuClick(this.id)" href="productsList.php?pCode=B01" class="w3-bar-item w3-button" id="B01">과일</a>
      <a onclick="menuClick(this.id)" href="productsList.php?pCode=B02" class="w3-bar-item w3-button" id="B02">생수/음료</a>
      <a onclick="menuClick(this.id)" href="productsList.php?pCode=B03" class="w3-bar-item w3-button" id="B03">커피/원두/차</a>
      <a onclick="menuClick(this.id)" href="productsList.php?pCode=B04" class="w3-bar-item w3-button" id="B04">과자/간식</a>
      <a onclick="menuClick(this.id)" href="productsList.php?pCode=B05" class="w3-bar-item w3-button" id="B05">면/통조림/가공식품</a>
    </div>
      
    <a href="#" class="w3-bar-item w3-button">주방용품</a>
      
    <a href="#" class="w3-bar-item w3-button">생활용품</a>
      
  </div>
    
  <a href="#footer" class="w3-bar-item w3-button w3-padding">Contact</a> 
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding" onclick="document.getElementById('newsletter').style.display='block'">Newsletter</a> 
  <a href="#footer"  class="w3-bar-item w3-button w3-padding">Subscribe</a>
    
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-large" style='padding-left:15px; padding-right:15px;'>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-left" onclick="w3_open()"><i class="fa fa-bars"></i></a>
  <a href="../index.php" style="text-decoration:none"><div class="w3-bar-item w3-wide">LOGO</div></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:83px"></div>
  
  <!-- Top header -->
  <header class="w3-container w3-xlarge">
    <p class="w3-left" id="content_title"></p>
    <p class="w3-right">
      <i class="fa fa-shopping-cart w3-margin-right"></i>
      <i class="fa fa-search"></i>
    </p>
  </header>

  <!-- Product grid -->
  <div class="w3-row-padding">
      
          <?php while($row = mysqli_fetch_array($result)){
    
            $xrp_price = $row['product_price'] / $xrp_buy_price;
            $xrp_price = round($xrp_price, 6);
            $discount_price = floor($xrp_price) - 2;
    
            echo "<div class='w3-col l3 s6 w3-container' style='margin-bottom:15px;'>";
            echo "<div class='w3-container w3-border w3-hover-border-red' style='padding-right:0; padding-left:0; padding-top:0; background-color:#F9F9F9;'>";
            echo "<img src='../imgs/products/".$row['intro_img']."' style='width:100%'>";
            echo "<p class='stringHidden' style='padding-left:10px; padding-right:10px; margin-bottom:0px;'>".$row['product_name']."<br><br>";
            echo "<b class='w3-text-grey' style='font-size:11px;'>판매가 &nbsp".number_format($row['product_price'])." KRW</b><br>";
            echo "<b style='font-size:15px;'>시세가 &nbsp".$xrp_price." XRP</b><br>";
            echo "<b class='w3-text-red' style='font-size:15px;'>할인가</b> &nbsp<b class='w3-text-red' style='font-size:25px;'>".$discount_price."</b><b class='w3-text-red' style='font-size:15px;'> XRP ~</b></p>";
            echo "<hr style='margin:0;'>";
            echo "<p style='margin-top:3px; margin-bottom:3px; padding-left:10px;'><a class='freeDelivery'>".$row['delivery_if']."</a></p>";
            echo "</div>";
            echo "</div>";
            if(!$row) break;
            }
          ?>
      
  </div>

</div>

<!-- Newsletter Modal -->
<div id="newsletter" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
    <div class="w3-container w3-white w3-center">
      <i onclick="document.getElementById('newsletter').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
      <h2 class="w3-wide">NEWSLETTER</h2>
      <p>Join our mailing list to receive updates on new arrivals and special offers.</p>
      <p><input class="w3-input w3-border" type="text" placeholder="Enter e-mail"></p>
      <button type="button" class="w3-button w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('newsletter').style.display='none'">Subscribe</button>
    </div>
  </div>
</div>

<script>
function myAccFunc() {
    
    var menu_select_icon = document.createElement("i");
    menu_select_icon.className = "w3-margin-left fa fa-caret-down";
    
    var x = document.getElementById("demoAcc");
    var y = document.getElementById("myBtn");
    
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        y.append(menu_select_icon);
    } else {
        x.className = x.className.replace(" w3-show", "");
        $('i.fa-caret-down').remove();
    }
}

document.getElementById("myBtn").click();
    
// 상세 메뉴 및 타이틀
var x = document.getElementById("<?php echo $pCode ?>");
var title =x.innerHTML;
var menu_select_icon = document.createElement("i");
menu_select_icon.className = "fa fa-caret-right w3-margin-right";    
    
if(x.className.indexOf("w3-light-grey") == -1){
        
    for(i=1; i<6; i++){
        var rm = document.getElementById("B0"+i);
        rm.className = x.className.replace(" w3-light-grey", "");
        $('i.fa-caret-right').remove();
    }
        
    x.className += " w3-light-grey";
    x.prepend(menu_select_icon);
    document.getElementById('content_title').innerHTML = title;
}

// Open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>