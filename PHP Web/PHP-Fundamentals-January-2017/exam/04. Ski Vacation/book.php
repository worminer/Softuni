<?php
require_once 'app.php';
if (isset($_POST['book'])) {
    var_dump($_POST);
    $bookService = new Service\Booking\BookService($db);
    $errors = [];
    // check first name
    if (!isset($_POST['first_name']) || count($_POST['first_name']) < 3) {
        $errors['first_name'] = "First name not set or to short!";
    }
    // check last name
    if (!isset($_POST['last_name']) || count($_POST['last_name']) < 3) {
        $errors['last_name'] = "Last name not set or to short!";
    }
    // check email
    if (!isset($_POST['email']) || count($_POST['last_name']) < 3) {
        $errors['email'] = "Email not set or to short!";
    }
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "This is not valid Email!";
    }
    if (!isset($_POST['conf_email']) || count($_POST['conf_email']) < 3) {
        $errors['conf_email'] = "Confirm Email not set or to short!";
    }
    if ($_POST['conf_email'] !== $_POST['email']) {
        $errors['conf_email'] = "Email mismatch!";
    }

    //
    // check accommidation
    if (!isset($_POST['accommodationType']) || empty(intval($_POST['accommodationType']))) {
        $errors['accommodationType'] = "Not a proper accommodation type !";
    }
    //check child num
    if (!isset($_POST['child_num']) || empty(intval($_POST['child_num']))) {
        $errors['child_num'] = "not a proper child number !";
    }
    // check adult num
    if (!isset($_POST['adults_num']) || empty(intval($_POST['adults_num']))) {
        $errors['adults_num'] = "not a proper adult number !";
    }
    // check in and check out
    if (!isset($_POST['check_in'])) {
        $errors['check_in'] = "Check in date not set !";
    }
    if (!isset($_POST['check_in'])) {
        $errors['check_out'] = "Check in date not set !";
    }

    $lift = isset($_POST['lift']);
    $ski = isset($_POST['ski']);

    if (count($errors) == 0) {
        $bookService->book(
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['email'],
            intval($_POST['accommodationType']),
            intval($_POST['child_num']),
            intval($_POST['adults_num']),
            intval($_POST['rooms']),
            $_POST['check_in'],
            $_POST['check_out'],
            $lift,
            $ski
        );
    }
    
}

$accommodationType[] = ["id" => 1, "name" => 'hotel'];
$accommodationType[] = ["id" => 2, "name" => 'hostel'];
$accommodationType[] = ["id" => 3, "name" => 'bozadjiinica'];
$data['accommodationType'] = $accommodationType;
$data["errors"] = $errors;
$app->loadView('header');
$app->loadView('bookform',$data);
$app->loadView('footer');