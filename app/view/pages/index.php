<?php require_once APPROOT . 'view/inc/header.php';?>
<h1>Pages - <?php echo $data['title'];?></h1>
<ul>
    <li><?php echo $_SESSION['user_id']?></li>
    <li><?php echo $_SESSION['user_email']?></li>
    <li><?php echo $_SESSION['user_name']?></li>
</ul>
<a href="<?php echo URLROOT?>/users/logout">Logout</a>
<?php require_once APPROOT . 'view/inc/footer.php';?>
