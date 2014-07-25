<?php
require_once 'Connection.php';

class CharacterFactory
{
  /**
   * @var Connection
   */
  protected $conn;

  public function __construct( $conn = null )
  {
    if (!$conn) {
      $conn = new Connection();
    }
    $this->setConnection( $conn );
    
    return $this;
  }
  
  public function setConnection( $conn )
  {
    $this->conn = $conn;   
  }
 
  public function findById( $id )
  {
    return $this->find(sprintf("id = %u", $id));
  }
  
  public function find( $qry )
  {
    return $this->conn->query(sprintf("SELECT * FROM characters where %s",$qry));
  }
}
