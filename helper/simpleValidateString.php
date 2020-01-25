<?php
    function isSetAndHasValue($owner,string $item):bool{
        return isset($owner[$item])&&!empty($owner[$item]);
    } 