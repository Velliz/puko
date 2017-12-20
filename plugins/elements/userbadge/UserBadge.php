<?php

namespace plugins\elements\userbadge;

use pte\Parts;

class UserBadge extends Parts
{

    /**
     * @return string
     */
    public function Parse()
    {
        $this->pte->SetValue($this->data);
        $this->pte->SetHtml(strtolower(UserBadge::class . '.html'));
        return $this->pte->Output();
    }

}
