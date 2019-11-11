<?php
include_once 'connect.php';
include_once 'taskClass.php';

$id = ($_GET['id'] !== null && (int)$_GET['id'] > 0)? $_GET['id'] : false;

if(!$id)
{
  return http_response_code(400);
}

$dbclass = new DBClass();
$connection = $dbclass->getConnection();
$task = new taskClass($connection);

if($task->delete($id))
{
  http_response_code(204);
}
else
{
  return http_response_code(422);
}


?>
 