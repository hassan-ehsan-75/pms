<?php
include 'php/security.php';

if(isset($_POST['email'])&&isset($_POST['name'])&&isset($_POST['message'])){
	$seperator="\n----------------------------------------------\n";

	$txt = "Name: ".filter_var($_POST['name'], FILTER_SANITIZE_STRING)."\nE-mail:".filter_var($_POST['email'], FILTER_SANITIZE_STRING)."\nMessage:".filter_var($_POST['message'], FILTER_SANITIZE_STRING).$seperator;
	
	file_put_contents("responses/contacts.txt",$txt,FILE_APPEND);

	putResponse('Got it');
}else{
	throwError('Uncorrect submission');
}


?>