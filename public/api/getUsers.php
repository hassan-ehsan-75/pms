<?php
include 'php/security.php';
$response=json_decode(getAllUsers($isPublicToken));
putResponse($response);
?>