<?php

header('Access-Control-Allow-Origin: *');

$addresses = [];


if (!empty($result)) {
	foreach ($result->results as $address) {
		$addresses[] = $address->formatted_address;
	}
}

echo json_encode($addresses);

