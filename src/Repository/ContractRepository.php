<?php

namespace App\Repository;

use App\Entity\Charge;
use App\Entity\Contract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contract>
 *
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    public function save(Contract $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contract $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getEmployeeUnderContract(string $status)
    {
        $query = $this->createQueryBuilder('c')
                    ->where('c.status = :status')
                    ->setParameter('status', $status)
                    ->getQuery();

        return $query->getResult();
    }

    public function getChargesByContract(Int $idContract)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM charge 
                LEFT JOIN contract_charge AS ctc ON ctc.charge_id = charge.id 
                WHERE ctc.contract_id = :idContract
        ";

        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery(['idContract' => $idContract]);

        return $resultSet->fetchAllAssociative();
    }

    public function getTaxesByContract(Int $idContract)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM tax 
                LEFT JOIN contract_tax AS ctx ON ctx.tax_id = tax.id 
                WHERE ctx.contract_id = :idContract
        ";

        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery(['idContract' => $idContract]);

        return $resultSet->fetchAllAssociative();
    }

    

//    /**
//     * @return Contract[] Returns an array of Contract objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contract
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
