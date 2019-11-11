<?php
/**
 * Returns the list of Tasks.
 */
include_once 'connect.php';
include_once 'taskClass.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();
$task = new taskClass($connection);
$stmt = $task->read();
$count = $stmt->rowCount();

if($count > 0){
    $tasks = [];
    //$tasks["count"] = $count;
    $i = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $tasks[$i]['id']    = $id;
        $tasks[$i]['title'] = $title;
        $tasks[$i]['description'] = $description;
        $i++;
    }
    echo json_encode(['data'=>$tasks]);
}else {

    http_response_code(404);
}
?>

