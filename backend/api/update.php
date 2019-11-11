<?php
require 'connect.php';
include_once 'taskClass.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if ((int)$request->data->id < 1 || trim($request->data->title) == '' || trim($request->data->description) === '') {
    return http_response_code(400);
  }
  
  // Update.
  $dbclass = new DBClass();
  $connection = $dbclass->getConnection();
  $task = new taskClass($connection);

  if($task->update($request->data->title,$request->data->description,$request->data->id))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }
}
