<?php
include 'php/security.php';
$response=json_decode(getAllJobs($isPublicToken));
putResponse($response);

?>