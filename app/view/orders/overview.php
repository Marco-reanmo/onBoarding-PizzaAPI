<?php require_once APPROOT . 'view/inc/header.php';?>
<h1><?php echo $data['title']?></h1>
<ul>
    <?php
    if(!empty($data['orders'])) {
        $overallPriceSum = 0;
        $overallQtySum = 0;
        $priceSum = 0;
        $qtySum = 0;
        foreach($data['orders'] as $orderItem) {
            echo '<li><strong>Ihre Bestellung vom ' . $orderItem['created_at'] . ':</strong>';
            echo '<ul>';
            foreach($orderItem['products'] as $product) {
                $tmpPrice = $product['price'] *  $product['quantity'] * $product['factor'];
                echo '<li>' . $product['name'] . ' -- ' . $product['size'] . ' -- ' . $product['quantity'] . ' Stück -- ' . number_format($tmpPrice, 2, ',', '.') . '€</li>';
                $priceSum += $tmpPrice;
                $qtySum +=  $product['quantity'];
            
            }
            echo '<hr>';
            echo '<li><strong>Bestellwert</strong> -- ' . $qtySum . ' Stück -- ' . number_format($priceSum, 2, ',', '.') . '€</li>';
            echo '</ul><br>';
            $overallPriceSum += $priceSum;
            $overallQtySum += $qtySum;
        }
        echo '<br>';
        echo '<li><h3>Gesamt -- ' . $overallQtySum . ' Stück -- ' . number_format($overallPriceSum, 2, ',', '.') . '€</h3></li>';
    } else {
        echo '<li>Noch keine Bestellungen.</li>';
    }
    ?>
</ul>
<a href="<?php echo URLROOT . 'products/index'?>">Zurück</a>
<?php require_once APPROOT . 'view/inc/footer.php';?>
