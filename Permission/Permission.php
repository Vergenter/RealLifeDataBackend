<?php
require_once 'Comparator.php';

class Permission{
    public $Name;
    public $Permissions=[];
    public $Method=[];
    public function __construct($name,$permissions,$methods)
    {
        $this->Name=$name;
        $this->Permissions=$permissions;
        $this->Method=$methods;
    }
    public function getPermission($name){
        return array_filter($this->Permissions,function ($permission) use(&$name){
            return comparePermission($name,$permission->Name);
        });
    }
    public function hasMethod($name){
        return in_array($name, $this->Method);
    }
}