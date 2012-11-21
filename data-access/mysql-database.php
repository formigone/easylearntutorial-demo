<?php

include_once("abstract-database.php");

class MySqlDatabase extends AbstractDatabase {
  public function __construct($host, $username, $password, $databaseName) {
    $this->db = mysql_connect($host, $username, $password);
    mysql_select_db($databaseName, $this->db);
  }
  
  public function __destruct() {
    mysql_close($this->db);
  }
  
  public function select($query) {
    return $this->toArray(mysql_query($query));
  }
  
  private function toArray($res) {
    $arr = array();
    
    while ($row = mysql_fetch_array($res)) {
      $temp = array();
      
      foreach ($row as $key => $val) {
        if (is_string($key))
          $temp[$key] = $val;
      }
      
      array_push($arr, $temp);
    }
    
    return $arr;
  }
  
  public function query($query) {
    return mysql_query($query);
  }
 }

$db = new MySqlDatabase("localhost", "root", "", "test");
 
$results = $db->select("SELECT * FROM users");

var_dump($results);

