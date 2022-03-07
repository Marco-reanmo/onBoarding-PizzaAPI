<?php 
    require_once APPROOT . 'view/inc/header.php';
    require_once APPROOT . 'bootstrap.php';
?>
<h1>Pages - <?php echo $data['title'];?></h1>

<h2>Hallo <?php echo $_SESSION['user_name']?></h2>

<ul>
    <?php foreach($data['products'] as $product):?>
        <li>
            <form action= "<?php echo URLROOT . 'products/add' ?>" method="POST">
            <a href='<?php echo URLROOT . 'products/details/' . $product->ID?>'><?php echo $product->name?></a>
            <input type="hidden" name="productId" value="<?php echo $product->ID?>">
            <input type="number" name="quantity" min=1 max=99 value="1">
            <input type="submit" value="Hinzufügen">
            </form>
        </li>
    <?php endforeach;?>
</ul>
<?php flash('add_success');?>
<a href="<?php echo URLROOT?>/users/logout">Logout</a>
<br>
<a href="<?php echo URLROOT . "/products/baskets/" . $_SESSION['user_id']?>">Warenkorb</a>
<?php require_once APPROOT . 'view/inc/footer.php';?>
