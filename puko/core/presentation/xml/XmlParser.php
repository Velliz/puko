<?php
namespace puko\core\presentation\xml;

use puko\core\presentation\AbstractParser;

/**
 * Parser engine for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 1.0
 * @package Puko Core
 */
class XmlParser extends AbstractParser
{

    private $xml_data;
    private $data;
    private $procesStart;

    public function __construct($var, $start)
    {
        parent::__construct(false, false);
        $this->xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        $this->data = $var;
        $this->procesStart = $start;
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

    /**
     * @param $controllerName
     * @param $functionName
     * @return mixed
     */
    public function ScriptRender($controllerName, $functionName)
    {
        // TODO: Implement ScriptRender() method.
    }

    /**
     * @param $controllerName
     * @param $functionName
     * @return mixed
     */
    public function StyleRender($controllerName, $functionName)
    {
        // TODO: Implement StyleRender() method.
    }
}