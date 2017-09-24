<?php

namespace TZK\Taiga;

class HeaderManager
{
    protected $headerShortcuts;

    public function __construct()
    {
        $this->headerShortcuts = $this->getHeaderShortcuts();
    }

    public function build($name, $value = null)
    {
        if ($this->isShortcut($name)) {
            $name = $this->getName($name);
            $value = $this->getPrefix($name).$value;
        }

        return new Header($name, $value);
    }

    public function getName($name)
    {
        $name = strtolower($name);

        if (isset($this->headerShortcuts[$name]['header'])) {
            return $this->headerShortcuts[$name]['header'];
        }

        return $name;
    }

    public function getPrefix($name)
    {
        $name = strtolower($name);

        if (!$this->isShortcut($name)) {
            return '';
        }

        if (!isset($this->headerShortcuts[$name]['prefix'])) {
            return '';
        }

        return $this->headerShortcuts[$name]['prefix'];
    }

    public function isShortcut($name)
    {
        $name = strtolower($name);

        return isset($this->headerShortcuts[$name]);
    }

    public function getHeaderShortcuts()
    {
        $shortcuts = include __DIR__.'/config/header_shortcuts.php';

        return array_change_key_case($shortcuts, CASE_LOWER);
    }
}
