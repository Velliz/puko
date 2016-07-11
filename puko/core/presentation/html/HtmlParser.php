<?php
/**
 * HTML based data parser for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace Puko\Core\Presentation\Html;

use Puko\Core\Presentation\AbstractParser;

class HtmlParser extends AbstractParser
{

    protected $file;
    protected $values;
    protected $stringFile;
    protected $masterFile;

    public function __construct($file)
    {
        parent::__construct(false, false);
        $this->file = $file;
        if (!file_exists($this->file)) {
            if ($this->logs) {
                die("template file not found");
            }
        }
        if (!@file_get_contents($this->file)) {
            echo "View File " . $this->file . " not found.";
            return null;
        }
        $this->stringFile = @file_get_contents($this->file);
        $this->masterFile = @file_get_contents(MASTER . "master.html");
    }

    public function setArrays($arrData)
    {
        if (!isset($arrData)) {
            return null;
        }
        foreach ($arrData as $k => $v) {
            $this->setSingle($k, $v);
        }
    }

    public function setSingle($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function Parse()
    {
        $this->masterFile = str_replace('{CONTENT}', $this->stringFile, $this->masterFile);
        $this->masterFile = str_replace('/url/', ROOT, $this->masterFile);
        if (sizeof($this->values) > 0) {
            foreach ($this->values as $key => $value) {
                $tagReplace = '{!' . $key . '}';
                $openTag = '<!--{!' . $key . '}-->';
                $closeTag = '<!--{/' . $key . '}-->';
                switch ($this->getVarType($value)) {
                    case $this->NUMERIC:
                        $this->masterFile = str_replace($tagReplace, $value, $this->masterFile);
                        break;
                    case $this->STRINGS:
                        $this->masterFile = str_replace($tagReplace, $value, $this->masterFile);
                        break;
                    case $this->ARRAYS:
                        $dynamicTags = null;
                        $ember = $this->getStringBetween($this->masterFile, $openTag, $closeTag);
                        foreach ($value as $key2 => $value2) {
                            $parsed = $this->getStringBetween($this->masterFile, $openTag, $closeTag);
                            foreach ($value2 as $key3 => $value3) {
                                $parsed = str_replace('{!' . $key3 . '}', $value3, $parsed);
                            }
                            $dynamicTags .= $parsed;
                        }
                        $this->masterFile = str_replace($ember, $dynamicTags, $this->masterFile);
                        break;
                    case $this->BOOLEANS:
                        $stanza = $this->blockedConditions($this->masterFile, $key);
                        if (is_null($stanza)) {
                            if ($value != true) {
                                $parsed = $this->getStringBetween($this->masterFile, $openTag, $closeTag);
                                $this->masterFile = str_replace($parsed, '', $this->masterFile);
                            }
                        } else {
                            if ($value == true) {
                                $this->masterFile = str_replace($stanza, '', $this->masterFile);
                            }
                        }
                        break;
                    case $this->NULLS:
                        if ($this->logs) {
                            die('variable null.');
                        }
                        break;
                    case $this->UNDEFINED:
                        if ($this->logs) {
                            die('variable undefined.');
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function ClearOutput()
    {
        return preg_replace('(<!--(.|\s)*?-->)', '', $this->masterFile);
    }

    public function blockedConditions($stanza, $key)
    {
        return $this->getStringBetween($stanza, '<!--{!!' . $key . '}-->', '<!--{/' . $key . '}-->');
    }

    /**
     * @param $string
     * @param $start
     * @param $end
     * @return string
     */
    public function getStringBetween($string, $start, $end)
    {
        $string = " " . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return "";
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function getStyleProperty()
    {
        $keys = $this->getStringBetween($this->masterFile, '@css{', '}');
        $this->masterFile = str_replace('@css{' . $keys . '}', '@css{}', $this->masterFile);
        return explode(',', $keys);
    }

    public function getScriptProperty()
    {
        $keys = $this->getStringBetween($this->masterFile, '@js{', '}');
        $this->masterFile = str_replace('@js{' . $keys . '}', '@js{}', $this->masterFile);
        return explode(',', $keys);
    }

    public function ScriptRender($controllerName, $functionName)
    {
        $arrayScript = $this->getScriptProperty();
        $htmlScripts = '';
        foreach ($arrayScript as $key => $val) {
            $htmlScripts .= "<script async src='" . EXTENSIONS . "js/" . $val . ".js'></script>\n";
        }
        $htmlScripts .= "<script src='" . ROOT . "assets/js/" . $controllerName . "/" . $functionName . ".js'></script>\n";
        $this->masterFile = str_replace('<!--@js{}-->', $htmlScripts, $this->masterFile);
    }

    public function StyleRender($controllerName, $functionName)
    {
        $arrayStyle = $this->getStyleProperty();
        $htmlStylesheet = '';
        foreach ($arrayStyle as $key => $val) {
            $htmlStylesheet .= "<link rel='stylesheet' href='" . EXTENSIONS . "css/" . $val . ".css'>\n";
        }
        $htmlStylesheet .= "<link rel='stylesheet' href='" . ROOT . "assets/css/" . $controllerName . "/" . $functionName . ".css'>\n";
        $this->masterFile = str_replace('<!--@css{}-->', $htmlStylesheet, $this->masterFile);
    }

}