<?php

namespace System;


interface Items{
    public function removeItemById($id) ;

    public function addItem($object) ;

    public function items();
}