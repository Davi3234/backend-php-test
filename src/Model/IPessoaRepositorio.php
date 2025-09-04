<?php
namespace Model;

interface IPessoaRepositorio{
  public function criar(Pessoa $pessoa): Pessoa;
  public function editar(Pessoa $pessoa): Pessoa;
  public function excluir(int $id): void;
  public function listar(): array;
  public function buscar(int $id): Pessoa;
}