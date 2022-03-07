<?php require_once APPROOT . 'view/inc/header.php';?>
<h1><?php echo $data['product']->name?></h1>
<img src="<?php echo !$data['product_image'] == NULL ? 'data:image/jpeg;base64,' . base64_encode($data['product_image']->image) : URLROOT . 'public/images/default_pizza.png'?>" alt="<?php echo $data['product']->name?>">
<h3>Zutaten</h3>
<ul>
    <?php foreach($data['ingredients'] as $ingredient):?>
        <li><?php echo $ingredient->name?></li>
    <?php endforeach;?>
</ul>
<a href="<?php echo URLROOT . 'products/index'?>">Zurück</a>
<?php require_once APPROOT . 'view/inc/footer.php';?>
