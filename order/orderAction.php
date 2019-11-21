<?php
include "../connect.php";

//주문정보 : 20191026001 +1
$time = date("Ymd");
$order_num = date("Ymd");

$query = "SELECT * FROM order2 WHERE order_num LIKE '$time%'";
$result = mysqli_query($conn, $query);
$rowCount = mysqli_num_rows($result);

//하루에 주문이 1건 이상 있을 경우
if($rowCount >= 1)
{
    $order_num = $order_num . "0000";
    $order_num = $order_num + $rowCount + 1;
}
//하루에 주문이 10건 이상 있을 경우
else if($rowCount >= 10)
{
    $order_num = $order_num . "000";
    $order_num = $order_num + $rowCount + 1;
}
//첫 주문일 경우
else
{
    $order_num = $order_num . "0000";
    $order_num = $order_num + 1;
}


//넘어온 주문정보
$id = $_POST['id'];
$product_num = $_POST['product_num'];
$amount = $_POST['amount'];
$price = $_POST['price'];
$rand = $_POST['rand'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$postcode = $_POST['postcode'];
$address = $_POST['address'];
$memo = $_POST['memo'];

//최종금액 계산
$price = (int)$price + (float)$rand;

$insertQuery = "INSERT INTO order2(order_num, id, product_num, amount, price, name, phone, postcode,
address, memo) VALUES('$order_num', '$id', $product_num, $amount, $price, '$name',
'$phone', '$postcode', '$address', '$memo')";
$insertResult = mysqli_query($conn, $insertQuery);
if(! $insertResult)
{
    echo "
        <script>
            alert('Error!!!');
            history.back();
        </script>";
}
else
{
    echo("
    <script>alert('주문이 접수되었습니다. 입금 확인까지 최대 30분정도 요소됩니다.');</script>
    <meta http-equiv='refresh' content='0;url=../index.php'>");
}

?>
