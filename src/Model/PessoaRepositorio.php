<?php

namespace Model;

use Core\EntityManagerSingleton;
use Doctrine\ORM\EntityManager;
use Exception;

class PessoaRepositorio implements IPessoaRepositorio{
    private EntityManager $entityManager;

    public function __construct(){
        $this->entityManager = EntityManagerSingleton::getInstance();
    }

    public function criar(Pessoa $pessoa): Pessoa{
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($pessoa);
            $this->entityManager->flush();
            $this->entityManager->commit();

            return $pessoa;
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function editar(Pessoa $pessoa): Pessoa{
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($pessoa);
            $this->entityManager->flush();
            $this->entityManager->commit();

            return $pessoa;
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function excluir(int $id): void{
        try {
            $this->entityManager->beginTransaction();

            $pessoa = $this->entityManager->find(Pessoa::class, $id);

            $this->entityManager->remove($pessoa);
            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}