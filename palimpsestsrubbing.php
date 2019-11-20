<?php
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 || 
    (substr($haystack, -$length) === $needle);
}

$data = file_get_contents('https://landing.sisal.it/volantini/Scommesse_Sport/Quote/calcio%20omnia%20per%20manifestazione.pdf');
echo $data;
?>

