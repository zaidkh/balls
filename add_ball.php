<?php

require_once '../../includes/includes.php';

if (isset($_POST['submit'])) {
    if (!$_POST['ball_name']) {
        $errors['ball_name'] = "Ball name required";
    }
    if (isset($errors)) {
        foreach ($errors as $field => $error_message) {
            $_TEMPLATES['vars']['form_errors'][$field] = $error_message;
        }
        require_once $_TEMPLATES['location'] . 'balls/add.tpl.php';
        exit();
    }
//    move_uploaded_file($_FILES['userfile']['tmp_name'], '../../uploads/');

    $query = "
        INSERT INTO `ball` (
            `name`,
            `manufacturer`,
            `filepath`,
            `symmetric`,
            `rg`,
            `differential`,
            `color`,
            `stock`,
            `notes`
        ) VALUES (
            '" . $_POST['ball_name'] . "',
            '" . $_POST['file'] . "',
            '" . $_POST['notes'] . "'
        )";
    $result = mysqli_query($_DB, $query);
    if ($result === false) {
        echo "DB ERROR: " . mysqli_error($_DB);
        exit();
    }
    $_TEMPLATES['vars']['success'] = "Ball added successfully";
    unset($_POST);
}
require_once $_TEMPLATES['location'] . 'balls/add.tpl.php';
