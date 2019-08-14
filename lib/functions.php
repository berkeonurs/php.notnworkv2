<?php
function makeArray($oldArray,$index,$indexes){
    $newArray = [];
    foreach ($oldArray as $value){
        if(isset($newArray[$value[$index]])) array_push($newArray[$value[$index]]['data'],makeColumn($value,$indexes));
        else{
            $newArray[$value[$index]]['info']=makeInfo($value,$indexes);
            $newArray[$value[$index]]['data'][0]=makeColumn($value,$indexes);
        }
    }
    return $newArray;
}
function makeColumn($oldArray,$indexes){
    $newArray = [];
    foreach ($oldArray as $index=>$value){
        if(in_array($index, $indexes)) $newArray[$index] = $value;
    }
    return $newArray;
}
function makeInfo($oldArray,$indexes){
    $newArray = [];
    foreach ($oldArray as $index=>$value){
        if(!in_array($index, $indexes)) $newArray[$index] = $value;
    }
    return $newArray;
}
