<?php
require("../connect.php");

session_start();

//관리자 접속
if(! $_SESSION['admin'])
{
    echo "
        <script>
            location.href='../index.php';
        </script>
    ";
}

$query = "SELECT * FROM order2 WHERE deposit='y' AND deliver='y'";
$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <title></title>
        <script src="../js/bootstrap.min.js" async></script>
    </head>
    <style>
        td{
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <body>
        <div class="">
            <table class="table">
                <tr>
                    <td>
                        주문번호
                    </td>
                    <td>
                        회원ID
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
                                <td colspan='11' align='center'>
                                    상품출고가 완료된 주문이 없습니다.
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
                                    <?php echo $row['order_num']; ?>
                                </td>
                                <td>
                                    <?php echo $row['id']; ?>
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
                </tr>
            </table>
        </div>
    </body>
</html>