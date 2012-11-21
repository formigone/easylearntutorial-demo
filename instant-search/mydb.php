<?php 

// A very simple database helper class to simplify the template parsing
class MyDb {
  private $db;
 
  public function __construct($host, $username, $password, $db) {
    $this->db = mysql_connect($host, $username, $password);
    mysql_select_db($db);
  }
 
  public function __destruct() {
    mysql_close($this->db);
  }
 
  public function select($query) {
    return $this->toArray(mysql_query($query, $this->db));
  }
 
  public function query($query) {
    return mysql_query($query, $this->db);
  }
 
  // Very helpful! Now you can deal directly with native
  // arrays from your queries (or an empty array if nothing is returned)
  private function toArray($results) {
    $arr = array();
 
    while ($row = mysql_fetch_array($results)) {
      $temp = array();
 
      foreach ($row as $key => $val) {
        if (is_string($key))
          $temp[$key] = $val;
      }
 
      array_push($arr, $temp);
    }
 
    return $arr;
  }
}
