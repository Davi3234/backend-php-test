<?php
namespace Model;

interface IContatoRepositorio{
  public function criar(Contato $contato): Contato;
  public function editar(Contato $contato): Contato;
  public function excluir(int $id): void;
  public function listar(): array;
  public function listarPelaPessoa(int $idPessoa): array;
  public function buscar(int $id): Contato;
}