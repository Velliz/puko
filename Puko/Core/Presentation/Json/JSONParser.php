<?php

namespace Puko\Core\Presentation\Json;


class JSONParser
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

}