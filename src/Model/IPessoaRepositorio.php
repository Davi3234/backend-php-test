<?php
interface IPessoaRepositorio{
  public function criar(Pessoa $pessoa): Pessoa;
  public function editar(Pessoa $pessoa): Pessoa;
  public function excluir(int $id): void;
}