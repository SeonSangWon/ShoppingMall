<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">    
<link rel="stylesheet" type="text/css" href="css/w3.css">

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Permanent+Marker">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nanum+Gothic">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Jua">
<meta charset="UTF-8">
<title>MegaCoinShop</title>
</head>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js" async></script>
<script src="js/app.js" async></script>
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
                echo "<a href='members/logoutCheck.php' class='w3-button w3-padding-large menuFont' style='text-decoration:none'>로그아웃</a>";
        ?>
                    
        <?php 
            //php.ini 파일에서
            //"error_reporting = E_ALL & ~E_NOTICE"로 수정 필요!
            if(!$_SESSION['user_session'])
                 echo "<a class='w3-button w3-padding-large menuFont' href='members/signupForm.php'>회원가입</a>";
            else
                echo "<a class='w3-button w3-padding-large menuFont'>회원정보</a>";
        ?>
                    
        <!--<a class="w3-button w3-padding-large menuFont">고객센터</a>-->
        <a class="w3-button" style="padding-top:8px; padding-bottom:9px;">     <i class="fa fa-shopping-cart"></i>
        </a>
        <a class="w3-button" style="padding-top:8px; padding-bottom:9px;">
            <i class="fa fa-search"></i>
        </a>
        </div>
    </div>
</div>
    
<!-- 로그인 모달 -->
<div id="login_modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
        <div class="w3-center">
            <br>
            <span onclick="document.getElementById('login_modal').style.display='none'" class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Close Modal">×</span>
            <h1 class="dynamicFont" style="font-size:50px;">
                <b>Mega Coin Shop</b>
            </h1>
        </div>

        <form class="w3-container" action="members/loginCheck.php" method="post" name="login_form" id="login_form" autocomplete="off">
        <div class="w3-section">
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="아이디를 입력해주세요." name="usrid" required>
            <input class="w3-input w3-border" type="password" placeholder="비밀번호를 입력해주세요" name="password" required>
                        
            <div id="display_error" style="color:red;"></div>
                        
            <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">로그인</button>
        </div>
        </form>

        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <button onclick="document.getElementById('login_modal').style.display='none'" type="button" class="w3-button w3-red">
                취소
            </button>
            <span class="w3-right w3-padding w3-hide-small">
                
            </span>
        </div>
    </div>
</div>

   
<!--<div class='w3-center'>
    <form class="w3-container">
        <div class='w3-section'>
            <input class="w3-border w3-border-red" style="width:500px; height:51px;" type="text">
            <button class='w3-button w3-red w3-text-white' style="height:51px; margin-top:-3px; margin-left:-4px;">
                <i class="fa fa-search w3-xlarge"></i>
            </button>
        </div>
    </form>
</div>-->
</body>
</html>