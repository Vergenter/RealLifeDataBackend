<?php
require_once "Permission.php";

function GetNoPermission (){
    return new Permission('',[],[]);
}