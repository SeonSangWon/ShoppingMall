<?php

session_start();

//모든 세션 삭제
session_unset();

echo "
    <script>
        location.href = '../index.php';
    </script>
";

?>