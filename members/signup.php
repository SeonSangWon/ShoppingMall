<?php
require("../connect.php");

//값 받아오기
$id = $_POST['id'];
$password = $_POST['password'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$postcode = $_POST['postcode'];
$address = $_POST['address'];

$query = "INSERT INTO member(id, password, name, phone, postcode, address)
VALUES('$id', '$password', '$name', '$phone','$postcode', '$address')";
$result = mysqli_query($conn, $query);
if(! $result)
{
    echo"
        <script>
            alert('회원 가입에 실패했습니다. 정확한 정보를 입력해주세요.');
            history.back();
        </script>
    ";
}
else
{
    echo("<meta http-equiv='refresh' content='0;url=../index.php'>");
}
?>