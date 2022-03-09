<?php require_once APPROOT . 'view/inc/header.php';?>
<h3><?php echo $data['title'];?></h3>
<ul>
    <?php
    $priceSum = 0;
    $qtySum = 0;
    foreach($data['basket'] as $basketItem) {
        $tmpPrice = (double) $basketItem->price * (double) $basketItem->quantity * (double) $basketItem->factor;
        echo '<li>';
        echo  $basketItem->product . ' -- ' . $basketItem->size . ' -- ' . $basketItem->quantity . ' Stück -- ' . number_format($tmpPrice, 2, ',', '.') . '€';
        echo '</li>';
        $priceSum += $tmpPrice;
        $qtySum += (double) $basketItem->quantity;
    }
    echo '<hr>';
    echo '<li><strong>Gesamt</strong> -- ' . $qtySum . ' Stück -- ' . number_format($priceSum, 2, ',', '.') . '€</li>';
    ?>
</ul>
<a href="<?php echo URLROOT . 'products/index'?>">Zurück</a>
<?php require_once APPROOT . 'view/inc/footer.php';?>
