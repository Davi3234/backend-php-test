<?php

namespace Core\Http;

#[\Attribute(\Attribute::TARGET_METHOD|\Attribute::IS_REPEATABLE)]
class Method{
    public function __construct(
        public string $path,
        public string $method
    ){
        if($this->path == '/'){
            $this->path = '';
        }
    }
}