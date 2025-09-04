<?php

use Controller\ContatoController;
use Core\Enum\TipoContato;
use Core\Exception\HttpException;
use Model\IContatoRepositorio;
use Model\Contato;
use Model\Pessoa;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Test;

class ContatoTeste extends TestCase{

  private IContatoRepositorio $contatoRepositorio;
  private ContatoController $contatoController;

  protected function setUp(): void{
    parent::setUp();
    $this->contatoRepositorio = $this->createMock(IContatoRepositorio::class);
    $this->contatoController = new ContatoController($this->contatoRepositorio);
  }

  #[Test]
  public function testaCriarContatoComDadosFuncionais(){
    //Arrange
    $id = 1;
    $tipo = TipoContato::EMAIL->value;
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

    //Act
    $resultado = $this->contatoController->criarContato(
      [
        'tipo' => $tipo,
        'descricao' => $descricao,
        'pessoa' => $pessoa
      ]
    );

    $resultadoEsperado = [
      'success' => true,
      'status' => 201,
      'message' => 'Contato criada com Sucesso',
      'data' => [
        'contato' => [
          'id' => $id,
          'tipo' => $tipo,
          'descricao' => $descricao,
          'pessoa' => $pessoa
        ]
      ]
    ];

    //Assert
    $this->assertEquals($resultado, $resultadoEsperado);
  }

  #[Test]
  public function testaCriarContatoSemTipo(){
    $this->expectException(HttpException::class);

    //Arrange
    $tipo = 0;
    $descricao = "davi@gmail.com";
    $pessoa = new Pessoa('Davi', '132.442.819-71', 1);

    $contato = new Contato(
      tipo: $tipo, 
      descricao: $descricao,
      pessoa: $pessoa
    );

    $this->contatoRepositorio
      ->method('criar')
        ->with($contato)
          ->willThrowException();

    //Act
    $this->contatoController->criarContato(
      [
        'tipo' => $tipo,
        'descricao' => $descricao,
        'pessoa' => $pessoa
      ]
    );
  }

  #[Test]
  public function testaCriarContatoSemDescricao(){
    $this->expectException(HttpException::class);

    //Arrange
    $tipo = TipoContato::TELEFONE->value;
    $descricao = "";
    $pessoa = new Pessoa('Davi', '132.442.819-71', 1);

    $contato = new Contato(
      tipo: $tipo, 
      descricao: $descricao,
      pessoa: $pessoa
    );

    $this->contatoRepositorio
      ->method('criar')
        ->with($contato)
          ->willThrowException();

    //Act
    $this->contatoController->criarContato(
      [
        'tipo' => $tipo,
        'descricao' => $descricao,
        'pessoa' => $pessoa
      ]
    );
  }

  #[Test]
  public function testaCriarContatoSemPessoa(){
    $this->expectException(HttpException::class);

    //Arrange
    $tipo = TipoContato::TELEFONE->value;
    $descricao = "(47) 99955-6677";
    $pessoa = null;

    $contato = new Contato(
      tipo: $tipo, 
      descricao: $descricao,
      pessoa: $pessoa
    );

    $this->contatoRepositorio
      ->method('criar')
        ->with($contato)
          ->willThrowException();

    //Act
    $this->contatoController->criarContato(
      [
        'tipo' => $tipo,
        'descricao' => $descricao,
        'pessoa' => $pessoa
      ]
    );
  }
}