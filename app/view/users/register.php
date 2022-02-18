<?php require_once APPROOT . 'view/inc/header.php';?>

<h1>Erstelle einen Account</h1>
<form action="<?php echo URLROOT . 'users/register' ?>" method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" value="<?php echo $data['name'] ?>">
    <p class="error"><?php echo $data['name_error'] ?></p>
    <label for="email">E-Mail</label>
    <input type="email" name="email" value="<?php echo $data['email'] ?>">
    <p class="error"><?php echo $data['email_error'] ?></p>
    <label for="password">Passwort</label>
    <input type="password" name="password" value="<?php echo $data['password'] ?>">
    <p class="error"><?php echo $data['password_error'] ?></p>
    <label for="confirm_password">Passwort wiederholen</label>
    <input type="password" name="confirm_password" value="<?php echo $data['confirm_password'] ?>">
    <p class="error"><?php echo $data['confirm_password_error'] ?></p>
    <label for="postal_code">PLZ</label>
    <input type="text" name="postal_code" value="<?php echo $data['postal_code'] ?>">
    <p class="error"><?php echo $data['postal_code_error'] ?></p>
    <label for="city">Ort</label>
    <input type="text" name="city" value="<?php echo $data['city'] ?>">
    <p class="error"><?php echo $data['city_error'] ?></p>
    <label for="street">Straße</label>
    <input type="text" name="street" value="<?php echo $data['street'] ?>">
    <p class="error"><?php echo $data['street_error'] ?></p>
    <label for="house_number">Hausnummer</label>
    <input type="text" name="house_number" value="<?php echo $data['house_number'] ?>">
    <p class="error"><?php echo $data['house_number_error'] ?></p>
    <input type="submit" value="Registrieren">
    <a href="<?php echo URLROOT . 'users/login'?>">
    Bereits registriert? Dann hier einloggen.
    </a>
</form>

<?php require_once APPROOT . 'view/inc/footer.php';?>
