<?php

// try to open contacts file
if (!@$f = fopen("contacts", "r")) {
	die("Could not open contacts file. Please check permissions.");
} else {
	/*
	 * first split entries in the file by newline characters to get
	 * individual entries, then split them into multiple parts that
	 * we can use by exploding them by a comma.
	 */
	$contacts = explode(PHP_EOL, fread($f, filesize("contacts")));
	if (empty(end($contacts)))
		array_pop($contacts);
	foreach ($contacts as $key => $entry) {
		$contacts[$key] = explode(',', $entry);
		array_walk($contacts[$key], create_function('&$val', '$val = trim($val);'));
	}
}

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
	<style type="text/css">
		body { font: 14px/25px Helvetica, Arial, sans-serif; }
		table { border-collapse: collapse; margin: 0 auto; width: 100%; }
		td { padding: 5px; width: 50%; text-align: left; }
		tr:hover { background: #ccc !important; }
		tr:nth-child(even) { background: #eee; border-bottom: 1px solid #ccc; }
		div#wrapper { margin: 0 auto; width: 500px; text-align: center; }
		div.entry { margin: 20px 0; }
	</style>
</head>
<body>
	<div id="wrapper">
		<h3>Contacts On File</h3>
		<a href="index.html">Return to form</a>
		<div id="contacts">
			<?php 
				$item = 1;
				foreach ($contacts as $key => $entry) {
					echo "
						<div class='entry'>
						<h3 class='key'>#{$item}</h3>
						<table>
							<tr>
								<td>First Name</td>
								<td>{$entry[0]}</td>
							</tr>
							<tr>
								<td>Last Name</td>
								<td>{$entry[1]}</td>
							</tr>
							<tr>
								<td>Address</td>
								<td>{$entry[2]}</td>
							</tr>
							<tr>
								<td>State</td>
								<td>{$entry[3]}</td>
							</tr>
							<tr>
								<td>Zip</td>
								<td>{$entry[4]}</td>
							</tr>
							<tr>
								<td>Telephone</td>
								<td>" . format_phone($entry[5]) . "</td>
							</tr>
							<tr>
								<td>Email</td>
								<td>{$entry[6]}</td>
							</tr>
						</table>
						</div>
						";
					$item++;
				}
			?>
		</div>
	</div>
</body>
</html>
