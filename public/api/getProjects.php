<?php
include 'php/security.php';
$response=json_decode(getAllProjects($isPublicToken));
putResponse($response);

?>