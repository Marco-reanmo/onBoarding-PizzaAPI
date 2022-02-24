<?php require_once APPROOT . 'view/inc/header.php';?>
<h1>Pages - <?php echo $data['title'];?></h1>

<h2>Hallo <?php echo $_SESSION['user_name']?></h2>

<ul>
    <?php foreach($data['products'] as $product):?>
        <li><a href='<?php echo URLROOT . 'products/details/' . $product->ID?>'><?php echo $product->name?></a></li>
    <?php endforeach;?>
</ul>

<a href="<?php echo URLROOT?>/users/logout">Logout</a>
<?php require_once APPROOT . 'view/inc/footer.php';?>
