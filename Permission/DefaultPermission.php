<?php
require_once "Permission.php";
require_once "SpecialWords.php";

function GetDefaultPermission (){
    return new Permission('',
        [
            new Permission('Account',
                [
                    new Permission(Words::ANY,[],['HEAD'])
                ],
                ['POST']
            ),
            new Permission('Token',[],['GET'])
        ],
        []
    );
}
