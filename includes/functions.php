<?php


function encodeDate($date){
    $array = explode('-',$date);
    $year = $array[0];
    $month = $array[1];
    $day = $array[2];

    //string split
    $array_year = str_split($year,2);
    $a = $array_year[0];
    $b = $array_year[1];

    $return_string = $b.''.$month.''.$day;
    return $return_string;
}