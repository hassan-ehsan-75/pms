<?php

function getAllNews($public=false){
	$database=new DatabaseConnect();
	if($public)
		$sql = "SELECT * FROM news where status='PUBLISHED'";
	else
		$sql = "SELECT * FROM news";
	$result = $database->getConnection()->query($sql);

	$newss_obj=new stdClass();
	//PUSH TOTAL USERS
	$newss_obj->total=$result->num_rows;
	$news_array=array();
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$user_obj=new stdClass();
			
			$user_obj->title= $row["title"];
			$user_obj->content= $row["content"];
		
			$user_obj->summary= strlen(strip_tags($row["content"]))>120?substr(strip_tags($row["content"]),0,120):strip_tags($row["content"]);
			$user_obj->created_at= $row["created_at"];
			$user_obj->updated_at= $row["updated_at"];
			if(!$public){
				$user_obj->status= $row["status"];
				$user_obj->id= $row["id"];
				$user_obj->user_id= $row["user_id"];
					$user_obj->image=getAttachmentById($row["attachment_id"]);
			}else{
					$user_obj->image=CDN_LINK.basename(getAttachmentById($row["attachment_id"]));
			}
			
			
	
			array_push($news_array,$user_obj);
		}
	} 
	$newss_obj->news=$news_array;
	$database->close();
	return json_encode($newss_obj);
}


?>