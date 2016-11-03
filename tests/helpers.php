<?php

if(! function_exists('config_path')){
    function config_path($path = ''){
        return getcwd() . $path;
    }
}