<?php
require("../connect.php");
require("../xcoin_api_client.php");

session_start();

//구매자정보 불러오기
$id = $_SESSION['user_id'];
$memberSql = "SELECT * FROM member WHERE id='$id'";
$memberResult = mysqli_query($conn, $memberSql);
$memberRow = mysqli_fetch_array($memberResult);
$name = $memberRow['name'];
$postcode = $memberRow['postcode'];
$address = $memberRow['address'];
$phone = $memberRow['phone'];
//전화번호 분리
$num1 = substr($phone,0,3);
$num2 = substr($phone,3,4);
$num3 = substr($phone,7);
// 000-0000-0000
$phone = $num1 . "-" . $num2 . "-" . $num3;

$pNum = $_GET['pNum'];
$query = "SELECT * FROM product WHERE product_num='$pNum'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

//상품수량
$amount = 1;

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
    
    <link rel="stylesheet" type="text/css" href="../css/product_detail_page.css">
    <link rel="stylesheet" type="text/css" href="../css/w3.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nanum+Gothic&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Archivo+Black&display=swap">
    
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/app.js" async></script>
    
    <style>
        h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
        body,a {font-family: 'Nanum Gothic', sans-serif;}
        
        .menuFont {font-family: 'Nanum Gothic', sans-serif; font-size: 13px;}
        .dynamicFont {font-family: 'Permanent Marker', cursive;}
        .priceFont {font-family: 'Archivo Black', sans-serif; font-size: 35px;}
        .optionFont {background-color: darkgrey; color: white; font-size: 11px; font-family: "돋움", sans-serif; padding: 2px;}
        
        .stringHidden {white-space: nowrap; overflow: hidden; text-overflow: ellipsis;}
        
        .btn-minus{cursor:pointer;font-size:7px;display:flex;align-items:center;padding:5px;padding-left:10px;padding-right:10px;border:1px solid gray;border-radius:2px;border-right:0;}
        .btn-plus{cursor:pointer;font-size:7px;display:flex;align-items:center;padding:5px;padding-left:10px;padding-right:10px;border:1px solid gray;border-radius:2px;border-left:0;}
        
        .section{width:100%;margin-left:-15px;padding:2px;padding-left:15px;padding-right:15px;}
        
        .nav-container {
        position: fixed;
        top: 0; /*상단 위치를 0으로 함으로서 위에 붙음*/
        }
        
        div.section > div {width:100%;display:inline-flex;}
        div.section > div > input {margin:0;padding-left:5px;font-size:10px;padding-right:5px;max-width:18%;text-align:center;}
    
        .fontStyle{
            font-size: 13px;
            color: black;
            margin-left: 10px;
        }
    </style>
    
    <body>
        <!-- 상단바 -->
        <div class="w3-top">
            <!-- 상단바 왼쪽 메뉴 -->
            <div class="w3-bar w3-white w3-card w3-large" style='padding-left:15px; padding-right:15px;'>
                <div class="w3-dropdown-click w3-left">
                    <a onclick="show_category()" class="w3-button"><i class="fa fa-bars"></i></a>
                    
                    <div class="w3-dropdown-content w3-bar-block w3-card-category w3-border" style="width:250px; padding-bottom:10px; padding-top:10px;" id="category">
                        <a class="w3-bar-item w3-button">패션의류/잡화</a>
                        <a class="w3-bar-item w3-button">문구/오피스</a>

                        <div id="myAccFunc">
                            <a class="w3-bar-item w3-button" id="myBtn">식품</a>
                            <div id="demoAcc" class="w3-bar-block w3-hide w3-padding w3-medium">
                                <a href="../products/productsList.php?pCode=B01" class="w3-bar-item w3-button">과일</a>
                                <a href="../products/productsList.php?pCode=B02" class="w3-bar-item w3-button">생수/음료</a>
                                <a href="../products/productsList.php?pCode=B03" class="w3-bar-item w3-button">커피/원두/차</a>
                                <a href="../products/productsList.php?pCode=B04" class="w3-bar-item w3-button">과자/간식</a>
                                <a href="../products/productsList.php?pCode=B05" class="w3-bar-item w3-button">면/통조림/가공식품</a>
                            </div>
                        </div>

                        <a class="w3-bar-item w3-button">주방용품</a>
                        <a class="w3-bar-item w3-button">생활용품</a>

                        <div class="w3-hide-large w3-hide-medium w3-small">
                            <p style='margin-left:10px; margin-right:10px;' class="w3-border-bottom w3-border-light-grey"></p>
                            <a href="#" class="w3-bar-item w3-button">로그인</a>
                            <a href="#" class="w3-bar-item w3-button">회원가입</a>
                            <a href="#" class="w3-bar-item w3-button">고객센터</a>
                            <a href="#" class="w3-bar-item w3-button">장바구니</a>
                            <a href="#" class="w3-bar-item w3-button">검색</a>
                        </div>
                    </div>
                </div>

                <a href="../index.php" class="w3-wide w3-bar-item" style="text-decoration:none;"><b>LOGO</b></a>

                <!-- 상단바 오른쪽 메뉴, 사이즈 작아지면 사라짐 -->
                <div class="w3-right w3-hide-small" style="margin-bottom:-1px;">
                    <?php 
                        if(!$_SESSION['user_session']) //php.ini 파일에서 "error_reporting = E_ALL & ~E_NOTICE"로 수정 필요!
                            echo "<a onclick=\"document.getElementById('login_modal').style.display='block'\" class='w3-button w3-padding-large menuFont'>로그인</a>";
                        else
                            echo "<a href='../members/logoutCheck.php' class='w3-button w3-padding-large menuFont' style='text-decoration:none'>로그아웃</a>";
                    ?>
                    
                    <?php 
                        if(!$_SESSION['user_session']) //php.ini 파일에서 "error_reporting = E_ALL & ~E_NOTICE"로 수정 필요!
                            echo "<a class='w3-button w3-padding-large menuFont'>회원가입</a>";
                        else
                            echo "<a class='w3-button w3-padding-large menuFont' href='../order/orderList.php'>주문정보</a>";
                    ?>
                    
                    <a class="w3-button w3-padding-large menuFont">고객센터</a>
                    <a class="w3-button" style="padding-top:8px; padding-bottom:9px;"><i class="fa fa-shopping-cart"></i></a>
                    <a class="w3-button" style="padding-top:8px; padding-bottom:9px;"><i class="fa fa-search"></i></a>
                </div>

            </div>
        </div>
        
        <?php
        $xrp_price = $row['product_price'] / $xrp_buy_price;
        $xrp_price = round($xrp_price, 6);
        $discount_price = floor($xrp_price) - 2;
        
        $discount_pecent = round((($xrp_price - $discount_price) / $xrp_price) * 100);
        
        $fee = rand(1000,9999) * 0.00001;
        $last_price = $discount_price + $fee;
        ?>
        <script>
            var text = <?php echo $id; ?>;
            alert(text);
        </script>
        <!-- 상품 상세페이지 -->
        <div class="container" style="margin-top:80px">
            <div class="container-fliud" style="margin-left:-15px">
                <div class="wrapper">
                    <div class="preview col-md-5">
                        <div class="preview-pic tab-content">
                          <div class="tab-pane active"><img src="../imgs/products/<?php echo $row['intro_img'] ?>" /></div>
                        </div>
                    </div>
                    <div class="details col-md-7" style="margin-left:15px; margin-top:-15px">
                        <h3 class="pd-product-title"><?php echo $row['product_name'] ?></h3>
                        <div class="pd-rating">
                            <div>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <span>41 reviews</span>
                        </div>
                        <br>
                        <h4 class="price" style="margin-bottom:-5px;">
                            <a style="font-weight:nomal;">원화 판매가&nbsp;</a>
                            <?php echo number_format($row['product_price']) ?> KRW
                        </h4>
                        <h4 class="price">
                            <a>리플 할인가&nbsp;</a>
                            <del style="color:darkgrey;"><?php echo $xrp_price; ?> XRP</del>&nbsp;
                            <span class="priceFont"><?php echo $discount_price; ?> XRP</span>
                            <strong>(<?php echo $discount_pecent; ?>% ↓)</strong>
                        </h4>
                        <h5 class="sizes">
                            <?php
                            if($row['delivery_if'] == '무료배송'){
                                echo $row['delivery_if'];
                            }
                            else{
                                echo "<a>배송비 &nbsp".number_format($row['delivery_price'])."원 (".number_format($row['delivery_price_max'])."원 이상 무료배송)</a>";
                            }
                            ?>
                        </h5>
                        <div class="section" style="padding-bottom:20px;">
                            <div style="height:30px;">
                                <div class="btn-minus" style="font-size:13px"><span class="fa fa-minus"></span></div>
                                <input style="width:50px; font-size:15px; font-weight:bold;" value="1" />
                                <div class="btn-plus" style="font-size:13px"><span class="fa fa-plus"></span></div>
<!--                                <a>&nbsp; 남은 수량 : 30 개</a>-->
                            </div>
                        </div>
                        <h4 class="price" id="">
                            <a>최종 구매가&nbsp;</a>
                            <a name="LastPrice"><?php echo $last_price; ?></a> XRP
                        </h4>
                        <font size = "2" color = "red">
                        ※입금 금액은 '최종 구매가'에 기재된 금액만큼 정확하게 입금하셔야 합니다.<br>
                        ※익명성 거래에서의 고객 구별을 위해 0.1 XRP 미만의 수수료가 난수로 발생합니다.
                        </font>
						<form name="AjaxForm" id="AjaxForm">
                        <div class="action"><br>
                            <?php
                                if($_SESSION['user_session'])
                                {
                            ?>
                            <button class="add-to-cart btn btn-default" type="button" onclick="document.getElementById('buy_modal').style.display='block'">
                                구매하기
                            </button>
                            <?php     
                                }
                            ?>
                            <?php
                                if(! $_SESSION['user_session'])
                                {
                            ?>
                            <button class="add-to-cart btn btn-default" type="button" onclick="document.getElementById('login_modal').style.display='block'">
                                구매하기
                            </button>
                            <?php
                                }
                            ?>
							<button class="like btn btn-default" type="button" onclick="AjaxCall()"><span class="fa fa-shopping-cart"></span></button>
                        </div>
						</form>
                    </div>
                </div>
            </div>
            
            <div class="detail_tab_floatable" style="margin-top:30px">
                <ul class="tab_floatable" style="margin-bottom:0px">
                    <li class="item"><a class="link" aria-selected="true" href="#dts">상세정보</a></li>
                    <li class="item"><a class="link" aria-selected="false" href="#revw">리뷰</a></li>
                    <li class="item"><a class="link" aria-selected="false" href="#qanda">Q&amp;A</a></li>
                    <li class="item"><a class="link" aria-selected="false" href="#clm">반품/교환정보</a></li>
                </ul>
            </div>

            <div class="w3-center">
                <img src="../imgs/products/<?php echo $row['main_img'] ?>" />
            </div>
            
            <br>
            
        <!-- 내용 끝 -->
        </div>
        
        <!-- 구매하기 모달 -->
        <div id="buy_modal" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-top" style="max-width:500px">
                <div class="w3-center">
                    <br>
                    <span onclick="document.getElementById('buy_modal').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Close Modal">×</span>
                    <h1 class="dynamicFont" style="font-size:50px;"><b>Order</b></h1>
                </div>

                <form class="w3-container" id="frm" action="../order/orderAction.php" method="post" autocomplete="off">
                    <div class="form-group">
                        <label>수령인</label><br>
                        <span class="fontStyle">
                            <?php echo $name . "(" . $name . ")"; ?> <br>
                        </span>
                    </div>
                
                    <div class="form-group">
                        <label>전화번호</label><br>
                        <span class="fontStyle">
                            <?php echo $phone ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label>주소</label><br>
                        <span class="fontStyle">
                            <?php echo "(" . $postcode . ")<br>"; ?>
                        </span>
                        <span class="fontStyle">
                            <?php echo $address; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label>배송 요청사항</label>
                        <select name="memo" id="memo" class="form-control">
                            <option value="">요청사항을 선택해주세요.</option>
                            <option value="배송 전에 미리 연락 바랍니다.">배송 전에 미리 연락 바랍니다.</option>
                            <option value="부재시 경비실에 맡겨 주세요.">부재시 경비실에 맡겨 주세요.</option>
                            <option value="부재시 전화 주시거나 문자 남겨 주세요.">부재시 전화 주시거나 문자 남겨 주세요.</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <span style="color: green; font-size: 10px;">
                            도서산간 지역의 경우 추후 수령 시 추가 배송비가 과금될 수 있습니다.
                            <br>
                            <hr>
                        </span>
                    </div>
                    
                    <!-- 상품 정보 -->
                    <div class="form-group">
                        <label>상품명</label><br>
                        <span class="fontStyle">
                            <?php echo $row['product_name']; ?>
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label>상품수량</label><br>
                        <span class="fontStyle">
                            <a name="buy_amount"><?php echo $amount; ?></a>
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label>입금할 코인</label><br>
                        <span class="fontStyle">
                            <a name="buy_modal_last_price"><?php echo $last_price; ?></a> XRP
                        </span>
                        <br>
                        <hr>
                    </div>
                    
                    <!-- 지갑정보 -->
                    <div class="form-group" align="center">
                         <img src="../imgs/qr.jpg" width="150" height="150"><br>
                    </div>
                    
                    <div class="form-group">
                        <label>지갑주소</label><br>
                        <span class="fontStyle">
                            rDxfhNRgCDNDckm45zT5ayhKDC4Ljm7UoP
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label>데스티네이션 태그(Destination Tag)</label><br>
                        <span class="fontStyle">
                            1004588726
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <span style="color: red; font-size: 10px;">
                            금액을 정확히 입력해주세요. 다를 경우 상품 출고가 늦어질 수 있습니다.!<br>
                        </span>
                    </div>
                    
                    <!-- 넘겨질 값 -->
                    <!-- ID -->
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <!-- Product_num -->
                    <input type="hidden" name="product_num" value="<?php echo $pNum; ?>" />
                    <!-- Amount -->
                    <input type="hidden" name="amount" id="amount" value="" />
                    <!-- Price -->
                    <input type="hidden" name="price" id="price" value="" />
                    <!-- Name -->
                    <input type="hidden" name="name" value="<?php echo $name; ?>" />
                    <!-- Phone -->
                    <input type="hidden" name="phone" value="<?php echo $memberRow['phone']; ?>" />
                    <!-- Postcode -->
                    <input type="hidden" name="postcode" value="<?php echo $postcode; ?>" />
                    <!-- Address -->
                    <input type="hidden" name="address" value="<?php echo $address; ?>" />
                    <!-- Memo -->
                    <!--금액 소수점 -->
                    <input type="hidden" name="rand" id="rand" value="" />
                    
                    <button class="w3-button w3-block w3-blue w3-section w3-padding" onclick="goOrder();">입금완료</button>
                </form>
            </div>
        </div>
        
        <!-- 로그인 모달 -->
        <div id="login_modal" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                <div class="w3-center">
                    <br>
                    <span onclick="document.getElementById('login_modal').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Close Modal">×</span>
                    <h1 class="dynamicFont" style="font-size:50px;"><b>Mega Coin Shop</b></h1>
                </div>

                <form class="w3-container" action="../members/loginCheck.php" method="post" name="login_form" id="login_form" autocomplete="off">
                    <div class="w3-section">
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="아이디를 입력해주세요." name="usrid" required>
                        <input class="w3-input w3-border" type="password" placeholder="비밀번호를 입력해주세요." name="password" required>
                        
                        <div id="display_error" style="color:red;"></div>
                        
                        <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">로그인</button>
           
                    </div>
                </form>

                <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                    <button onclick="document.getElementById('login_modal').style.display='none'" type="button" class="w3-button w3-red">취소</button>
                    
                </div>
            </div>
        </div>
        
        <!-- 하단 -->
        <footer class="w3-center w3-black w3-padding-16 w3-margin-top">
            <p>Contacted by <a href="../index.php" title="www.megacoinshop.com" target="_blank" class="w3-hover-text-green" style="text-decoration:none">www.MegaCoinShop.com</a></p>
        </footer>

        <script>
            var amount = 1;

            
            function goOrder(){
                
                //원래 금액 : 31.01234
                var origin_price = <?php echo $last_price; ?>;
                //정수 : 31
                var price = parseInt(origin_price);
                //31.01234 - 31
                origin_price = parseFloat(origin_price).toFixed(5) - price;
                //= 0.01234
                origin_price = parseFloat(origin_price).toFixed(5);
            
                //수량과 곱해질 정수값
                //최종 금액 : 정수값 + 소수점
                var last_price = price * amount;
                
                document.getElementById('amount').value = amount;
                document.getElementById('price').value = last_price;
                document.getElementById('rand').value = origin_price;
                
                document.getElementById('frm').submit();
            }
            
            // 카테고리 항목 → 하위 항목 호버효과로 펼쳐 줌
            $('#myAccFunc').hover(function() {
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
            });
            
            // 상단바에 있는 카데고리 펼쳐주는 효과
            function show_category() {
                var x = document.getElementById("category");
            
                if (x.className.indexOf("w3-show") == -1) {
                    x.className += " w3-show";
                } else {
                    x.className = x.className.replace(" w3-show", "");
                }
            }
            
            // 수량
            $(".btn-minus").on("click",function(){
                var now = $(".section > div > input").val();
                var price = "<?php echo $discount_price; ?>";
                var fee = "<?php echo $fee; ?>";
                if ($.isNumeric(now)){
                    if (parseInt(now) -1 > 0){ now--;}
                    $(".section > div > input").val(now);
                    amount = parseInt(now)-1;
                }else{
                    $(".section > div > input").val("1");
                }
                var after = $(".section > div > input").val();
                var modify_price = (price*after)+parseFloat(fee);
                var amount = now;
                $("a[name=LastPrice]").text(modify_price);
                $("a[name=buy_modal_last_price]").text(modify_price);
                $("a[name=buy_amount]").text(amount);
            })
            
            $(".btn-plus").on("click",function(){
                var now = $(".section > div > input").val();
                var price = "<?php echo $discount_price; ?>";
                var fee = "<?php echo $fee; ?>";
                if ($.isNumeric(now)){
                    if (parseInt(now) +1 < 1000) {
                        $(".section > div > input").val(parseInt(now)+1);
                        amount = parseInt(now)+1;
                    }
                    else {
                        $(".section > div > input").val("1");
                    }
                }else{
                    $(".section > div > input").val("1");
                }
                var after = $(".section > div > input").val();
                var modify_price = (price*after)+parseFloat(fee);
                $("a[name=LastPrice]").text(modify_price);
                $("a[name=buy_modal_last_price]").text(modify_price);
                $("a[name=buy_amount]").text(amount);
            })
        </script>
		
		<script type="text/javascript">
			function Basket(){
			
				//전달할 데이터 값
				var sendData = {name:"선상원", age:24};
		
				return sendData;
			}
			
			function AjaxCall(){
				$.ajax({
					type : "POST",
					url : "basket.php",
					data : Basket(),
					success : function(status){
						alert("장바구니에 등록되었습니다.");
					},
					error : function(status, error){
						alert("장바구니 항목이 초과했습니다.");
					}
				});
			}
		</script>
        
    </body>
</html>
