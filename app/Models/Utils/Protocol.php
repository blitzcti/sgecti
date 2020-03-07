<?php

namespace App\Models\Utils;

trait Protocol
{
    public function getFormattedProtocolAttribute()
    {
        $protocol = $this->protocol;
        $n = substr($protocol, 0, 3);
        $y = substr($protocol, 3, 4);
        return "{$n}/{$y}";
    }
}
