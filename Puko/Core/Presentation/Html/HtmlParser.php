<?php

namespace Puko\Core\Presentation\Html;

use Puko\Core\Presentation\AbstractParser;

class HtmlParser extends AbstractParser
{
    private $ARRAYS = 0;
    private $STRINGS = 1;
    private $BOOLEANS = 2;
    private $NULLS = 4;
    private $NUMERIC = 5;
    private $UNDEFINED = 6;

    protected $file;
    protected $values;
    protected $stringFile;

    protected $valueRules;
    protected $loopRulesHead;
    protected $loopRulesTail;

    protected $templateBlockedRulesOpen;
    protected $templateBlockedRulesClosed;

    protected $logs;
    protected $displayEmptyTag;

    public function __construct($file, $logOptions = true, $displayEmptyTag = true)
    {

        $this->setValueRule("{!", "}");
        $this->setOpenLoopRule("{!", "}");
        $this->setClosedLoopRule("{/", "}");

        $this->setOpenBlockedRule("{!!", "}");
        $this->setClosedBlockedRule("{/", "}");

        $this->file = $file;
        $this->logs = $logOptions;
        $this->displayEmptyTag = $displayEmptyTag;

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

    public function output()
    {

        // controller returning null array data
        if (!isset($this->values)) {
            $this->stringFile = preg_replace('/<!--(.|\s)*?-->/', '', $this->stringFile);

            if (!$this->displayEmptyTag) {
                foreach ($this->valueRules as $head => $tail) {
                    $this->stringFile = str_replace($head, '', $this->stringFile);
                    $this->stringFile = str_replace($tail, '', $this->stringFile);
                }
            }
            return $this->stringFile;
        }

        foreach ($this->values as $key => $value) {
            foreach ($this->valueRules as $head => $tail) {

                $tagReplace = $head . $key . $tail;
                if ($this->searchVarType($value) != $this->ARRAYS
                    && $this->searchVarType($value) != $this->BOOLEANS
                    && $this->searchVarType($value) != $this->NULLS
                ) {
                    $this->stringFile = str_replace($tagReplace, $value, $this->stringFile);
                } else {
                    if ($this->searchVarType($value) == $this->ARRAYS) {

                        // todo : enhancement to loop in the loop
                        $dinamicTags = '';
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

                            $dinamicTags = $dinamicTags . $parsed;

                        }
                        $this->stringFile = str_replace($ember, $dinamicTags, $this->stringFile);


                    } else {
                        if ($this->searchVarType($value) == $this->BOOLEANS) {

                            $stanza = $this->blockedConditions($this->stringFile, $key);

                            // not blocked conditions
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
                        } else {
                            if ($this->logs) {
                                die('variable undefined.');
                            }
                        }
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

        return $this->stringFile;
    }

    public function searchVarType($var)
    {
        if (is_array($var)) {
            return $this->ARRAYS;
        } else {
            if (is_null($var)) {
                return $this->NULLS;
            } else {
                if (is_string($var)) {
                    return $this->STRINGS;
                } else {
                    if (is_bool($var)) {
                        return $this->BOOLEANS;
                    } else {
                        if (is_numeric($var)) {
                            return $this->NUMERIC;
                        } else {
                            return $this->UNDEFINED;
                        }
                    }
                }
            }
        }
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
        $keys = $this->getStringBetween($this->stringFile, '@css{', '}');
        $this->stringFile = str_replace('@css{' . $keys . '}', '@css{}', $this->stringFile);
        return explode(',', $keys);
    }

    public function getScriptProperty()
    {
        $keys = $this->getStringBetween($this->stringFile, '@js{', '}');
        $this->stringFile = str_replace('@js{' . $keys . '}', '@js{}', $this->stringFile);
        return explode(',', $keys);
    }

    public function renderStyleProperty($cname, $fname)
    {
        $arrayStyle = $this->getStyleProperty();
        $htmlStylesheet = '';
        foreach ($arrayStyle as $key => $val) {
            $htmlStylesheet .= "<link rel='stylesheet' href='" . ROOT . "Extensions/css/" . $val . ".css'>\n";
        }

        $htmlStylesheet .= "<link rel='stylesheet' href='" . ROOT . "Assets/css/" . $cname . "/" . $fname . ".css'>\n";

        $this->stringFile = str_replace('<!--@css{}-->', $htmlStylesheet, $this->stringFile);
    }

    public function renderScriptProperty($cname, $fname)
    {
        $arrayScript = $this->getScriptProperty();
        $htmlScripts = '';
        foreach ($arrayScript as $key => $val) {
            $htmlScripts .= "<script type='text/javascript' src='" . ROOT . "Extensions/js/" . $val . ".js'></script>\n";
        }

        $htmlScripts .= "<script type='text/javascript' src='" . ROOT . "Assets/js/" . $cname . "/" . $fname . ".js'></script>\n";

        $this->stringFile = str_replace('<!--@js{}-->', $htmlScripts, $this->stringFile);
    }

    public function ValueRender()
    {
        // TODO: Implement ValueRender() method.
    }

    public function ConditionRender()
    {
        // TODO: Implement ConditionRender() method.
    }

    public function LoopRender()
    {
        // TODO: Implement LoopRender() method.
    }

    public function ScriptRender()
    {
        // TODO: Implement ScriptRender() method.
    }

    public function StyleRender()
    {
        // TODO: Implement StyleRender() method.
    }

    public function UrlRender()
    {
        // TODO: Implement UrlRender() method.
    }

    public function ReturnEmptyRender()
    {
        // TODO: Implement ReturnEmptyRender() method.
    }
}