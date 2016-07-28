<?php
defined('ACCESS') OR exit('No direct script access allowed');

function showErrors($error="")
{
    echo "<h2>".$error."<h2>";
    exit();
}