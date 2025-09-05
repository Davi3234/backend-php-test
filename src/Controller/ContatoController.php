<?php

namespace Controller;

use Core\Enum\TipoContato;
use Core\Exception\HttpException;
use Model\IContatoRepositorio;
use Model\Contato;
use Model\ContatoRepositorio;
use Model\IPessoaRepositorio;
use Model\PessoaRepositorio;

class ContatoController{

    public function __construct(
        private IContatoRepositorio $contatoRepositorio = new ContatoRepositorio(),
        private IPessoaRepositorio $pessoaRepositorio = new PessoaRepositorio()
    ){}

    /**
     * Cria contato
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function criarContato($params = []){

        $erros = $this->validaDadosContato($params);

        if (!empty($erros)) {
            throw new HttpException(400, $erros);
        }

        $pessoa = $this->pessoaRepositorio->buscar($params['idPessoa']);

        $contato = new Contato(
            tipo: TipoContato::tryFrom($params['tipo']),
            descricao: $params['descricao'],
            pessoa: $pessoa
        );

        $contatoResponse = $this->contatoRepositorio->criar($contato);

        return [
            'id' => $contatoResponse->getId(),
            'tipo' => $contatoResponse->getTipo(),
            'descricao' => $contatoResponse->getDescricao(),
            'pessoa' => [
                'id' => $pessoa->getId(),
                'nome' => $pessoa->getNome(),
                'cpf' => $pessoa->getCpf()
            ]
        ];
    }

    /**
     * Edita o contato
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function editarContato($params = []){

        $erros = $this->validaDadosContato($params);

        if (!empty($erros)) {
            throw new HttpException(400, $erros);
        }

        $contato = $this->contatoRepositorio->buscar($params['id']);

        $pessoa = $this->pessoaRepositorio->buscar($params['idPessoa']);

        $contato->setTipo(TipoContato::tryFrom($params['tipo']));
        $contato->setDescricao($params['descricao']);
        $contato->setPessoa($pessoa);

        $contatoResponse = $this->contatoRepositorio->editar($contato);

        return [
            'id' => $contatoResponse->getId(),
            'tipo' => $contatoResponse->getTipo(),
            'descricao' => $contatoResponse->getDescricao(),
            'pessoa' => [
                'id' => $pessoa->getId(),
                'nome' => $pessoa->getNome(),
                'cpf' => $pessoa->getCpf()
            ]
        ];
    }

    /**
     * Exclui o contato
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function excluirContato($params = []){

        $this->contatoRepositorio->excluir($params['id']);

        return [];
    }

    /**
     * Lista as contatos
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function listarContatos($params = []){

        $contatosResponse = $this->contatoRepositorio->listar();

        $contatosMapeados = array_map(function($contato){
            return [
                'id' => $contato->getId(),
                'tipo' => $contato->getTipo(),
                'descricao' => $contato->getDescricao(),
                'pessoa' => [
                    'id' => $contato->getPessoa()->getId(),
                    'nome' => $contato->getPessoa()->getNome(),
                    'cpf' => $contato->getPessoa()->getCpf()
                ]
            ];
        }, $contatosResponse);

        return [
            'contatos' => $contatosMapeados
        ];
    }

    /**
     * Busca uma contato pelo id
     * @param array $params
     * @return array Data
     * @throws \Core\Exception\HttpException
     */
    public function buscarContato($params = []){

        $contatoResponse = $this->contatoRepositorio->buscar($params['id']);

        return [
            'id' => $contatoResponse->getId(),
            'tipo' => $contatoResponse->getTipo(),
            'descricao' => $contatoResponse->getDescricao(),
            'pessoa' => [
                'id' => $contatoResponse->getPessoa()->getId(),
                'nome' => $contatoResponse->getPessoa()->getNome(),
                'cpf' => $contatoResponse->getPessoa()->getCpf()
            ]
        ];
    }

    /**
     * Valida os dados obrigatórios da contato
     * @param array{nome: string, cpf: string} $params
     * @return array $erros
     */
    public function validaDadosContato($params = []){
        $erros = [];

        if (empty($params['tipo'])) {
            $erros[] = "O tipo é de preenchimento obrigatório.";
        }

        if (empty($params['descricao'])) {
            $erros[] = "A descrição é de preenchimento obrigatório.";
        }

        if (empty($params['idPessoa'])) {
            $erros[] = "A pessoa é de preenchimento obrigatório.";
        }

        return $erros;
    }
}