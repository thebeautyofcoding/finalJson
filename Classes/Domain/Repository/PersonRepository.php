<?php

namespace Heiner\Heiner\Domain\Repository;

/***
 *
 * This file is part of the "personenundfirmen" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Heiner Giehl <heiner.giehl@tu-dortmund.de>, HeinerGiehl
 *
 ***/
/**
 * The repository for Persons.
 */
class PersonRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public $personRepository;

    /**
     * @param \Heiner\Heiner\Domain\Repository\PersonRepository $personRepository
     */
    public function injectPersonRepository(
        PersonRepository $personRepository
    ) {
        $this->personRepository = $personRepository;
    }

    /**
     * custom method: Get all Persons for a specific company.
     *
     * @param $firmaid
     *
     * @return \Heiner\Heiner\Domain\Model\Person $persons
     */
    public function findAllPersonsBelongingToCompany(int $firmaId)
    {
        $query = $this->personRepository->createQuery();
        $query->matching($query->equals('firma.uid', $firmaId));
        $persons = $query->execute();

        return $persons;
    }

    public function pagination(int $currentPage, int $limit)
    {
        $total = $this->createQuery()->count('uid');
        $data['pages'] = [];
        $linksShown = (int) 3;
        $totalPages = (int) ceil($total / $limit);
        $total = (int) $total;
        for (
            $x = $currentPage - $linksShown;
            $x < $currentPage + $linksShown + 1;
            ++$x
        ) {
            if ($x > 0 && $x <= $totalPages) {
                array_push($data['pages'], $x);
            }
        }
   
        $offset = (int) ($currentPage - 1) * $limit;
        $persons = $this->createQuery()
            ->setOffset($offset)
            ->setLimit($limit)
            ->execute();
        $data['totalPages'] = $totalPages;
        $data['persons'] = $persons;

        return $data;
    }

    /**
     *custom method: Delete multiple entries at once.
     *
     * @var \Heiner\Heiner\Domain\Model\Person
     *
     * @return void
     */
    public function deleteMultipleEntries(array $personsToDelete)
    {
        foreach ($personsToDelete as $person) {
            $personToDelete = $this->findByUid($person);
            $this->remove($personToDelete);
        }
    }

    /**
     *custom method: search keyword based on person property via ajax.
     *
     * @param string $ajaxQuery      search query to search for
     * @param string $personProperty property of Heiner\Heiner\Domain\Model\Person to search in
     * @param string $currentPage    used to calculate  number of page-links to show and offset
     * @param string $limit          used to calculate number of total pages and offset
     *
     * @return array $data
     */
    public function ajaxSearch(
        string $ajaxQuery,
        string $personProperty,
        string $currentPage,
        string $limit
    ) {
        $limit = (int) $limit;
        $currentPage = (int) $currentPage;
        $data['pages'] = [];
        $query = $this->createQuery();
        $total = $query
            ->matching($query->like($personProperty, '%'.$ajaxQuery.'%'))
            ->count('uid');

        $linksShown = (int) 3;
        $totalPages = (int) ceil($total / $limit);
        $total = (int) $total;
        for (
            $x = $currentPage - $linksShown;
            $x < $currentPage + $linksShown + 1;
            ++$x
        ) {
            if ($x > 0 && $x <= $totalPages) {
                array_push($data['pages'], $x);
            }
        }
        $query = $this->createQuery();
        $query->matching($query->like($personProperty, '%'.$ajaxQuery.'%'));

        $offset = (int) ($currentPage - 1) * $limit;
        $offset = (int) $offset;
        $persons = $query
            ->setOffset($offset)
            ->setLimit($limit)
            ->execute();

        $data['totalPages'] = $totalPages;
        $data['persons'] = $persons;

        return $data;
    }
}