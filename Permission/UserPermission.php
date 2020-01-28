<?php
require_once "Permission.php";
require_once "SpecialWords.php";

function GetUserPermission ($userId){
    return new Permission('',
        [
            new Permission($userId ,
                [
                    new Permission('Adder',[],['POST'])
                ],
                []
            )
        ],
        []
    );
}
