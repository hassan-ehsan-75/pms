<?php

function getAllJobs($public=false){
	$database=new DatabaseConnect();
	if($public)
		$sql = "SELECT * FROM jobs where status='PUBLISHED'";
	else
		$sql = "SELECT * FROM jobs";
	$result = $database->getConnection()->query($sql);

	$jobs_obj=new stdClass();
	//PUSH TOTAL USERS
	$jobs_obj->total=$result->num_rows;
	$jobs_array=array();
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$job_obj=new stdClass();
		
			$job_obj->title= $row["title"];
			$job_obj->content= $row["content"];
		
			$job_obj->summary= strlen(strip_tags($row["content"]))>120?substr(strip_tags($row["content"]),0,120):strip_tags($row["content"]);
			$job_obj->created_at= $row["created_at"];
			$job_obj->updated_at= $row["updated_at"];
			if(!$public){
				$job_obj->id= $row["id"];
			$job_obj->user_id= $row["user_id"];
			$job_obj->status= $row["status"];
			$job_obj->image=getAttachmentById($row["attachment_id"]);
			}else{
				
				$job_obj->image=CDN_LINK.basename(getAttachmentById($row["attachment_id"]));
			}
			



			array_push($jobs_array,$job_obj);
		}
	} 
	$jobs_obj->jobs=$jobs_array;
	$database->close();
	return json_encode($jobs_obj);
}


?>