<?php
namespace System;


interface IConnection{
    public function __construct($server,$user,$password,$dbName);
    public function Escape($str);
    public function Query($sql);
    public function Execute($sql);
    public function GetValue($sql);
}