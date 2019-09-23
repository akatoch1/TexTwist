<?php
$myrack;
//$results;
function generate_rack($n){
  $tileBag = "AAAAAAAAABBCCDDDDEEEEEEEEEEEEFFGGGHHIIIIIIIIIJKLLLLMMNNNNNNOOOOOOOOPPQRRRRRRSSSSTTTTTTUUUUVVWWXYYZ";
  $rack_letters = substr(str_shuffle($tileBag), 0, $n);
  
  $temp = str_split($rack_letters);
  sort($temp);
  return implode($temp);
};
$rack = generate_rack(6);
$myrack = $rack;
$racks = [];
for($i = 0; $i < pow(2, strlen($myrack)); $i++){
		$ans = "";
		for($j = 0; $j < strlen($myrack); $j++){
			//if the jth digit of i is 1 then include letter
			if (($i >> $j) % 2) {
			  $ans .= $myrack[$j];
			}
		}
		if (strlen($ans) > 1){
			$racks[] = $ans;	
		}
	}
$racks = array_unique($racks);

$response = array('letters' => $rack, 'words' => array());
$dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
if (!$dbhandle) die ($error);

foreach ($racks as $r) {
  $query = "SELECT words FROM racks WHERE rack = ?";
  $statement = $dbhandle->prepare($query);
  $statement->bindParam(1, $r, PDO::PARAM_STR);
  $statement->execute();
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
  
  foreach ($results as $row) {
      $response['words'] = array_merge(
          $response['words'],
          explode('@@', $row['words'])
      );
  }
}



echo json_encode($response);





/*function isValid($word) {
    $arr = array();
    foreach($results as $r) {
        $arr = preg_split("/@@/", implode('',$r));
    }
    foreach ($arr as $a) {
        if ($word == $a) {
            return true;
        }
    }
    return false;
}*/

/*$verb = $_SERVER["REQUEST_METHOD"];
switch ($verb) {
    case 'GET':    
      echo json_encode($response);
      break;*/
	/*case 'POST':    
	 $answer = file_get_contents("php://input");	
	 $correct = isValid($answer);
	 // var_dump($answer);
	//	echo file_get_contents("php://input");
      //echo json_encode($correct);
      break; 
  };*/

//echo json_encode(array("rack"=>$myrack, "subracks"=>$racks));




?>