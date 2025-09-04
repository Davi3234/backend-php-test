<?php

namespace Controller;

use Core\Exception\HttpException;
use Core\Server\Response;
use Model\IPessoaRepositorio;
use Model\Pessoa;
use Model\PessoaRepositorio;

class PessoaController{

  public function __construct(
    private IPessoaRepositorio $pessoaRepositorio = new PessoaRepositorio()
  ){}

  /**
   * Cria pessoa
   * @param array $params
   * @throws \Core\Exception\HttpException
   * @return array Data
   */
  public function criarPessoa($params = []){

    $erros = [];

    if (empty($params['nome'])) {
      $erros[] = "O nome é de preenchimento obrigatório.";
    }

    if (empty($params['cpf'])) {
      $erros[] = "O CPF é de preenchimento obrigatório.";
    }

    if (!empty($erros)) {
      throw new HttpException(400, $erros);
    }

    $pessoa = new Pessoa(
      nome: $params['nome'],
      cpf: $params['cpf']
    );

    $pessoaResponse = $this->pessoaRepositorio->criar($pessoa);

    return [
      'id' => $pessoaResponse->id,
      'nome' => $pessoaResponse->getNome(),
      'cpf' => $pessoaResponse->getCpf()
    ];
  }
}