<?php

namespace Model;

use Core\EntityManagerSingleton;
use Core\Exception\HttpException;
use Doctrine\ORM\EntityManager;
use Exception;

class ContatoRepositorio implements IContatoRepositorio{
    private EntityManager $entityManager;

    public function __construct(){
        $this->entityManager = EntityManagerSingleton::getInstance();
    }

    public function criar(Contato $contato): Contato{
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($contato);
            $this->entityManager->flush();
            $this->entityManager->commit();

            return $contato;
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function editar(Contato $contato): Contato{
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($contato);
            $this->entityManager->flush();
            $this->entityManager->commit();

            return $contato;
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function excluir(int $id): void{
        try {
            $contato = $this->buscar($id);

            $this->entityManager->beginTransaction();
            $this->entityManager->remove($contato);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
    public function listar(): array{
        $contatos = $this->entityManager->getRepository(Contato::class)->findAll();
        return $contatos;
    }
    public function buscar(int $id): Contato{
        $contato = $this->entityManager->getRepository(Contato::class)->find($id);

        if($contato == null){
            throw new HttpException(400, ['Contato não encontrado']);
        }
        return $contato;
    }
}