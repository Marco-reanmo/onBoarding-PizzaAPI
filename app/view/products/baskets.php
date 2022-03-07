<?php require_once APPROOT . 'view/inc/header.php';?>
<h1>Warenkorb</h1>
<ul>
    <?php
    if(isset($_SESSION['basket_id'])) {
        $priceSum = 0;
        $qtySum = 0;
        foreach($data['basket'] as $basketItem) {
            $tmpPrice = (double) $basketItem->price * (double) $basketItem->quantity;
            echo '<li>' . $basketItem->product . ' -- ' . $basketItem->quantity . ' Stück -- ' . number_format($tmpPrice, 2, ',', '.') . '€</li>';
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
<?php require_once APPROOT . 'view/inc/footer.php';?>
