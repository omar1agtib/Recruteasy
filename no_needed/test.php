<?php
$formarray = array();
foreach($_POST as $data => $arrayData){
    $formarray[$data] = $arrayData;
}
echo "<pre>";
print_r($formarray) ;
echo "</pre>";
?>