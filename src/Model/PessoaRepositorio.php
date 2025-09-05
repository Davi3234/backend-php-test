<?php

namespace Model;

use Core\EntityManagerSingleton;
use Core\Exception\HttpException;
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
            $pessoa = $this->buscar($id);

            $this->entityManager->beginTransaction();
            $this->entityManager->remove($pessoa);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
    public function listarPeloNome($nome = ''): array{
        $pessoas = $this->entityManager
            ->getRepository(Pessoa::class)
            ->createQueryBuilder('p')
            ->where('lower(p.nome) LIKE :nome')
            ->setParameter('nome', '%' . strtolower($nome) . '%')
            ->getQuery()
            ->getResult();
        return $pessoas;
    }
    public function listar(): array{
        $pessoas = $this->entityManager->getRepository(Pessoa::class)->findAll();
        return $pessoas;
    }
    public function buscar(int $id): Pessoa{
        $pessoa = $this->entityManager->getRepository(Pessoa::class)->find($id);

        if($pessoa == null){
            throw new HttpException(400, ['Pessoa não encontrada']);
        }
        return $pessoa;
    }
}