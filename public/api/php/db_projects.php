<?php

function getAllProjects($public=false){
	$database=new DatabaseConnect();
	if($public)
		$sql = "SELECT * FROM projects where status='PUBLISHED'";
	else
		$sql = "SELECT * FROM projects";
	$result = $database->getConnection()->query($sql);

	$projects_obj=new stdClass();
	//PUSH TOTAL USERS
	$projects_obj->total=$result->num_rows;
	$project_array=array();
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$project_obj=new stdClass();

			$project_obj->title= $row["title"];
			$project_obj->content= $row["description"];
		
			
			$project_obj->summary= strlen(strip_tags($row["description"]))>120?substr(strip_tags($row["description"]),0,120):strip_tags($row["description"]);
			$project_obj->created_at= $row["created_at"];
			$project_obj->updated_at= $row["updated_at"];
			if(!$public){
			$project_obj->status= $row["status"];
			$project_obj->phase= $row["phase"];
			$project_obj->image=getAttachmentById($row["attachment_id"]);
			}else{
			
			$project_obj->image=CDN_LINK.basename(getAttachmentById($row["attachment_id"]));
			}


			array_push($project_array,$project_obj);
		}
	} 
	$projects_obj->projects=$project_array;
	$database->close();
	return json_encode($projects_obj);
}


?>