<?php

namespace Controller;

use Core\Http\Controller;
use Core\Http\Get;

#[Controller('/teste')]
class ControllerTeste{

    #[Get('/ola/{nome}')]
    public function olaMundo($params = []){
        return "Olá ".$params['nome']."!";
    }
}