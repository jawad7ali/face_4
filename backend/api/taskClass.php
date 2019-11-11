<?php
class TaskClass{
    //Connection instance
    private $connection;
    //table name
    private $table_name = "tbl_tasks";
    //table columns
    public $id;
    public $title;
    public $description;
    public function __construct($connection){
        $this->connection = $connection;
    }
    //C
    public function create(){
        $form_data = array(
            ':title'  => $this->title,
            ':description'  => $this->description
        );
        $query = "INSERT INTO " . $this->table_name . " (title, description) VALUES(:title, :description)";
        $statement = $this->connection->prepare($query);
        $statement->execute($form_data);
        return $this->connection->lastInsertId();
    }
    //R
    public function read(){
        $query = "SELECT id, title, description FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    //U
    public function update($title,$description, $id){
        $query = "UPDATE ".$this->table_name." SET title='".$title."', description='".$description."' where id='".$id."' ";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return true;
         
    }
    //D
    public function delete($id){
        // sql to delete a record
        $query = "DELETE FROM " . $this->table_name . " WHERE id=".$id." ";
        $stmt = $this->connection->prepare($query);
        
        if($stmt->execute()){
            return true;
        }
    }
    public function getById($id)
    {
        $query = "SELECT id, title, description FROM " . $this->table_name . " where id=".$id." limit 1";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}