<?php

namespace App\Service\Layouts;

class HtmlElement
{
    /**
     * hold all the attributes of the HTML element
     *
     * @var array
     */
    private $attributes = [];
    /**
     *  __set
     *
     * @param mixed $name
     *
     * @param mixed $value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
    /**
     *  __get
     *
     * @param mixed $name
     *
     * @return object|void
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
    }
    /**
     * Generate a pill badge span element
     *
     * @param string $class
     * @param string $value
     *
     * @return string
     */
    public function pillbadges($class, $value)
    {
        $span = '<span class="badge badge-pill badge-' . $class . '">' . $value . '</span>';

        return $span;
    }
}
