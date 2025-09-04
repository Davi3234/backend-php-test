<?php
namespace Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;

#[Entity()]
#[Table(name: 'pessoas')]
class Pessoa{

  #[Id]
  #[Column(type: 'integer')]
  #[GeneratedValue]
  public readonly int $id;
  #[Column(type: 'string')]
  private string $nome;
  #[Column(type: 'string')]
  private string $cpf;

  public function __construct($nome, $cpf){
    $this->nome = $nome;
    $this->cpf = $cpf;
  }
  public function getNome(){
    return $this->nome;
  }
  public function getCpf(){
    return $this->cpf;
  }
}