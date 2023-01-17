<?php
include 'php/security.php';

$jobs=json_decode(getAllJobs($isPublicToken));
$news=json_decode(getAllNews($isPublicToken));
$users=json_decode(getAllUsers($isPublicToken));
$projects=json_decode(getAllProjects($isPublicToken));
$response=new stdClass();
$response->jobs=$jobs;
$response->news=$news;
$response->users=$users;
$response->projects=$projects;
putResponse($response);



?>