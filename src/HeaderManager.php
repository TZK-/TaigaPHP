<?php

namespace TZK\Taiga;

class HeaderManager
{
    protected $headerShortcuts;

    public function __construct()
    {
        $this->loadHeaderShortcuts();
    }

    /**
     * Convert a camelcased string into a valid HTTP Header name.
     *
     * @see http://www.ietf.org/rfc/rfc2616.txt
     *
     * @param string $name
     *
     * @return string
     */
    public function getHeaderName($name)
    {
        // http://stackoverflow.com/questions/4519739/split-camelcase-word-into-words-with-php-preg-match-regular-expression/7729790
        $regex = '/(?<=[a-z])(?=[A-Z])| (?<=[A-Z])(?=[A-Z][a-z])/x';
        $headerParts = preg_split($regex, $name);

        // Format the array to get a well formed header name (split by dashes if needed).
        // We do not need to worry about the writing since HTTP header field names
        // are case-insensitive according to RFC-2616
        return implode('-', $headerParts);
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

    public function buildHeader($name, $value = null)
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
