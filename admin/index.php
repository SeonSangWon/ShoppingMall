<?php
require("../connect.php");
require("../xcoin_api_client.php");

session_start();

//관리자 접속
if(! $_SESSION['admin'])
{
    echo "
        <script>
            location.href='admin/index.php';
        </script>
    ";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/w3.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Permanent+Marker">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nanum+Gothic">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Jua">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MegaCoinAdmin</title>
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js" async></script>
        <script src="../js/app.js" async></script>
    </head>
    <style>
        h1,h2,h3,h4,h5,h6,.w3-wide {
        font-family: "Montserrat", sans-serif;
        }
        body,a {
            font-family: 'Nanum Gothic', sans-serif;
        }
        .menuFont {
            font-family: 'Nanum Gothic', sans-serif;
            font-size: 13px;
        }
        .categoryFont {
            font-family: 'Jua', sans-serif;
        }
        .dynamicFont {
            font-family: 'Permanent Marker', cursive;
        }
        .optionFont {
            background-color: darkgrey;
            color: white;
            font-size: 11px; 
            font-family: "돋움", sans-serif;
            padding: 2px;
        }
        .stringHidden {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <body>
        <!-- 상단바 -->
        <div class="w3-top">
            <!-- 상단바 왼쪽 메뉴 -->
            <div class="w3-bar w3-white w3-card w3-large" style='padding-left:15px; padding-right:15px;'>
                <div class="w3-dropdown-click w3-left">
                    <a onclick="show_category()" class="w3-button">
                        <i class="fa fa-bars"></i>
                    </a>
                    <div class="w3-dropdown-content w3-bar-block w3-card-category w3-border" style="width:250px; padding-bottom:10px; padding-top:10px;" id="category">
                        <a class="w3-bar-item w3-button">패션의류/잡화</a>
                        <a class="w3-bar-item w3-button">문구/오피스</a>
                        <div id="myAccFunc">
                            <a class="w3-bar-item w3-button" id="myBtn">식품</a>
                            <div id="demoAcc" class="w3-bar-block w3-hide w3-padding w3-medium">
                                <a href="products/productsList.php?pCode=B01" class="w3-bar-item w3-button">과일</a>
                                <a href="products/productsList.php?pCode=B02" class="w3-bar-item w3-button">생수/음료</a>
                                <a href="products/productsList.php?pCode=B03" class="w3-bar-item w3-button">커피/원두/차</a>
                                <a href="products/productsList.php?pCode=B04" class="w3-bar-item w3-button">과자/간식</a>
                                <a href="products/productsList.php?pCode=B05" class="w3-bar-item w3-button">면/통조림/가공식품</a>
                            </div>
                        </div>
                        <a class="w3-bar-item w3-button">주방용품</a>
                        <a class="w3-bar-item w3-button">생활용품</a>
                        <div class="w3-hide-large w3-hide-medium w3-small">
                            <p style='margin-left:10px; margin-right:10px;' class="w3-border-bottom w3-border-light-grey"></p>
                                <a onclick="document.getElementById('login_modal').style.display='block'" class="w3-bar-item w3-button">로그인</a>
                                <a href="members/signupForm.php" class="w3-bar-item w3-button">회원가입</a>
                                <!--<a href="#" class="w3-bar-item w3-button">고객센터</a>-->
                                <a href="#" class="w3-  bar-item w3-button">장바구니</a>
                                <a href="#" class="w3-bar-item w3-button">검색</a>
                                </div>
                    </div>
                </div>

                <a href="index.php" class="w3-wide w3-bar-item" style="text-decoration:none;">
                    <b>LOGO</b>
                </a>

                <!-- 상단바 오른쪽 메뉴, 사이즈 작아지면 사라짐 -->
                <div class="w3-right w3-hide-small" style="margin-bottom:-1px;">
                <?php 
                     //php.ini 파일에서
                     //"error_reporting = E_ALL & ~E_NOTICE"로 수정 필요!
                    if(!$_SESSION['user_session'])
                        echo "<a onclick=\"document.getElementById('login_modal').style.display='block'\" class='w3-button w3-padding-large menuFont'>로그인</a>";
                    else
                        echo "<a href='../members/logoutCheck.php' class='w3-button w3-padding-large menuFont' style='text-decoration:none'>로그아웃</a>";
                ?>

                <?php 
                    //php.ini 파일에서
                    //"error_reporting = E_ALL & ~E_NOTICE"로 수정 필요!
                    if(!$_SESSION['user_session'])
                         echo "<a class='w3-button w3-padding-large menuFont' href='../members/signupForm.php'>회원가입</a>";
                    else
                        echo "<a class='w3-button w3-padding-large menuFont' href='transactions.php'>입금여부</a>";
                ?>

                <!--<a class="w3-button w3-padding-large menuFont">고객센터</a>-->
                <a class="w3-button" style="padding-top:8px; padding-bottom:9px;"><i class="fa fa-shopping-cart"></i>
                </a>
                <a class="w3-button" style="padding-top:8px; padding-bottom:9px;">
                    <i class="fa fa-search"></i>
                </a>
                </div>
            </div>
        </div>
        <!-- End 상단바 -->
        
        <div style="padding-top: 100px;" align="center">
            <h3>상품배송 주문</h3>
            <?php
                include "deliverN.php";
            ?>
        </div>
        
        <div style="padding-top: 50px;" align="center">
            <h3>상품배송완료 주문</h3>
            <?php
                include "deliverY.php";
            ?>
        </div>
    </body>
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
    </script>
</html>
