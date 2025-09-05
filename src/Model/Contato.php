<?php

namespace Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Core\Enum\TipoContato;

#[Entity()]
#[Table(name: 'contatos')]
class Contato{

    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private int $id;
    #[Column(type: 'smallint', enumType: TipoContato::class)]
    private TipoContato $tipo;
    #[Column(type: 'string', length: 255)]
    private string $descricao;

    #[ManyToOne(targetEntity: Pessoa::class, inversedBy: "contatos")]
    #[JoinColumn(name: "idPessoa", referencedColumnName: "id", nullable: false)]
    private Pessoa $pessoa;

    public function __construct($tipo, $descricao, $pessoa, $id = 0){
        $this->tipo = $tipo;
        $this->descricao = $descricao;
        $this->pessoa = $pessoa;
        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getTipo(): TipoContato{
        return $this->tipo;
    }

    public function getPessoa(){
        return $this->pessoa;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void{
        $this->descricao = $descricao;
    }

    public function setTipo(TipoContato $tipo): void{
        $this->tipo = $tipo;
    }

    public function setPessoa(Pessoa $pessoa): void{
        $this->pessoa = $pessoa;
    }
}