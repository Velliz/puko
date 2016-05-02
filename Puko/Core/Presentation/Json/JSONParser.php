<?php

namespace Puko\Core\Presentation\Json;

use Puko\Core\Presentation\AbstractParser;

class JSONParser extends AbstractParser
{

    private $file;
    private $procesStart;
    private $procesEnd;

    public function __construct($var, $start)
    {
        parent::__construct(false, false);
        $this->file = $var;
        $this->procesStart = $start;
    }

    public function output()
    {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Puko Framework v1");
        header('Content-Type: application/json');

        $this->procesEnd = microtime(true);

        $data = array(
            'status' => 'success',
            'processing_time' => $this->procesEnd - $this->procesStart
        );
        $data['data'] = $this->file;

        return $data;
    }

    public function ScriptRender($controllerName, $functionName)
    {

    }

    public function StyleRender($controllerName, $functionName)
    {

    }

    public function ReturnEmptyRender()
    {

    }
}