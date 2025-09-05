<?php

use Controller\ContatoController;
use Core\Enum\TipoContato;
use Core\Exception\HttpException;
use Model\IContatoRepositorio;
use Model\Contato;
use Model\IPessoaRepositorio;
use Model\Pessoa;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Test;

class ContatoTest extends TestCase{

  private IContatoRepositorio $contatoRepositorio;
  private ContatoController $contatoController;
  private IPessoaRepositorio $pessoaRepositorio;

  protected function setUp(): void{
    parent::setUp();
    $this->contatoRepositorio = $this->createMock(IContatoRepositorio::class);
    $this->pessoaRepositorio = $this->createMock(IPessoaRepositorio::class);
    $this->contatoController = new ContatoController($this->contatoRepositorio, $this->pessoaRepositorio);
  }

  #[Test]
  public function testaCriarContatoComDadosFuncionais(){
    //Arrange
    $id = 1;
    $tipo = TipoContato::EMAIL;
    $tipoValue = TipoContato::EMAIL->value;
    $descricao = "davi@gmail.com";
    $pessoa = new Pessoa('Davi', '132.442.819-71', 1);

    $contato = new Contato(
      tipo: $tipo, 
      descricao: $descricao,
      pessoa: $pessoa
    );
    $contatoDepois = new Contato(
      tipo: $tipo,
      descricao: $descricao,
      pessoa: $pessoa,
      id: $id
    );

    $this->contatoRepositorio
      ->method('criar')
        ->with($contato)
          ->willReturn($contatoDepois);

    $this->pessoaRepositorio
      ->method('buscar')
        ->with(1)
          ->willReturn($pessoa);

    //Act
    $resultado = $this->contatoController->criarContato(
      [
        'tipo' => $tipoValue,
        'descricao' => $descricao,
        'idPessoa' => 1
      ]
    );

    $resultadoEsperado = [
      'id' => $id,
      'tipo' => TipoContato::EMAIL->tryFrom($tipoValue),
      'descricao' => $descricao,
      'pessoa' => [
        'id' => $pessoa->getId(),
        'nome' => $pessoa->getNome(),
        'cpf' => $pessoa->getCpf()
      ]
    ];

    //Assert
    $this->assertEquals($resultado, $resultadoEsperado);
  }

  #[Test]
  public function testaCriarContatoSemTipo(){
    $this->expectException(HttpException::class);

    //Arrange
    $tipoValue = null;
    $descricao = "davi@gmail.com";
    $pessoa = new Pessoa('Davi', '132.442.819-71', 1);

    $this->pessoaRepositorio
      ->method('buscar')
        ->with($pessoa)
          ->willReturn($pessoa);

    //Act
    $this->contatoController->criarContato(
      [
        'tipo' => $tipoValue,
        'descricao' => $descricao,
        'idPessoa' => 1
      ]
    );
  }

  #[Test]
  public function testaCriarContatoSemDescricao(){
    $this->expectException(HttpException::class);

    //Arrange
    $tipoValue = TipoContato::TELEFONE->value;
    $descricao = "";
    $pessoa = new Pessoa('Davi', '132.442.819-71', 1);

    $this->pessoaRepositorio
      ->method('buscar')
        ->with($pessoa)
          ->willReturn($pessoa);

    //Act
    $this->contatoController->criarContato(
      [
        'tipo' => $tipoValue,
        'descricao' => $descricao,
        'idPessoa' => 1
      ]
    );
  }

  #[Test]
  public function testaCriarContatoSemPessoa(){
    $this->expectException(HttpException::class);

    //Arrange
    $tipoValue = TipoContato::TELEFONE->value;
    $descricao = "(47) 99955-6677";
    $idPessoa = 1;

    $this->pessoaRepositorio
      ->method('buscar')
        ->with($idPessoa)
          ->willThrowException(new HttpException());

    //Act
    $this->contatoController->criarContato(
      [
        'tipo' => $tipoValue,
        'descricao' => $descricao,
        'idPessoa' => $idPessoa
      ]
    );
  }
}