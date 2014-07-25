<?php
class Connection
{
  private $link;
  private $mode;
  public  $debug;
  public  $num_rows;

  function __construct()
  {
    include "_config.php";
    $this->link = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_PORT);
  }
  
  function __destruct()
  {
    $this->closeConnection();    
  }
  
  public function sanitize( $str )
  {
    $str = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $str);
    return trim($this->link->real_escape_string( $str ));
  }
  
  public function closeConnection()
  {
    if (is_null($this->link)) {
      return;
    }
    $this->link->close(); 
    $this->link = null;
  }
  
  public function query($sql, $ret = 'true')
  {
    $q = $this->link->query($sql);
    
    if (!$q) {
      if ($this->mode) {
        $exceptionMsg = "There was an error running statement: " . $sql . ", Error: " . $this->link->error;
        throw new ErrorException($exceptionMsg);
      }
      return false;
    }

    if ($ret) {
      $arr = array();
      $this->num_rows = $q->num_rows;
      while ($row=$q->fetch_object()) {
        $arr[] = $row;
      }
      if (count($arr)==1) {
        return $arr[0];
      }
      if (count($arr)==0) {
        return null;
      }
      return $arr;    
    } else {
      return $this->lastId();
    }       
  }
  
  public function lastId()
  {
    $arr = $this->query("SELECT last_insert_id() AS id", true);
    if (is_array($arr)) {
      return $arr[0]->id;
    }
    return $arr->id;
  }
}