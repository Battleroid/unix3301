<?php

function prepare_input($input) {
	return stripslashes(trim($input));
}

if (!isset($_POST) || empty($_POST) || $_SERVER['REQUEST_METHOD'] != "POST")
	die("Form not submitted. Navigate to the <a href='index.html'>form</a>.");

/*
 * set variables and sanitize them, my function for 'preparing' the input is
 * probably overzealous and not needed, however, it seems to work, though I
 * could do without htmlspecialchars since no HTML is going to be appended
 */
$val['fname']   = prepare_input(filter_var(preg_replace('/[^A-Za-z0-9\s.\s-]/', '', $_POST['fname']), FILTER_SANITIZE_STRING));
$val['lname']   = prepare_input(filter_var(preg_replace('/[^A-Za-z0-9\s.\s-]/', '', $_POST['lname']), FILTER_SANITIZE_STRING));
$val['address'] = prepare_input(filter_var(preg_replace('/[^A-Za-z0-9\#\s.\s-]/', '', $_POST['address']), FILTER_SANITIZE_STRING));
$val['state']   = prepare_input(filter_var(preg_replace('/[^A-Za-z]/', '', $_POST['state']), FILTER_SANITIZE_STRING));
$val['zip']     = prepare_input(filter_var(preg_replace('/[^0-9\-]/', '', $_POST['zip']), FILTER_SANITIZE_STRING));
$val['phone']   = prepare_input(filter_var(preg_replace('/[^0-9]/', '', $_POST['phone']), FILTER_SANITIZE_STRING));
$val['email']   = prepare_input(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
$dest  = (isset($_POST['submitdb']) ? false : true);

// confirm missing required fields
$missing = array();
foreach ($val as $key => $value) {
	if (empty($value) || $value == "") {
		array_push($missing, $key);
	}
}

if (!empty($missing)) {
	die("Missing " . sizeof($missing) . " required fields. Navigate back to the <a href='index.html'>form</a>.");
}

// validation of specific material
if (!filter_var($val['email'], FILTER_VALIDATE_EMAIL))
	die("Email is not in a valid format. Navigate back to <a href='index.html'>form</a>.");

$phone_valid_lengths = array(7, 10, 11);
if (!in_array(strlen($val['phone']), $phone_valid_lengths))
	die("Phone number is not in a valid format. Navigate back to <a href='index.html'>form</a>.");

// save material
if ($dest) {
	if (!@$f = fopen("contacts", "a"))
		die("Could not open contacts file for writing. Please check permissions.");
	fwrite($f, "{$val['fname']}|{$val['lname']}|{$val['address']}|{$val['state']}|{$val['zip']}|{$val['phone']}|{$val['email']}" . PHP_EOL);
	fclose($f);
} else {
	$db = new PDO("mysql:host=localhost;dbname=unix;charset=UTF8", "user", "pass");
	$data = array(
		':fname' => $val['fname'],
		':lname' => $val['lname'],
		':address' => $val['address'],
		':state' => $val['state'],
		':zip' => $val['zip'],
		':phone' => $val['phone'],
		':email' => $val['email']
	);
	$stmt = $db->prepare("INSERT INTO contacts (fname, lname, address, state, zip, phone, email) values (:fname, :lname, :address, :state, :zip, :phone, :email)");
	$stmt->execute($data);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Assignment 3 - Thank you!</title>
	<link rel="stylesheet" href="default.css">
</head>
<body>
	<div id="wrapper">
		<h3>Thank you for registering!</h3>
		<div id="output">
		<table>
			<tr>
				<td>First Name</td>
				<td><?php echo $val['fname']; ?></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><?php echo $val['lname']; ?></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><?php echo $val['address']; ?></td>
			</tr>
			<tr>
				<td>State</td>
				<td><?php echo $val['state']; ?></td>
			</tr>
			<tr>
				<td>Zip</td>
				<td><?php echo $val['zip']; ?></td>
			</tr>
			<tr>
				<td>Telephone</td>
				<td><?php echo $val['phone']; ?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><?php echo $val['email']; ?></td>
			</tr>
		</table>
		<a href="index.html">Return to form</a>
		</div>
	</div>
</body>
</html>
