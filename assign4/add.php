<?php

if (isset($_POST) && !empty($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
	if ($_POST['amount'] % 25 != 0 || $_POST['amount'] > 100)
		die("Improper input, try again.");
}

// create random numbers of length
function num_rand($len, $zero = true) {
	$output = "";
	for ($i = 0; $i < $len; $i++) {
		if ($zero) {
			$output .= mt_rand(0, 9);
		} else {
			$output .= mt_rand(1, 9);
		}
	}
	return $output;
}

// create psuedo random email based off name
function email($first, $last, $domain) {
	$output = "";
	$output .= substr($first, 0, mt_rand(1, strlen($first)));
	$output .= substr($last, 0, mt_rand(1, strlen($first)));
	$output .= num_rand(mt_rand(0, 3));
	$output .= "@" . $domain;
	return strtolower($output);
}

function address($street) {
	return num_rand(mt_rand(1, 4), false) . " " . $street;
}

$fname = array("John", "Mary", "Zach", "Alex", "Andrew", "Sara", "Jessica");
$lname = array("Smith", "Patrick", "Moore", "Miller", "Williams");
$state = array("AL", "AK", "AS", "AZ", "AR", "CA", "CO", "CT", "DE", "DC", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "MP", "OH", "OK", "OR", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY");
$address = array("Candy Road", "Chocolate Lane", "Imaginary Ave", "Mainstreet");
$email = array("gmail.com", "outlook.com", "yahoo.com", "lavabit.com");

/* initialize array with keys outside of loop to avoid continuously restating it 
 * instead just change the values
 */
$db = new PDO("mysql:host=localhost;dbname=unix;charset=UTF8", "user", "pass");
$stmt = $db->prepare("INSERT INTO contacts (fname, lname, address, state, zip, phone, email) values (:fname, :lname, :address, :state, :zip, :phone, :email)");
$data = array(
	':fname' => '',
	':lname' => '',
	':address' => '',
	':state' => '',
	':zip' => '',
	':phone' => '',
	':email' => ''
);
$good = 0;
for ($i = 0; $i < $_POST['amount']; $i++) {
	$first = $fname[array_rand($fname)];
	$last = $lname[array_rand($lname)];
	$data[':fname'] = $first;
	$data[':lname'] = $last;
	$data[':address'] = address($address[array_rand($address)]);
	$data[':state'] = $state[array_rand($state)];
	$data[':zip'] = num_rand(5);
	$data[':phone'] = num_rand(10);
	$data[':email'] = email($first, $last, $email[array_rand($email)]);
	if ($stmt->execute($data))
		$good++;
}

if (isset($_POST) && !empty($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
	if ($good == $_POST['amount']) {
		echo "<h3 class='good'>All contacts ({$_POST['amount']}) inserted successfully.</h3>";
	} else {
		echo "<h3 class='bad'>Only {$good} out of {$_POST['amount']} contacts were inserted!</h3>";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Assignment 4 - Add Contacts</title>
	<style>
		.good {color:#7E8507;}
		.bad {color:#BF364A;}
	</style>
</head>
<body>
	<div id="wrapper">
		<h4>Add Random Contacts</h4>
		<form action="add.php" method="post">
			<label for="amount">Amount</label>
			<select id="amount" name="amount">
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="75">75</option>
				<option value="100">100</option>
			</select>
			<input type="submit" value="Add">
		</form>
	</div>
</body>
</html>
