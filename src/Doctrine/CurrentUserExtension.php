<?php
// api/src/Doctrine/CurrentUserExtension.php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Comuni;
use App\Entity\Erogazioni;
use App\Entity\Stazioni;
use App\Entity\Tessere;
use App\Entity\Transazioni;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface {
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return;
        }

        $utente = $this->security->getUser();
        $rootAlias = $queryBuilder->getRootAliases()[0];

        if ($this->security->isGranted('ROLE_CUSTOMER')) {

            if ($resourceClass == Tessere::class || $resourceClass == Transazioni::class) {
                $queryBuilder->andWhere(sprintf('%s.utente = :current_utente', $rootAlias));
                $queryBuilder->setParameter('current_utente', $utente->getId());
            }

            if ($resourceClass == Erogazioni::class) {
                $queryBuilder->leftJoin(sprintf('%s.tessera', $rootAlias), 'te');
                $queryBuilder->andWhere('te.utente = :current_utente');
                $queryBuilder->setParameter('current_utente', $utente->getId());
            }

            if ($resourceClass == Stazioni::class || $resourceClass == Comuni::class) {
                $queryBuilder->andWhere(sprintf('%s.id = :current_utente_comune', $rootAlias));
                $queryBuilder->setParameter('current_utente_comune', $utente->getComune()->getId());
            }

        }

        if ($this->security->isGranted('ROLE_MANAGER')) {

            if ($resourceClass == Tessere::class || $resourceClass == Transazioni::class) {
                $queryBuilder->andWhere(sprintf('%s.utente = :current_gestore', $rootAlias));
                $queryBuilder->setParameter('current_gestore', $utente->getGestore());
            }

            if ($resourceClass == Erogazioni::class) {
                $queryBuilder->leftJoin(sprintf('%s.tessera', $rootAlias), 'te');
                $queryBuilder->andWhere('te.utente = :current_gestore');
                $queryBuilder->setParameter('current_gestore', $utente->getGestore());
            }

            if ($resourceClass == Stazioni::class || $resourceClass == Comuni::class) {
                $queryBuilder->andWhere(sprintf('%s.id = :current_utente_comune', $rootAlias));
                $queryBuilder->setParameter('current_utente_comune', $utente->getComune()->getId());
            }

        }
    }
}