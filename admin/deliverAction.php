<?php
require("../connect.php");

$order_num = $_POST['deliver'];

if($order_num)
{
    $query = "UPDATE order2 SET deliver='y' WHERE order_num='$order_num'";
    $result = mysqli_query($conn, $query);
    if($result)
    {
        echo"
            <script>
                alert('해당 상품이 출고되었습니다.');
                history.back();
            </script>
        ";
    }
    else
    {
        echo"
            <script>
                alert('Error!!!');
                history.back();
            </script>
        ";
    }
}
?>