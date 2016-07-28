<?php
function loader($fileName){
    dd($fileName);
}

spl_autoload_register("loader");
?>