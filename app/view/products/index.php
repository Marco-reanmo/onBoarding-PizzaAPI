<?php 
    require_once APPROOT . 'view/inc/header.php';
    require_once APPROOT . 'bootstrap.php';
?>
<h1><?php echo $data['title'];?></h1>

<h2>Hallo <?php echo $_SESSION['user_name']?></h2>

<h3>Salate</h3>

<ul>
    <?php foreach($data['salads'] as $salad):?>
        <li>
            <form action= "<?php echo URLROOT . 'products/add' ?>" method="POST">
            <a href='<?php echo URLROOT . 'products/details/' . $salad->ID?>'><?php echo $salad->name?></a>
            <input type="hidden" name="productId" value="<?php echo $salad->ID?>">
            <input type="number" name="quantity" min=1 max=99 value="1">
            <label for="size_small">Klein</label>
            <input type="radio" name="size" value="size_small" checked>
            <label for="size_medium">Normal</label>
            <input type="radio" name="size" value="size_medium">
            <label for="size_large">Groß</label>
            <input type="radio" name="size" value="size_large">
            <input type="submit" value="Hinzufügen">
            </form>
        </li>
    <?php endforeach;?>
</ul>


<h3>Pizzen</h3>

<ul>
    <?php foreach($data['pizzas'] as $pizza):?>
        <li>
            <form action= "<?php echo URLROOT . 'products/add' ?>" method="POST">
            <a href='<?php echo URLROOT . 'products/details/' . $pizza->ID?>'><?php echo $pizza->name?></a>
            <input type="hidden" name="productId" value="<?php echo $pizza->ID?>">
            <input type="number" name="quantity" min=1 max=99 value="1">
            <label for="size_small">Klein</label>
            <input type="radio" name="size" value="size_small" checked>
            <label for="size_medium">Normal</label>
            <input type="radio" name="size" value="size_medium">
            <label for="size_large">Groß</label>
            <input type="radio" name="size" value="size_large">
            <input type="submit" value="Hinzufügen">
            </form>
        </li>
    <?php endforeach;?>
</ul>

<h3>Getränke</h3>

<ul>
    <?php foreach($data['drinks'] as $drink):?>
        <li>
            <form action= "<?php echo URLROOT . 'products/add' ?>" method="POST">
            <a href='<?php echo URLROOT . 'products/details/' . $drink->ID?>'><?php echo $drink->name?></a>
            <input type="hidden" name="productId" value="<?php echo $drink->ID?>">
            <input type="number" name="quantity" min=1 max=99 value="1">
            <label for="size_small">Klein</label>
            <input type="radio" name="size" value="size_small" checked>
            <label for="size_medium">Normal</label>
            <input type="radio" name="size" value="size_medium">
            <label for="size_large">Groß</label>
            <input type="radio" name="size" value="size_large">
            <input type="submit" value="Hinzufügen">
            </form>
        </li>
    <?php endforeach;?>
</ul>

<?php flash('add_success');?>
<a href="<?php echo URLROOT?>/users/logout">Logout</a>
<br>
<a href="<?php echo URLROOT . "products/baskets"?>">Warenkorb</a>
<br>
<a href="<?php echo URLROOT . "orders/overview"?>">Bestell-Historie</a>
<br>
<a href="<?php echo URLROOT . "users/profile"?>">Profil</a>
<?php require_once APPROOT . 'view/inc/footer.php';?>
