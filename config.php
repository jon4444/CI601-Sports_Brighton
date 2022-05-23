<?php
$conn = new mysqli("brighton", "jkf13_jon4", "Arsenal45678", "jkf13_cart-system");
if ($conn->connect_error) {
    die("connection failed" . $conn->connect_error);
}