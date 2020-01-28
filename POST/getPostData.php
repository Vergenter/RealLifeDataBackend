<?php
function GetPostData(){
    $x=file_get_contents('php://input');
    return json_decode($x,true);
}