<?php
ini_set('max_execution_time', 3000);
set_time_limit ( 3000 );
ignore_user_abort();
$opts = array('http' =>
    array(
        'header'  => 'User-agent: Mozilla/5.0 (Linux; Android 4.4.4; HM NOTE 1LTEW Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 MicroMessenger/6.0.0.54_r849063.501 NetType/WIFI',
    )
);

$context  = stream_context_create($opts);
$data_matchpoint = file_get_contents('http://www.betcalcio.it/home/Risultati-Scommesse.html?sid={4579B5D0-7D87-4442-B5CE-BD15F4FFC099}&basket=palbook&idb=4&bm=matchpoint',false,$context);
$array_matchpoint = separateString($data_matchpoint);
$all_match_array = $array_matchpoint;

$context  = stream_context_create($opts);
$data_snai = file_get_contents('http://www.betcalcio.it/home/home.asp?sid={CA67B820-57A4-4F05-9164-EED45F3E254A}&basket=palbook&idb=1&bm=snai',false,$context);
$array_snai = separateString($data_snai);
$all_match_array = joinWithPalimpsest($all_match_array,$array_snai);

$context  = stream_context_create($opts);
$data_better = file_get_contents('http://www.betcalcio.it/home/home.asp?sid={CA67B820-57A4-4F05-9164-EED45F3E254A}&basket=palbook&idb=6&bm=better',false,$context);
$array_better = separateString($data_better);
$all_match_array = joinWithPalimpsest($all_match_array,$array_better);

$context  = stream_context_create($opts);
$data_bwin = file_get_contents('http://www.betcalcio.it/home/home.asp?sid={CA67B820-57A4-4F05-9164-EED45F3E254A}&basket=palbook&idb=8&bm=bwin',false,$context);
$array_bwin = separateString($data_bwin);
$all_match_array = joinWithPalimpsest($all_match_array,$array_bwin);

date_default_timezone_set('Europe/Rome');//or change to whatever timezone you want
//file_put_contents(date("d").".txt",print_r($all_match_array,true));
//joinFilesAndPublishResult();
print_r($all_match_array);

?>

<?php

function separateString($string_bet) {
  $tok = strtok($string_bet, ' >');
  $index = 0;
  $array = array();
    while ($tok !== false) {
      $tok = strtok( ' ');
      if($tok == 'title="CONFRONTO'){
          $tok = strtok( '>');
          $word = "";
          while($tok != 'title="CONFRONTO'){
              $tok = strtok( ' ');
              if($tok != 'title="CONFRONTO'){
                  $word = $word." ".$tok;
              }
              else{
                  $yummy   = array("</td>", "<td>");
                  $word = str_replace($yummy, " ", $word);
                  $word = strip_tags($word);
                  $array[$index] = $word;
                  $word = "";
                  $index++;
              }
          }
      }
    }
    return $array;
}

function joinFilesAndPublishResult(){
    $first_file = file("01.txt");
    $result_array = $first_file;
    for($file = 2;$file<=31;$file++){
        $file = (string)$file;
        if(strlen($file)==1){
            $file = "0".$file;
        }
        $current_array = file($file.".txt");

        $result_array = joinWithPalimpsest($result_array,$current_array);
    }
   // file_put_contents("all_palimpsest.txt",print_r($result_array,true));
}

function joinWithPalimpsest($array_one,$array_two){
  $pali_one = getPalimpsest($array_one);
  $pali_two = getPalimpsest($array_two);
  $array_pali = array_values(array_unique(array_merge($pali_one,$pali_two)));

  $array_result;
  $arr_merge = array_merge($array_one,$array_two);
  for($i=0;$i<=count($array_pali);$i++){
    for($j=0;$j<=count($arr_merge);$j++){
        if($array_pali[$i] == getPalimpsestFromString($arr_merge[$j])){
          $array_result[] = $arr_merge[$j];
          break;
        }
    }
  }
  return $array_result;
}

function getPalimpsestFromString($string_pali){
  $tok = strtok($string_pali, ' ');
  while ($tok !== false) {
      $tok = strtok( ' ');
      if(!preg_match('#[^0-9]#',$tok)){
          $tok_two = strtok( ' ');
          if(!preg_match('#[^0-9]#',$tok_two)){
              $word = $tok.$tok_two;
              $array_out[$index] = $word;
              $tok_three = strtok( ' ');
              if(!preg_match('#[^0-9]#',$tok_three)){
                  $word = $tok_two.$tok_three;
              }
              return $word;
          }
      }
  }
}

function getPalimpsest($array_match){
    $array_out;
    $index = 0;
    for($i = 0;$i<=count($array_match);$i++){
        $tok = strtok($array_match[$i], ' ');
        while ($tok !== false) {
            $tok = strtok( ' ');
            if(is_numeric($tok)){
                $tok_two = strtok( ' ');
                if(is_numeric($tok_two)){
                    $word = $tok.$tok_two;
                    $array_out[$index] = $word;
                    $tok_three = strtok( ' ');
                    if(is_numeric($tok_three)){
                        $word = $tok_two.$tok_three;
                        $array_out[$index] = $word;
                    }
                    $index++;
                    break;
                }
            }
        }
    }
    return $array_out;
}
?>
