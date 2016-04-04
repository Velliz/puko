<?php

namespace Puko\Core\Presentation;

interface HtmlRuleParser
{
    const RULE_HTML = array(
        'value' => '{!?}',
        'condition' => array(
            'open' => '{!!?}',
            'close' => '{/?}',
        ),
        'loop' => array(
            'open' => '{!?}',
            'close' => '{/?}',
        ),
        'style' => '@css{?}',
        'url' => '@url{?}',
        'script' => '@js{?}',
    );
}