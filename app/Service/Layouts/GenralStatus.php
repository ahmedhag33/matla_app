<?php

namespace App\Service\Layouts;

trait GenralStatus
{
    /**
     * Generate a span element with a pill badge
     *
     * @param string $color
     * @param string $value
     *
     * @return string
     */
    protected function span($color, $value)
    {
        $htmlElement = new HtmlElement();
        // Generate a pill badge span element
        $span = $htmlElement->Pillbadges($color, $value);
        // Return the generated span element
        return $span;
    }
}
