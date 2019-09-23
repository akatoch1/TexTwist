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

$myrack = generate_rack(6);
$racks = [];
function permutations() {
    for($i = 0; $i < pow(2, strlen($myrack)); $i++){
	$ans = "";
	for($j = 0; $j < strlen($myrack); $j++) {
		//if the jth digit of i is 1 then include letter
		if (($i >> $j) % 2) {
		  $ans .= $myrack[$j];
		}
	}
	if (strlen($ans) > 1){
  	    $racks[] = $ans;	
	}
}
}
$racks = array_unique($racks);

$dbhandle  = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
if (!$dbhandle) die ($error);
$query = 'SELECT words FROM racks WHERE rack="'. $rack . '"';
$statement = $dbhandle->prepare($query);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);
    #print_r($results



function isValid($word) {
	
	$temp = $word;
    $temp = str_split($temp);
    sort($temp);
    $temp = implode('', $temp);
	foreach ($racks as $r) {
        if ($temp === $r) {
            $lis = query_rack($temp);
			$temp1 = array();
			foreach($results as $res) {
				$temp1 = preg_split("/@@/", implode('',$res));
			}
			foreach ($temp1 as $value) {
				if ($word == $value) {
					return true;
				}
			}
			return false;
		}
	}
	return false;
    
}

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

$verb = $_SERVER["REQUEST_METHOD"];
switch ($verb) {
    case 'GET':    
      echo json_encode(array("rack"=>$myrack, "subracks"=>$racks));
      break;
	case 'POST':    
	 $answer = file_get_contents("php://input");	
	 $correct = checkCombination($answer);
	 // var_dump($answer);
	//	echo file_get_contents("php://input");
      //echo json_encode($correct);
      break; 
  };

//echo json_encode(array("rack"=>$myrack, "subracks"=>$racks));




?>