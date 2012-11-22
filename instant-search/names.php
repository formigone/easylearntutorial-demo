<?php

require_once "mydb.php";

// A simple enumeration like structure
class MatchType {
	const BEGINS_WITH = 0;
	const ENDS_WITH = 1;
	const CONTAINS = 2;
}

// Send serialized data back to the view instead of returning HTML
function processRequest($query, $matchType) {
  $db = new MyDb("localhost", "root", "", "easylearntutorial_demo");
 
  switch ($matchType) {
    case MatchType::BEGINS_WITH:
      $like = "'{$query}%'";
      break;
    case MatchType::ENDS_WITH:
      $like = "'%{$query}'";
      break;
    default:
      $like = "'%{$query}%'";
  }
 
  $matches = $db->select("SELECT * FROM names WHERE name LIKE $like ORDER BY name ASC");
  echo json_encode(array("matches" => $matches));
}
 
// Take incoming parameters from HTTP request and respond to it
$query = $_REQUEST["query"];
$matchType = isset($_REQUEST["matchType"]) ? $_REQUEST["matchType"] : MatchType::CONTAINS;
 
processRequest($query, $matchType);