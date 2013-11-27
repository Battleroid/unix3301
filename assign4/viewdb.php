<?php

$db = new PDO("mysql:host=localhost;dbname=unix;charset=UTF8", "user", "pass");
$stmt = $db->prepare("SELECT fname, lname, address, address, state, zip, phone, email FROM contacts");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
 * format phone number based on number of digits,
 * if format is not of a 'somewhat' predictable
 * pattern then let us know it's not standard
 */
function format_phone($input) {
	switch (strlen($input)) {
		case 7:
			$input = substr($input, 0, 3) . "-" . substr($input, 3);
			break;
		case 10:
			$input = substr($input, 0, 3) . "-" . substr($input, 3);
			$input = substr($input, 0, 7) . "-" . substr($input, 7);
			break;
		case 11:
			$input = substr($input, 0, 1) . "-" . substr($input, 1);
			$input = substr($input, 0, 5) . "-" . substr($input, 5);
			$input = substr($input, 0, 9) . "-" . substr($input, 9);
			break;
		default:
			$input .= " (Unknown Format)";
			break;
	}
	return $input;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Assignment 4 - Contacts In Database</title>
	<link rel="stylesheet" href="default.css">
</head>
<body>
	<div id="wrapper">
		<h3>Contacts In Database</h3>
		<a href="index.html">Return to form</a>
	</div>
		<div id="contacts">
			<table>
				<tr>
					<th>#</th>
					<th>First</th>
					<th>Last</th>
					<th>Address</th>
					<th>State</th>
					<th>Zip</th>
					<th>Telephone</th>
					<th>Email</th>
				</tr>
			<?php 
				$item = 1;
				foreach ($data as $entry) {
					echo "
						<tr>
							<td>{$item}</td>
							<td>{$entry['fname']}</td>
							<td>{$entry['lname']}</td>
							<td>{$entry['address']}</td>
							<td>{$entry['state']}</td>
							<td>{$entry['zip']}</td>
							<td>" . format_phone($entry['phone']) . "</td>
							<td>{$entry['email']}</td>
						</tr>
					";
					$item++;
				}
			?>
			</table>
		</div>
</body>
</html>
