<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function group_by($array, $item) {
    $result = array();
    $items = array();
    /* crea asigna el id para que sea unico */
    if(count($array) > 0){
    foreach ($array as $data) {
        $id = $data[$item];
        $result[$id] = $data;
    }
    $i = 0;
    foreach ($result as $data) {
        $items[$i] = $data;
        $i++;
    }
    
    }
    return $items;
}
