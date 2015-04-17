<?php
//
require_once '../../includes/includes.php';

if (isset($_GET['id'])) {
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
        FROM   `pattern`
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

    require_once $_TEMPLATES['location'] . 'balls/view.tpl.php';
    exit();
} else {
    display_balls_listing();
}

function display_balls_listing() {
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
