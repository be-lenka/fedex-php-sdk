<?php

namespace belenka\fedex\Traits;

trait rawable
{

    public $raw = false;

    public function asRaw()
    {
        $this->raw = true;
        return $this;
    }
}
