<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Data</title>
</head>
<body>
<fieldset>
    <legend>Person Details</legend>
    <?php
    $errors = array();
    require_once 'validate.inc';
    if (isset($_POST['surname'])) {
        validateName($errors, $_POST, 'surname');
        validateForm($errors, $_POST);
        if ($errors) {
            echo '<h1>Periksa kembali isian berikut:</h1>';
            include 'form.inc';
        } else {
            echo 'Form berhasil dikirim tanpa kesalahan.';
        }
    }else {
        include 'form.inc';
    }
    ?>
</fieldset>
</body>
</html>