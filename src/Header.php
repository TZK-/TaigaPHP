<?php

namespace TZK\Taiga;

class Header
{
    public $name;
    public $value;

    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
