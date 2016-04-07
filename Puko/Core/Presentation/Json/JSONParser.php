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