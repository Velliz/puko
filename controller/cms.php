<?php

namespace controller;

use plugins\elements\pukocms\pukocms;
use pukoframework\middleware\View;

/**
 * #Template master false
 * #Value title Hello World
 */
class cms extends View
{

    /**
     * @return array
     * @desc install it via terminal: php puko element download pukocms
     * #Template html false
     */
    public function engine()
    {
        $data  = [];

        return [
            'pukocms' => new pukocms('admin', $data),
        ];
    }

}
