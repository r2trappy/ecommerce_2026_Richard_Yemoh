<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url() . 'views/register.php');
}


$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = trim(strip_tags($_POST['email'] ?? ''));
$pass    = $_POST['pass'] ?? '';
$country = trim(strip_tags($_POST['country'] ?? ''));
$city    = trim(strip_tags($_POST['city'] ?? ''));
$contact = trim(strip_tags($_POST['contact'] ?? ''));

$error = null;

if ($name === '' || strlen($name) < 2) {
    $error = 'Please enter your full name.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Please enter a valid email address.';
} elseif (strlen($email) > 50) {
    $error = 'Email must be 50 characters or fewer.';
} elseif (strlen($pass) < 8 || !preg_match('/\d/', $pass)) {
    $error = 'Password must be at least 8 characters and include a number.';
} elseif ($contact !== '' && !preg_match('/^[0-9+\-\s]{7,15}$/', $contact)) {
    $error = 'Please enter a valid contact number.';
}

if ($error) {
    $_SESSION['error'] = $error;
    redirect(base_url() . 'views/register.php');
}

$controller = new CustomerController();
$result = $controller->register([
    'name' => $name, 'email' => $email, 'pass' => $pass,
    'country' => $country, 'city' => $city, 'contact' => $contact,
]);

if ($result['success']) {
    $_SESSION['customer_id']    = $result['customer']['customer_id'];
    $_SESSION['customer_name']  = $result['customer']['customer_name'];
    $_SESSION['customer_email'] = $result['customer']['customer_email'];
    $_SESSION['user_role']      = $result['customer']['user_role'];
    redirect(base_url() . 'views/account/my_account.php');
} else {
    $_SESSION['error'] = $result['error'];
    redirect(base_url() . 'views/register.php');
}
