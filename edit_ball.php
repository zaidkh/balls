<?php

require_once '../../includes/includes.php';

if (isset($_GET['id'])) {
    if (isset($_GET['delete'])) {
        $query = "DELETE FROM `ball` WHERE `id` = '" . $_GET['id'] . "'";
        mysqli_query($_DB, $query);
        if ($result === false) {
            echo "DB ERROR: " . mysqli_error($_DB);
            exit();
        } else {
            $_TEMPLATES['vars']['success'] = "Ball successfully deleted";
            display_ball_listing();
        }
    }

    if (isset($_POST['submit'])) {
        if (!$_POST['pattern_name']) {
            $errors['pattern_name'] = "Pattern name required";
        }
        if (isset($errors)) {
            foreach ($errors as $field => $error_message) {
                $_TEMPLATES['vars']['form_errors'][$field] = $error_message;
            }
            require_once $_TEMPLATES['location'] . 'balls/edit.tpl.php';
            exit();
        }

//        if (isset($_FILES['userfile']['tmp_name']))
//        move_uploaded_file($_FILES['userfile']['tmp_name'], '../../uploads/');

        $query = "
        UPDATE `balls` SET 
            
            
        'name'='" .$_POST['ball_name']."',
        'filepath'= '" . $_POST['file']."',
         'manufacturer'= '" .  $_POST['manufacturer']."',
         'symmetric'= '" .  $_POST['symmetric']."',
          'rg'= '" . $_POST['rg']."',
          'differential'= '" . $_POST['differential']."',
          'color'= '" . $_POST['color']."',
          'stock'= '" . $_POST['stock']."',
        `notes` = '" . $_POST['notes'] . "',
        WHERE `id` = '" . $_GET['id'] . "'
        ";
        $result = mysqli_query($_DB, $query);
        if ($result === false) {
            echo "DB ERROR: " . mysqli_error($_DB);
            exit();
        }
        $_TEMPLATES['vars']['success'] = "Ball edited successfully";
        display_ball_listing();
    } else {  // Display single listing edit form
        $query = "
        SELECT
            `name`,
            `manufacturer`,
            `filepath`,
            `symmetric`,
            `rg`,
            `differential`,
            `color`,
            `stock`,
            `notes`
        FROM   `balls`
        WHERE `id` = '" . $_GET['id'] . "'
        ";
        $result = mysqli_query($_DB, $query);
        if ($result === false) {
            echo "DB ERROR: " . mysqli_error($_DB);
            exit();
        }
        $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_POST['ball_name'] = $data['name'];
        $_POST['filepath'] = $data['filepath'];
        $_POST['manufacturer'] = $data['manufacturer'];
        $_POST['symmetric'] = $data['symmetric'];
        $_POST['rg'] = $data['rg'];
        $_POST['differential'] = $data['differential'];
        $_POST['color'] = $data['color'];
        $_POST['stock'] = $data['stock'];
        $_POST['notes'] = $data['notes'];

        require_once $_TEMPLATES['location'] . 'balls/edit.tpl.php';
        exit();
    }
} else {
    display_ball_listing();
}

function display_ball_listing() {
    global $_TEMPLATES, $_DB;
    $query = "
        SELECT
            `id`,
            `name`,
            `manufacturer`,
            `filepath`,
            `symmetric`,
            `rg`,
            `differential`,
            `color`,
            `stock`,
            `notes`
        FROM `balls`
        WHERE 1";
    $result = mysqli_query($_DB, $query);
    if ($result === false) {
        echo "DB ERROR: " . mysqli_error($_DB);
        exit();
    }
    while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $_TEMPLATES['vars']['balls'][] = $data;
    }
    require_once $_TEMPLATES['location'] . 'balls/listing.tpl.php';
    exit();
}
