<?php

namespace TZK\Taiga;

class HeaderManager
{
    protected $headerShortcuts;

    public function __construct()
    {
        $this->loadHeaderShortcuts();
    }

    protected function hasPrefix($name)
    {
        return $this->hasShortcut($name) & !is_null($this->headerShortcuts[$name]['prefix']);
    }

    protected function hasShortcut($name)
    {
        return isset($this->headerShortcuts[$name]['prefix']);
    }

    protected function loadHeaderShortcuts()
    {
        $this->headerShortcuts = include __DIR__.'/header_shortcuts.php';
        $this->headerShortcuts = array_change_key_case($this->headerShortcuts, CASE_LOWER);

        return $this;
    }

    public function build($name, $value = null)
    {
        if ($this->hasShortcut($name)) {
            $name = $this->headerShortcuts[$name]['header'];

            $prefixValue = '';
            if ($this->shouldPrefix($name)) {
                $prefixValue = $this->headerShortcuts[$name]['prefix'];
            }

            $value = $prefixValue.$value;
        }

        return new Header($name, $value);
    }
}
