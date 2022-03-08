<?php require_once APPROOT . 'view/inc/header.php';?>
<h1><?php echo $data['title']?></h1>
<ul>
    <?php
    if(isset($data['basket'])) {
        $priceSum = 0;
        $qtySum = 0;
        foreach($data['basket'] as $basketItem) {
            $tmpPrice = (double) $basketItem->price * (double) $basketItem->quantity;
            echo '<li><form action="' . URLROOT .'products/baskets/' . $_SESSION['user_id'] . '" method="POST">';
            echo '<input type="hidden" name="basket_id" value="' . $basketItem->ID . '">';
            echo '<input type="hidden" name="product_id" value="' . $basketItem->product_ID . '">';
            echo  $basketItem->product . ' -- ' . $basketItem->quantity . ' Stück -- ' . number_format($tmpPrice, 2, ',', '.') . '€';
            echo '<input type="submit" value="Entfernen">';
            echo '</form></li>';
            $priceSum += $tmpPrice;
            $qtySum += (double) $basketItem->quantity;
        }
        echo '<hr>';
        echo '<li><strong>Gesamt</strong> -- ' . $qtySum . ' Stück -- ' . number_format($priceSum, 2, ',', '.') . '€</li>';
    } else {
        echo '<li>Warenkorb noch leer.</li>';
    }
    ?>
</ul>
<a href="<?php echo URLROOT . 'products/index'?>">Zurück</a>
<form action="<?php echo URLROOT . 'orders/index'?>" method="POST">
    <input  type="<?php echo isset($_SESSION['basket_id']) ? 'submit' : 'hidden' ?>" value="Bestellung aufgeben">
</form>
<?php require_once APPROOT . 'view/inc/footer.php';?>
