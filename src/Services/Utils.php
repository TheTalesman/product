<?php

namespace App\Services;
class Utils{

    /**
     * @return array
     * Function used to join arrays and itens, removing dupes into a single array, the performatic way. 
     */
    public function joinArray(array $array , ...$mixed){
        //Push itens into array (foreach > array_push)
        foreach ($mixed as $arrayOrItem) {
            foreach ($arrayOrItem as $item) {
                $array[] = $item;
                
            }
            
        }
        //Remove dupes (array_keys > array_unique)
        
        return array_unique($array);
    }
    
    public function turnArrayToString(array $array){
        $array = array_unique($array);
        $string = "[";
        foreach ($array as $item) {
            if ($item != ""){
                $string = $string."\"".$item."\"".",";
            }
        }
        $string = rtrim($string, ',');
        $string .= "]";
        return $string;
    }

}
