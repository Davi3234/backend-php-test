<?php

use Doctrine\ORM\EntityManager;
class PessoaRepositorio implements IPessoaRepositorio{
  private EntityManager $entityManager;

  public function __construct($entityManager){
    $this->entityManager = $entityManager;
  }

  public function criar(Pessoa $pessoa): Pessoa{
    try{
      $this->entityManager->beginTransaction();
      $this->entityManager->persist($pessoa);
      $this->entityManager->flush();
     
      return $pessoa;
    }
    catch (Exception $e){
      $this->entityManager->rollback();
      throw $e;
    }
  }
  public function editar(Pessoa $pessoa): Pessoa{
    try{
      $this->entityManager->beginTransaction();
      $this->entityManager->persist($pessoa);
      $this->entityManager->flush();
     
      return $pessoa;
    }
    catch (Exception $e){
      $this->entityManager->rollback();
      throw $e;
    }
  }
  public function excluir(int $id): void{
    try{
      $this->entityManager->beginTransaction();

      $pessoa = $this->entityManager->find(Pessoa::class, $id);

      $this->entityManager->remove($pessoa);
    }
    catch (Exception $e){
      $this->entityManager->rollback();
      throw $e;
    }
  }
}