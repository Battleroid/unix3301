<?php

// try to open contacts file
if (!@$f = fopen("contacts", "r")) {
	die("Could not open contacts file (no entries?). Please check permissions.");
} else {
	/*
	 * first split entries in the file by newline characters to get
	 * individual entries, then split them into multiple parts that
	 * we can use by exploding them by a '|' for each field.
	 */
	$contacts = explode(PHP_EOL, fread($f, filesize("contacts")));
	if (empty(end($contacts)))
		array_pop($contacts);
	foreach ($contacts as $key => $entry) {
		$contacts[$key] = explode('|', $entry);
		array_walk($contacts[$key], create_function('&$val', '$val = trim($val);'));
	}
}

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
	<title>Assignment 3 - Contacts On File</title>
	<link rel="stylesheet" href="default.css">
</head>
<body>
	<div id="wrapper">
		<h3>Contacts On File</h3>
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
				foreach ($contacts as $key => $entry) {
					echo "
							<tr>
								<td>{$item}</td>
								<td>{$entry[0]}</td>
								<td>{$entry[1]}</td>
								<td>{$entry[2]}</td>
								<td>{$entry[3]}</td>
								<td>{$entry[4]}</td>
								<td>" . format_phone($entry[5]) . "</td>
								<td>{$entry[6]}</td>
							</tr>
						";
					$item++;
				}
?>
			</table>
		</div>
</body>
</html>
