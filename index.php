<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js" crossorigin="anonymous">

    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="index.html">
      <i class="fas fa-mobile-alt">
        <img src="" alt=""> <!-- formerly a logo -->
      </i>&nbsp;&nbsp;Sports Brighton
  </a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>


  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.html">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.html">Contact</a>
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

<header class="bg-dark py-5 ">
        <div class="container px-4 px-lg-5 my-5 ">
            <div class="text-center text-white ">
                <h1 class="display-4 fw-bolder ">Ready to gear up?</h1>
                <p class="lead fw-normal text-white-50 mb-0 ">Have your pick</p>
            </div>
        </div>
</header>

       <!--  DISPLAYING THE PRODUCTS -->
<div class="container">
    <div id="message"></div>
    <div class="row mt-2 pb-3">
        <?php
include 'config.php';
$stmt = $conn->prepare("SELECT * FROM product");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()):
?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card-deck">
                <div class="card p-2 border-secondary mb-2">
                    <img src="<?=$row['product_image']?>" class="card-img-top" height="250">
                    <div class="card-body-p1">
                        <h4 class="card-title text-center text-info"><?=$row['product_name']?></h4>
                        <h5 class="card-text text-center text-danger"><i class="fas fa-pound-sign"></i>	&#xf154;<?=number_format($row['product_price'], 2)?>/-</h5>
                    </div>
                    <div class="card-footer p-1">
                        <form action="" class="form-submit">
                            <input type="hidden" class="pid" value="<?=$row['id']?>">
                            <input type="hidden" class="pname" value="<?=$row['product_name']?>">
                            <input type="hidden" class="pprice" value="<?=$row['product_price']?>">
                            <input type="hidden" class="pimage" value="<?=$row['product_image']?>">
                            <input type="hidden" class="pcode" value="<?=$row['product_code']?>">
                            <button class="btn btn-info btn-block addItemBtn"><i class="fas- fa-cart-plus"></i>Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php endwhile;?>
    </div>
</div>



<!-- jQuery library -->

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".addItemBtn").click(function(e) {
            e.preventDefault();
            var $form = $(this).closest(".form-submit");
            var pid = $form.find(".pid").val();
            var pname = $form.find(".pname").val();
            var pprice = $form.find(".pprice").val();
            var pimage = $form.find(".pimage").val();
            var pcode = $form.find(".pcode").val();
            var pqty = $form.find(".pqty").val();

            $.ajax({
                url: 'action.php',
                method: 'post',
                data: {pid:pid,
                        pname:pname,
                        pprice:pprice,
                        pimage:pimage,
                        pcode:pcode
                        },
                success:function(response){
                    $("#message").html(response);
                    window.scrollTo(0, 0);
                    load_cart_item_number();
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
</body>
</html>
