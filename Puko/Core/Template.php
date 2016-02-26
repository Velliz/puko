<?php

namespace Puko\Core;

use Exception;

class Template
{
    private $ARRAYS = 0;
    private $STRINGS = 1;
    private $BOOLEANS = 2;
    private $NULLS = 4;
    private $NUMERIC = 5;
    private $UNDEFINED = 6;

    protected $file;
    protected $values;

    protected $templateValueRules;
    protected $templateLoopRulesOpen;
    protected $templateLoopRulesClosed;

    protected $templateBlockedRulesOpen;
    protected $templateBlockedRulesClosed;

    protected $logs;
    protected $displayEmptyTag;

    public function __construct($file, $logOptions = true, $displayEmptyTag = true)
    {
        $this->file = $file;
        $this->logs = $logOptions;
        $this->displayEmptyTag = $displayEmptyTag;
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
        //only one template definition allowed
        $this->templateRules = null;
        $this->templateValueRules[$tagOpen] = $tagClose;
    }

    public function setOpenLoopRule($tagOpen, $tagClose)
    {
        $this->templateLoopRulesOpen[$tagOpen] = $tagClose;
    }

    public function setClosedLoopRule($tagOpen, $tagClose)
    {
        $this->templateLoopRulesClosed[$tagOpen] = $tagClose;
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
        if (!file_exists($this->file)) {
            if ($this->logs) {
                die("template file not found");
            }
        }

        try {
            $output = file_get_contents($this->file);
        } catch (Exception $ex) {
            echo "I HANDLED THIS ERROR: " . $ex->getMessage();
        }


        if (!isset($this->values)) {
            //eliminating html comments and statement tags
            $output = preg_replace('/<!--(.|\s)*?-->/', '', $output);

            // eliminating empty tags
            if (!$this->displayEmptyTag) {
                foreach ($this->templateValueRules as $Tkey => $Tvalue) {
                    $output = str_replace($Tkey, '', $output);
                    $output = str_replace($Tvalue, '', $output);
                }
            }
            return $output;
        }

        foreach ($this->values as $key => $value) {
            foreach ($this->templateValueRules as $Tkey => $Tvalue) {

                $tagToReplace1 = $Tkey . $key . $Tvalue;
                if ($this->searchVarType($value) != $this->ARRAYS
                    && $this->searchVarType($value) != $this->BOOLEANS
                    && $this->searchVarType($value) != $this->NULLS
                ) {
                    $output = str_replace($tagToReplace1, $value, $output);
                } else {
                    if ($this->searchVarType($value) == $this->ARRAYS) {
                        //for hold clone element
                        $dinamicTags = '';
                        $openTag = '';
                        $closeTag = '';

                        foreach ($this->templateLoopRulesOpen as $TkeyO => $TvalueO) {
                            foreach ($this->templateLoopRulesClosed as $TkeyC => $TvalueC) {
                                $openTag = $TkeyO . $key . $TvalueO;
                                $closeTag = $TkeyC . $key . $TvalueC;
                            }
                        }
                        $ember = $this->get_string_between($output, $openTag, $closeTag);
                        foreach ($value as $key2 => $value2) {
                            //for replacing template data
                            $openTag = '';
                            $closeTag = '';
                            foreach ($this->templateLoopRulesOpen as $TkeyO => $TvalueO) {
                                foreach ($this->templateLoopRulesClosed as $TkeyC => $TvalueC) {
                                    $openTag = $TkeyO . $key . $TvalueO;
                                    $closeTag = $TkeyC . $key . $TvalueC;
                                }
                            }
                            $parsed = $this->get_string_between($output, $openTag, $closeTag);
                            foreach ($value2 as $key3 => $value3) {
                                $parsed = str_replace($Tkey . $key3 . $Tvalue, $value3, $parsed);
                            }
                            $dinamicTags = $dinamicTags . $parsed;
                        }
                        $output = str_replace($ember, $dinamicTags, $output);
                    } else {
                        if ($this->searchVarType($value) == $this->BOOLEANS) {

                            $stanza = $this->blockedConditions($output, $key);

                            // not blocked conditions
                            if (is_null($stanza)) {
                                if ($value != true) {
                                    $openTag = '';
                                    $closeTag = '';

                                    foreach ($this->templateLoopRulesOpen as $TkeyO => $TvalueO) {
                                        foreach ($this->templateLoopRulesClosed as $TkeyC => $TvalueC) {
                                            $openTag = $TkeyO . $key . $TvalueO;
                                            $closeTag = $TkeyC . $key . $TvalueC;
                                        }
                                    }
                                    $parsed = $this->get_string_between($output, $openTag, $closeTag);
                                    $output = str_replace($parsed, '', $output);
                                }
                            } else {
                                //for blocked conditions
                                if ($value == true) {
                                    $output = str_replace($stanza, '', $output);
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
        $output = preg_replace('/<!--(.|\s)*?-->/', '', $output);

        // eliminating empty tags
        if (!$this->displayEmptyTag) {
            foreach ($this->templateValueRules as $Tkey => $Tvalue) {
                $output = str_replace($Tkey, '', $output);
                $output = str_replace($Tvalue, '', $output);
            }
        }

        return $output;
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
                $ember = $this->get_string_between($stanza, $TkeyO . $key . $TvalueO, $TkeyC . $key . $TvalueC);
                if ($ember) {
                    return $ember;
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    function get_string_between($string, $start, $end)
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
}
