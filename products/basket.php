<?php
require("../connect.php");

$name = $_POST['name'];
$age = $_POST['age'];

//echo(json_encode(array("name" => $name, "age" => $age)));
//성공
if($age = 24)
{
	$status = array(name = $name);
}
else
{
	$status = array(name = $name, age = $age);
}
echo json_encode($status);

/*
//장바구니에 상품을 등록하려는 회원의 현재 장바구니 개수를 조회
$count_query = "SELECT COUNT(id) FROM basket WHERE id='$id'";
$count_result = mysqli_query($conn, $count_query);
$count_num = mysqli_num_rows($count_result);

//장바구니에 상품이 10개이상 존재할 경우 Error
if($count_num > 10)
{
	
}

//검사로직을 통과할 경우
//장바구니에 상품을 등록
$query = "INSERT INTO basket(id, product_num, amount)
VALUES('$id', '$product_num', '$amount')";
$result = mysqli_query($conn, $query);

//Error
if(! $result)
{
	
}
*/

?>