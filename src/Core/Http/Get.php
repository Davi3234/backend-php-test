<?php

namespace Core\Http;

use Core\Enum\MetodoHTTP;

#[\Attribute(\Attribute::TARGET_METHOD|\Attribute::IS_REPEATABLE)]
class Get extends Method{
    public function __construct(
        public string $path
    ){
        parent::__construct($path, MetodoHTTP::GET->value);
    }
}