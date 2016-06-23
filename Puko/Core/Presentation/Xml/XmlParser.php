<?php

/**
 * Parser engine for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 1.0
 * @package Puko Core
 */
class XmlParser
{

    private $xml_data;
    private $data;

    public function __construct($data)
    {
        $this->xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        $this->data = $data;
    }

    function array_to_xml($data, &$xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key; //dealing with <0/>..<n/> issues
                }
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    public function Output()
    {
        $this->array_to_xml($this->data, $this->xml_data);
        return $this->xml_data->asXML();
    }
}