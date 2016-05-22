<?php

$addresses = [];

foreach ($result->results as $address) {
	$addresses[] = $address->formatted_address;
}


echo json_encode($addresses);

