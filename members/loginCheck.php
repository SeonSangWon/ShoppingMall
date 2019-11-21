<?php

//AJAX요청 판단 코드
//AJAX요청이 아닐경우 Unauthorized Acces 출력
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){
  exit("Unauthorized Acces");
}
require('inc/config.php');
require('inc/functions.php');

/* Check Login form submitted */
if(!empty($_POST) && $_POST['Action']=='login_form'){
    /* Define return | here result is used to return user data and error for error message */
    $Return = array('result'=>array(), 'error'=>'');

    $usrid = safe_input($con, $_POST['usrid']);
    $password = safe_input($con, $_POST['password']);

    /* Check Email and Password existence in DB */
    $result = mysqli_query($con, "SELECT * FROM member WHERE id='$usrid' AND password='$password'");
    
    if(mysqli_num_rows($result)==1){
        $row = mysqli_fetch_assoc($result);
        /* Success: Set session variables and redirect to Protected page */
        $Return['result'] = $_SESSION['user_session'] = array('user_session'=>$row['id']);
        //세션 생성
        $_SESSION['user_id'] = $row['id'];
    }
    else if($usrid == 'admin' && $password == '0000'){
        $admin = 'admin';
        $Return['result'] = $_SESSION['user_session'] = array('user_session'=>$admin);
        $_SESSION['admin'] = $admin;
    }
    else {
        /* Unsuccessful attempt: Set error message */
        $Return['error'] = '아이디 또는 비밀번호가 틀렸습니다.';
    }
    /*Return*/
    output($Return);
}

?>