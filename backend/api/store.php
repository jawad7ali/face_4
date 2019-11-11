<?php
include_once 'connect.php';
include_once 'taskClass.php';


// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	

  // Validate.
  if(trim($request->data->title) === '' || trim($request->data->description) === '')
  {
    return http_response_code(400);
  }
	
  // Sanitize.
  $title = trim($request->data->title);
  $description = trim($request->data->description);
  $dbclass = new DBClass();
  $connection = $dbclass->getConnection();

  $task = new taskClass($connection);
  $task->title = $title;
  $task->description = $description;

  if($task->create()){
    http_response_code(201);
    $task = [
      'title' => $title,
      'description' => $description,
      'id'    => $task->create()
    ];
    echo json_encode(['data'=>$task]);
  }else{
    http_response_code(422);
  }

}


?>