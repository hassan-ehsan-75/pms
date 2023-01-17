<?php

//¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤//
function getUserPictureUrlById($id){
	$database=new DatabaseConnect();
	
	$stmt = $database->getConnection()->prepare("SELECT attachment_url FROM attachments where user_id=? and title is NULL");
	$stmt->bind_param("i", $id_par);
	
	$id_par=$id;
	
    $stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($attachment_url_ret);

	$url=null;
	while($stmt->fetch()){
		$url= $attachment_url_ret;

	}
	$stmt->close();
	$database->close();
	
	return $url;
}


function getAttachmentById($id){
	$database=new DatabaseConnect();
	
	$stmt = $database->getConnection()->prepare("SELECT attachment_url FROM attachments where id=?");
	$stmt->bind_param("i", $id_par);
	
	$id_par=$id;
	
    $stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($attachment_url_ret);

	$url=null;
	while($stmt->fetch()){
		$url= $attachment_url_ret;

	}
	$stmt->close();
	$database->close();
	
	return $url;
}


?>