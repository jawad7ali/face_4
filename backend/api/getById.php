<?php
/**
 * Returns the list of Tasks.
 */
include_once 'connect.php';
include_once 'taskClass.php';

// Get the posted data.
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
	
  // Validate.
  if(trim($request->unique_id) == '')
  {
    return;
  }

  $dbclass = new DBClass();
  $connection = $dbclass->getConnection();
  $task = new taskClass($connection);
  $stmt = $task->getById($request->unique_id);
  $count = $stmt->rowCount();

  if($count > 0){
      
      echo json_encode($stmt);
  }else {

      http_response_code(404);
  }
}
exit;