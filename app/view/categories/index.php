<?php require_once APPROOT . 'view/inc/header.php';?>
<h3><?php echo $data['title'];?></h3>

<ul>
    <?php
        foreach($data['categories'] as $category) {
            echo '<li>'. $category->name . '</li>';            
        }
    ?>
</ul>

<a href="<?php echo URLROOT . 'products/index'?>">Zurück</a>
<?php require_once APPROOT . 'view/inc/footer.php';?>
