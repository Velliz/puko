<?php

namespace Puko\Core\Presentation\Html;

use Puko\Core\Presentation\AbstractParser;

class HtmlParser extends AbstractParser
{
    
    protected $file;
    protected $values;
    protected $stringFile;
    protected $masterFile;

    protected $valueRules;
    protected $loopRulesHead;
    protected $loopRulesTail;

    protected $templateBlockedRulesOpen;
    protected $templateBlockedRulesClosed;

    public function __construct($file)
    {
        parent::__construct(false, false);
        
        $this->setValueRule("{!", "}");
        $this->setOpenLoopRule("{!", "}");
        $this->setClosedLoopRule("{/", "}");

        $this->setOpenBlockedRule("{!!", "}");
        $this->setClosedBlockedRule("{/", "}");

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

    public function setValueRule($tagOpen, $tagClose)
    {
        $this->valueRules = null;
        $this->valueRules[$tagOpen] = $tagClose;
    }

    public function setOpenLoopRule($tagOpen, $tagClose)
    {
        $this->loopRulesHead[$tagOpen] = $tagClose;
    }

    public function setClosedLoopRule($tagOpen, $tagClose)
    {
        $this->loopRulesTail[$tagOpen] = $tagClose;
    }

    public function setOpenBlockedRule($tagOpen, $tagClose)
    {
        $this->templateBlockedRulesOpen[$tagOpen] = $tagClose;
    }

    public function setClosedBlockedRule($tagOpen, $tagClose)
    {
        $this->templateBlockedRulesClosed[$tagOpen] = $tagClose;
    }

    public function output(){
        if (!isset($this->values)) {
            $this->ReturnEmptyRender();
        }

        if(sizeof($this->values) > 0) {
            foreach ($this->values as $key => $value) {
                foreach ($this->valueRules as $head => $tail) {
                    $tagReplace = $head . $key . $tail;

                    switch ($this->getVarType($value)) {
                        case $this->NUMERIC:
                            $this->stringFile = str_replace($tagReplace, $value, $this->stringFile);
                            $this->masterFile = str_replace($tagReplace, $value, $this->masterFile);
                            break;
                        case $this->STRINGS:
                            $this->stringFile = str_replace($tagReplace, $value, $this->stringFile);
                            $this->masterFile = str_replace($tagReplace, $value, $this->masterFile);
                            break;
                        case $this->ARRAYS:
                            // todo : enhancement to loop in the loop
                            $dynamicTags = '';
                            $openTag = '';
                            $closeTag = '';
                            foreach ($this->loopRulesHead as $loopOpenHead => $loopOpenTail) {
                                foreach ($this->loopRulesTail as $loopCloseHead => $loopCloseTail) {
                                    $openTag = $loopOpenHead . $key . $loopOpenTail;
                                    $closeTag = $loopCloseHead . $key . $loopCloseTail;
                                }
                            }
                            $ember = $this->getStringBetween($this->stringFile, $openTag, $closeTag);
                            foreach ($value as $key2 => $value2) {
                                $openTag = '';
                                $closeTag = '';
                                foreach ($this->loopRulesHead as $loopOpenHead => $loopOpenTail) {
                                    foreach ($this->loopRulesTail as $loopCloseHead => $loopCloseTail) {
                                        $openTag = $loopOpenHead . $key . $loopOpenTail;
                                        $closeTag = $loopCloseHead . $key . $loopCloseTail;
                                    }
                                }
                                $parsed = $this->getStringBetween($this->stringFile, $openTag, $closeTag);
                                foreach ($value2 as $key3 => $value3) {
                                    $parsed = str_replace($head . $key3 . $tail, $value3, $parsed);
                                }
                                $dynamicTags .= $parsed;
                            }
                            $this->stringFile = str_replace($ember, $dynamicTags, $this->stringFile);
                            break;
                        case $this->BOOLEANS:
                            $stanza = $this->blockedConditions($this->stringFile, $key);
                            if (is_null($stanza)) {
                                if ($value != true) {
                                    $openTag = '';
                                    $closeTag = '';
                                    foreach ($this->loopRulesHead as $loopOpenHead => $loopOpenTail) {
                                        foreach ($this->loopRulesTail as $loopCloseHead => $loopCloseTail) {
                                            $openTag = $loopOpenHead . $key . $loopOpenTail;
                                            $closeTag = $loopCloseHead . $key . $loopCloseTail;
                                        }
                                    }
                                    $parsed = $this->getStringBetween($this->stringFile, $openTag, $closeTag);
                                    $this->stringFile = str_replace($parsed, '', $this->stringFile);
                                }
                            } else {
                                //for blocked conditions
                                if ($value == true) {
                                    $this->stringFile = str_replace($stanza, '', $this->stringFile);
                                }

                            }
                            break;
                        case $this->NULLS:
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

        //eliminating html comments and statement tags
        $this->stringFile = preg_replace('/<!--(.|\s)*?-->/', '', $this->stringFile);

        // eliminating empty tags
        if (!$this->displayEmptyTag) {
            foreach ($this->valueRules as $head => $tail) {
                $this->stringFile = str_replace($head, '', $this->stringFile);
                $this->stringFile = str_replace($tail, '', $this->stringFile);
            }
        }

        $this->masterFile = str_replace('{CONTENT}', $this->stringFile, $this->masterFile);
        return $this->masterFile;
    }

    public function blockedConditions($stanza, $key)
    {
        foreach ($this->templateBlockedRulesOpen as $TkeyO => $TvalueO) {
            foreach ($this->templateBlockedRulesClosed as $TkeyC => $TvalueC) {
                $ember = $this->getStringBetween($stanza, $TkeyO . $key . $TvalueO, $TkeyC . $key . $TvalueC);
                if ($ember) {
                    return $ember;
                } else {
                    return false;
                }
            }
        }
        return false;
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
            $htmlScripts .= "<script type='text/javascript' src='" . ROOT . "Assets/Extensions/js/" . $val . ".js'></script>\n";
        }
        $htmlScripts .= "<script type='text/javascript' src='" . ROOT . "Assets/js/" . $controllerName . "/" . $functionName . ".js'></script>\n";
        $this->masterFile = str_replace('<!--@js{}-->', $htmlScripts, $this->masterFile);
    }

    public function StyleRender($controllerName, $functionName)
    {
        $arrayStyle = $this->getStyleProperty();
        $htmlStylesheet = '';
        foreach ($arrayStyle as $key => $val) {
            $htmlStylesheet .= "<link rel='stylesheet' href='" . ROOT . "Assets/Extensions/css/" . $val . ".css'>\n";
        }
        $htmlStylesheet .= "<link rel='stylesheet' href='" . ROOT . "Assets/css/" . $controllerName . "/" . $functionName . ".css'>\n";
        $this->masterFile = str_replace('<!--@css{}-->', $htmlStylesheet, $this->masterFile);
    }

    public function ReturnEmptyRender()
    {
        $this->stringFile = preg_replace('/<!--(.|\s)*?-->/', '', $this->stringFile);
        if (!$this->displayEmptyTag) {
            foreach ($this->valueRules as $head => $tail) {
                $this->stringFile = str_replace($head, '', $this->stringFile);
                $this->stringFile = str_replace($tail, '', $this->stringFile);
            }
        }
        return $this->stringFile;
    }

}