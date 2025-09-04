<?php

namespace Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;

#[Entity()]
#[Table(name: 'pessoas')]
class Pessoa{

    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private int $id;
    #[Column(type: 'string', length: 255)]
    private string $nome;
    #[Column(type: 'string', length: 14)]
    private string $cpf;

    #[OneToMany(mappedBy: "pessoa", targetEntity: Contato::class)]
    private Collection $contatos;

    public function __construct($nome, $cpf){
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->contatos = new ArrayCollection();
    }

    public function getId(): int{
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getContatos(): Collection{
        return $this->contatos;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function setCpf(string $cpf): void{
        $this->cpf = $cpf;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }
}