<?php

namespace Controller;

use Core\Http\Controller;
use Core\Http\Get;

#[Controller('/teste')]
class ControllerTeste{

    #[Get('/ola/{nome}')]
    public function olaPessoa($params = []){
        return ['message' => "Olá ".$params['nome']."!"];
    }
}