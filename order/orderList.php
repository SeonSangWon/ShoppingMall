<?php
require("../connect.php");
session_start();

$id = $_SESSION['user_id'];
//주문목록 조회
$query = "SELECT * FROM order2 WHERE id='$id' AND deliver='n'";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);

//배송완료 주문목록 조회
$query2 = "SELECT * FROM order2 WHERE id='$id' AND deliver='y'";
$result2 = mysqli_query($conn, $query2);
$count2 = mysqli_num_rows($result2);
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
        td{
            text-align: center;
            vertical-align: middle;
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
                            echo "<a class='w3-button w3-padding-large menuFont' href='../index.php'>메인으로</a>";
                    ?>
                    
                    <a class="w3-button w3-padding-large menuFont">고객센터</a>
                    <a class="w3-button" style="padding-top:8px; padding-bottom:9px;"><i class="fa fa-shopping-cart"></i></a>
                    <a class="w3-button" style="padding-top:8px; padding-bottom:9px;"><i class="fa fa-search"></i></a>
                </div>

            </div>
        </div>
        <!-- End 상단바 -->

        <div style="margin-top: 100px;">
            <h2 style="text-align: center;">주문목록</h2>
            <table class="table">
                <tr>
                    <td>
                        입금여부
                    </td>
                    <td>
                        배송여부
                    </td>
                    <td>
                        주문번호
                    </td>
                    <td>
                        상품명
                    </td>
                    <td>
                        수량
                    </td>
                    <td>
                        금액
                    </td>
                    <td>
                        수령인
                    </td>
                    <td>
                        전화번호
                    </td>
                    <td>
                        우편번호
                    </td>
                    <td>
                        주소
                    </td>
                    <td>
                        배송 시, 요청사항
                    </td>
                    <td>
                        주문일자
                    </td>
                </tr>
                <?php
                    if($count == 0)
                    {
                        echo "
                            <tr>
                                <td colspan='12' align='center'>
                                    주문이 없습니다.
                                </td>
                            </tr>
                        ";
                    }
                    else
                    {
                        while($row=mysqli_fetch_array($result))
                        {
                ?>
                <tr>
                            <td>
                                <?php
                                    if($row['deposit'] == 'y')
                                        echo "입금완료";
                                    else
                                        echo "입금 확인중";
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($row['deliver'] == 'y')
                                        echo "상품배송완료";
                                    else
                                        echo "상품준비중";
                                ?>
                            </td>
                            <td>
                                <?php echo $row['order_num']; ?>
                            </td>
                            <td>
                               <?php 
                                    $product_num = $row['product_num'];
                                    $productSql = "SELECT product_name FROM product WHERE product_num='$product_num'";
                                    $productResult = mysqli_query($conn, $productSql);
                                    $productRow = mysqli_fetch_array($productResult);
                                    echo $productRow[0];
                                ?>
                            </td>
                            <td>
                                <?php echo $row['amount']; ?>
                            </td>
                            <td>
                                <?php echo $row['price']; ?>
                            </td>
                            <td>
                                <?php echo $row['name']; ?>
                            </td>
                            <td>
                                <?php echo $row['phone']; ?>
                            </td>
                            <td>    
                                <?php echo $row['postcode']; ?>
                            </td>
                            <td>
                                <?php echo $row['address']; ?>
                            </td>
                            <td>
                                <?php echo $row['memo']; ?>
                            </td>
                            <td>
                                <?php echo $row['date']; ?>
                            </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
        </div>
        
        <div style="margin-top: 30px;">
            <h2 style="text-align: center;">배송완료 주문목록</h2>
            <table class="table">
                <tr>
                    <td>
                        주문번호
                    </td>
                    <td>
                        상품명
                    </td>
                    <td>
                        수량
                    </td>
                    <td>
                        금액
                    </td>
                    <td>
                        수령인
                    </td>
                    <td>
                        전화번호
                    </td>
                    <td>
                        우편번호
                    </td>
                    <td>
                        주소
                    </td>
                    <td>
                        배송 시, 요청사항
                    </td>
                    <td>
                        주문일자
                    </td>
                </tr>
                <?php
                    if($count2 == 0)
                    {
                        echo "
                            <tr>
                                <td colspan='10' align='center'>
                                    배송완료 주문이 없습니다.
                                </td>
                            </tr>
                        ";
                    }
                    else
                    {
                        while($row2=mysqli_fetch_array($result2))
                        {
                ?>
                <tr>
                            <td>
                                <?php echo $row2['order_num']; ?>
                            </td>
                            <td>
                               <?php 
                                    $product_num2 = $row2['product_num'];
                                    $productSql2 = "SELECT product_name FROM product WHERE product_num='$product_num'";
                                    $productResult2 = mysqli_query($conn, $productSql2);
                                    $productRow2 = mysqli_fetch_array($productResult2);
                                    echo $productRow2[0];
                                ?>
                            </td>
                            <td>
                                <?php echo $row2['amount']; ?>
                            </td>
                            <td>
                                <?php echo $row2['price']; ?>
                            </td>
                            <td>
                                <?php echo $row2['name']; ?>
                            </td>
                            <td>
                                <?php echo $row2['phone']; ?>
                            </td>
                            <td>    
                                <?php echo $row2['postcode']; ?>
                            </td>
                            <td>
                                <?php echo $row2['address']; ?>
                            </td>
                            <td>
                                <?php echo $row2['memo']; ?>
                            </td>
                            <td>
                                <?php echo $row2['date']; ?>
                            </td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
        </div>
        
        

        <script>
            // 상단바에 있는 카데고리 펼쳐주는 효과
            function show_category() {
                var x = document.getElementById("category");
            
                if (x.className.indexOf("w3-show") == -1) {
                    x.className += " w3-show";
                } else {
                    x.className = x.className.replace(" w3-show", "");
                }
            }
        </script>
    </body>
</html>