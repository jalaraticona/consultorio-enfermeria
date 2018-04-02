<?php
class helpers
{
/**
 * validación set Value select
 **/
public static function set_value_select($result=array(),$post,$campo,$valor){
    if(sizeof($result)==0){
        if(isset($_POST[$post]) and $_POST[$post]==$valor){
            return 'selected="true"';   
        }
        else{
            return '';
        }
    }
    else{
        if($campo==$valor){
            return 'selected="true"';   
        }
        else{
            return '';
        }
    }
}
/**
* validación set Value checkbox
**/
public static function set_value_checkbox($result=array(),$post,$campo,$valor){
    if(sizeof($result)==0){
        if(isset($_POST[$post])){
            return 'checked="true"';   
        }
        else{
            return '';
        }
    }
    else{
        if($campo==$valor){
            return 'checked="true"';  
        }
        else{
            return '';
        }
    }
}
/**
* validación set Value Producción input
**/
public static function set_value_input($result=array(),$post,$campo){
    if(sizeof($result)==0)
    {
        if(isset($_POST[$post]))
        {
            return $_POST[$post];   
        }
        else{
            return '';
        }
    }
    else{
        if($campo){
            return $campo;   
        }
        else{
            return '';
        }
    }
}
}
