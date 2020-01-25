<?php
interface IModule{
    public function getChild($childName);
    public function callMethod($methodType): int;
}