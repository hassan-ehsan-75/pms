<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'php/security.php';

$response=json_decode(getAllNews($isPublicToken));
	putResponse($response);



?>