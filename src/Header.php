<?php

namespace TZK\Taiga;

class Header
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    public function __construct($name, $value = null)
    {
        $this->name = self::sanitize($name);
        $this->value = $value;
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
    public static function sanitize($name)
    {
        // http://stackoverflow.com/questions/4519739/split-camelcase-word-into-words-with-php-preg-match-regular-expression/7729790
        $regex = '/(?<=[a-z])(?=[A-Z])| (?<=[A-Z])(?=[A-Z][a-z])/x';
        $headerParts = preg_split($regex, $name);

        // Format the array to get a well formed header name (split by dashes if needed).
        // We do not need to worry about the writing since HTTP header field names
        // are case-insensitive according to RFC-2616
        return implode('-', $headerParts);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}
