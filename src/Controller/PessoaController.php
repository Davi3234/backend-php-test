<?php

namespace Controller;

use Core\Exception\HttpException;
use Core\Server\Response;
use Model\ContatoRepositorio;
use Model\IContatoRepositorio;
use Model\IPessoaRepositorio;
use Model\Pessoa;
use Model\PessoaRepositorio;

class PessoaController{

    public function __construct(
        private IPessoaRepositorio $pessoaRepositorio = new PessoaRepositorio(),
        private IContatoRepositorio $contatoRepositorio = new ContatoRepositorio()
    ){}

    /**
     * Cria pessoa
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function criarPessoa($params = []){

        $erros = $this->validaDadosPessoa($params);

        if (!empty($erros)) {
            throw new HttpException(400, $erros);
        }

        $pessoa = new Pessoa(
            nome: $params['nome'],
            cpf: $params['cpf']
        );

        $pessoaResponse = $this->pessoaRepositorio->criar($pessoa);

        return [
            'id' => $pessoaResponse->getId(),
            'nome' => $pessoaResponse->getNome(),
            'cpf' => $pessoaResponse->getCpf()
        ];
    }

    /**
     * Edita a pessoa
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function editarPessoa($params = []){

        $erros = $this->validaDadosPessoa($params);

        if (!empty($erros)) {
            throw new HttpException(400, $erros);
        }

        $pessoa = $this->pessoaRepositorio->buscar($params['id']);

        $pessoa->setNome($params['nome']);
        $pessoa->setCpf($params['cpf']);

        $pessoaResponse = $this->pessoaRepositorio->editar($pessoa);

        return [
            'id' => $pessoaResponse->getId(),
            'nome' => $pessoaResponse->getNome(),
            'cpf' => $pessoaResponse->getCpf()
        ];
    }


    /**
     * Exclui a pessoa
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function excluirPessoa($params = []){

        $pessoa = $this->pessoaRepositorio->buscar($params['id']);

        if($pessoa->getContatos()->count() > 0){
          foreach($pessoa->getContatos() as $contato){
            $this->contatoRepositorio->excluir($contato->getId());
          }
        }

        $this->pessoaRepositorio->excluir($params['id']);

        return [];
    }

    /**
     * Lista as pessoas
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function listarPessoas($params = []){

        $nome = count($params) > 0 ? $params['nome'] : "";
        $pessoasResponse = $this->pessoaRepositorio->listarPeloNome($nome);

        $pessoasMapeadas = array_map(function($pessoa){
            return [
                'id' => $pessoa->getId(),
                'nome' => $pessoa->getNome(),
                'cpf' => $pessoa->getCpf()
            ];
        }, $pessoasResponse);

        return [
            'pessoas' => $pessoasMapeadas
        ];
    }

    /**
     * Busca uma pessoa pelo id
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function buscarPessoa($params = []){

        $pessoaResponse = $this->pessoaRepositorio->buscar($params['id']);

        return [
            'id' => $pessoaResponse->getId(),
            'nome' => $pessoaResponse->getNome(),
            'cpf' => $pessoaResponse->getCpf()
        ];
    }

    /**
     * Valida os dados obrigatórios da pessoa
     * @param array{nome: string, cpf: string} $params
     * @return array $erros
    */
    public function validaDadosPessoa($params = []){
        $erros = [];

        if (empty($params['nome'])) {
            $erros[] = "O nome é de preenchimento obrigatório.";
        }

        if (empty($params['cpf'])) {
            $erros[] = "O CPF é de preenchimento obrigatório.";
        }

        return $erros;
    }
}