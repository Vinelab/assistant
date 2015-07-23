<?php

namespace Vinelab\Assistant;

class Generator
{
    public function uid()
    {
        return rand(100, 9999999).uniqid();
    }
}
