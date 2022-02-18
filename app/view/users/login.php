<?php require_once APPROOT . 'view/inc/header.php';?>

<h1>Login</h1>
<form action="<?php echo URLROOT . 'users/login' ?>" method="POST">
    <label for="email">E-Mail</label>
    <input type="text" name="email" value="<?php echo $data['email'] ?>">
    <p class="error"><?php echo $data['email_error'] ?></p>
    <label for="password">Passwort</label>
    <input type="password" name="password" value="<?php echo $data['password'] ?>">
    <p class="error"><?php echo $data['password_error'] ?></p>
    <input type="submit" value="Login">
    <a href="<?php echo URLROOT . 'users/register'?>">
    Noch nicht registriert? Dann hier registrieren.
    </a>
</form>

<?php require_once APPROOT . 'view/inc/footer.php';?>
