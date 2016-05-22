<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

$addresses = [];


if (!empty($result)) {
	foreach ($result->results as $address) {
		$addresses[] = $address->formatted_address;
	}
}

echo json_encode(['addresses' => $addresses]);

