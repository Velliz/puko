<?php

namespace controller;

use plugins\elements\pukocms\pukocms;
use pukoframework\middleware\View;

/**
 * #Master master.html
 * #Value title Hello World.
 */
class welcome extends View
{
    /**
     * #Value title Welcome.
     */
    public function welcome()
    {
        if ($this->GetAppConstant('CMS_MODE') === true) {
            $data = [];

            return [
                'pukocms' => new pukocms('client', $data),
            ];
        }
    }
}
