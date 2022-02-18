<?php require_once APPROOT . 'view/inc/header.php';?>
<h1>Pages - <?php echo $data['title'];?></h1>
<?php require_once APPROOT . 'view/inc/footer.php';?>
<ul>
    <?php foreach($data['students'] as $student) :?>
        <li><?php var_dump($student)?></li>
    <?php endforeach;?>
</ul>