<?php namespace Tschallacka\MageRain\Helper\Xml;

class Xml 
{
    /**
     * Makes the dom document pretty formatted. 
     * call this right before saving.
     * @param \DOMDocument $input
     * @return \DOMDocument prettified dom document
     */
    public function prettify(\DOMDocument $input) 
    {
        $fresh_dom = new \DOMDocument();
        $fresh_dom->preserveWhiteSpace = false;
        $fresh_dom->formatOutput = true;
        $fresh_dom->loadXML($input->saveXML());
        return $fresh_dom;
    }
}