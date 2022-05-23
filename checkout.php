<?php
require 'config.php';

$grand_total = 0;
$allItems = '';
$items = array();

$sql = "SELECT CONCAT(product_name,'(',qty,')') AS ItemQty,
                total_price FROM cart";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $grand_total += $row['total_price'];
    $items[] = $row['ItemQty'];
}
$allItems = implode(", ", $items);
echo $allItems;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="index.php"><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;Sports Brighton</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="checkout.php">Checkout</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart">Cart</i> <span id="cart-item" class="badge badge-danger">1</span></a>
      </li>

    </ul>
  </div>
</nav>
 <!-- END OF NAVIGATION BAR -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 px-4 pb-4" id="order">
            <h4 class="text-center text-info p-2">Complete your order!</h4>
            <div class="jumbotron p-3 mb-2 text-center">
                <h6 class="lead"><b>Product(s) : </b><?=$allItems;?></h6>
                <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                <h5><b>Amount Payable : </b><?=number_format($grand_total, 2)?></h5>
            </div>
            <form action="" method="post" id="placeOrder">
                <input type="hidden" name="products" value="<?=$allItems;?>">
                <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" required="">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter E-mail" required="">
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required="">
                </div>
                <div class="form-group">
                    <textarea name="address" class="form-control" cols="10" rows="3" placeholder="Enter Delivery Address..."></textarea>
                </div>
                <h6 class="text-center lead">Select Payment Mode</h6>
                <div class="form-group">
                <select name="pmode" class="form-control">
                    <option value="" selected disabled>-Select Payment Mode-</option>
                    <option value="cod">Cash On Delivery</option>
                    <option value="netbanking">Net Banking</option>
                    <option value="cards">Debit/Credit Card</option>
                </select>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $("#placeOrder").submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'action.php',
                method: 'post',
                data: $('form').serialize()+"&action=order",
                success: function(response){
                    $("#order").html(response);
                }
            });
        });

        // load total no. of items in the cart and display in the navbar
        load_cart_item_number();

        function load_cart_item_number(){
            $.ajax({
                url: 'action.php',
                method: 'get',
                data: {
                    cartItem: "cart_item"
                },
                success: function(response){
                    $("cart-item").html(response);
                }
            });
        }
    });
</script>