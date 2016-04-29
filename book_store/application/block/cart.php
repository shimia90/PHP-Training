<?php 
    $cart           =   Session::get('cart');
    $totalItem      =   0;
    $totalPrices    =   0;
    
    if(!empty($cart)) {
        $totalItem      =   array_sum($cart['quantity']);
        $totalPrices    =   array_sum($cart['price']);
    }
    
    $linkViewCart       =   URL::createLink('default', 'user', 'cart');
?>
<div class="cart">
  <div class="title"><span class="title_icon"><img src="<?php echo $imageURL; ?>/cart.gif" alt="" title="" /></span>My cart</div>
  <div class="home_cart_content">
  <?php echo $totalItem; ?> x items | <span class="red">TOTAL: <?php echo number_format($totalPrices); ?>$</span>
  </div>
  <a href="<?php echo $linkViewCart; ?>" class="view_cart">view cart</a>

</div>