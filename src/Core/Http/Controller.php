<?php

namespace Core\Http;

#[\Attribute(\Attribute::TARGET_CLASS|\Attribute::IS_REPEATABLE)]
class Controller{
    public function __construct(
        public string $prefix
    ){}
}