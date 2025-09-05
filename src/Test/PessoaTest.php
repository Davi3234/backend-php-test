<?php

use Controller\PessoaController;
use Core\Exception\HttpException;
use Model\IPessoaRepositorio;
use Model\Pessoa;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Test;

class PessoaTest extends TestCase{

  private IPessoaRepositorio $pessoaRepositorio; 
  private PessoaController $pessoaController;

  protected function setUp(): void{
    parent::setUp();
    $this->pessoaRepositorio = $this->createMock(IPessoaRepositorio::class);
    $this->pessoaController = new PessoaController($this->pessoaRepositorio);
  }

  #[Test]
  public function testaCriarPessoaComDadosFuncionais(){
    //Arrange
    $id = 1;
    $nome = "Davi";
    $cpf = "785.609.419-24";

    $pessoa = new Pessoa(
      nome: $nome, 
      cpf: $cpf
    );
    $pessoaDepois = new Pessoa(
      nome: $nome,
      cpf: $cpf,
      id: $id
    );

    $this->pessoaRepositorio
      ->method('criar')
        ->with($pessoa)
          ->willReturn($pessoaDepois);

    //Act
    $resultado = $this->pessoaController->criarPessoa(
      [
        'nome' => $nome,
        'cpf' => $cpf
      ]
    );

    $resultadoEsperado = [
      'id' => $id,
      'nome' => $nome,
      'cpf' => $cpf
    ];

    //Assert
    $this->assertEquals($resultadoEsperado, $resultado);
  }

  #[Test]
  public function testaCriarPessoaSemCpf(){
    $this->expectException(HttpException::class);

    //Arrange
    $nome = "Davi";
    $cpf = "";

    //Act
    $this->pessoaController->criarPessoa(
      [
        'nome' => $nome,
        'cpf' => $cpf
      ]
    );
  }

  #[Test]
  public function testaCriarPessoaSemNome(){
    $this->expectException(HttpException::class);

    //Arrange
    $nome = "";
    $cpf = "785.609.419-24";

    //Act
    $this->pessoaController->criarPessoa(
      [
        'nome' => $nome,
        'cpf' => $cpf
      ]
    );
  }
}