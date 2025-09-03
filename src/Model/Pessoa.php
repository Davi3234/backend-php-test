<?php

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
  private int $id;
  #[Column(type: 'string')]
  private string $nome;
  #[Column(type: 'string')]
  private string $cpf;

  public function __construct($id, $nome, $cpf){
    $this->id = $id;
    $this->nome = $nome;
    $this->cpf = $cpf;
  }
}