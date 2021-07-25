<?php
namespace Heiner\Heiner\Controller;
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
 * PersonController
 */
class PersonController extends
    \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * personRepository
     *
     * @var \Heiner\Heiner\Domain\Repository\PersonRepository
     */
    protected $personRepository = null;

    /**
     * companyRepository
     *
     * @var \Heiner\Heiner\Domain\Repository\CompanyRepository
     */

    protected $companyRepository = null;

    /**
     * @param \Heiner\Heiner\Domain\Repository\PersonRepository $personRepository
     */

    public function injectPersonRepository(
        \Heiner\Heiner\Domain\Repository\PersonRepository $personRepository
    ) {
        $this->personRepository = $personRepository;
    }

    /**
     * @param \Heiner\Heiner\Domain\Repository\CompanyRepository $companyRepository
     */

    public function injectCompanyRepository(
        \Heiner\Heiner\Domain\Repository\CompanyRepository $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    /**
     * action list
     *
     * @return void
     */

    public function listAction()
    {
        $currentPage = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'pageNumber'
        );

        if (empty($currentPage)) {
            $currentPage = 1;
        }

        $currentPage = (int) $currentPage;
        // if (!isset($ajaxPageLimit)) {
        //     $ajaxPageLimit = $this->settings['limitForPersons'];
        // }
        // $limit = (int) $this->settings['limit'];
        $limit = $this->settings['limitForPersons'];
        $limit = (int) $limit;
        $data=[];
        $data = $this->personRepository->pagination($currentPage, $limit);
        $data['pageLimit'] = [1, 2, 4, 5, 6, 8, 10];
        $data['currentPage'] = $currentPage;
        $data['nextPage'] = $currentPage + 1;
        $data['previousPage'] = $currentPage - 1;

        $loggedInUser = $GLOBALS['TSFE']->fe_user->user;

        $data['loggedInUser'] = $loggedInUser;
        $data['defaultLimit'] = $this->settings['limitForPersons'];
        if ($ajaxPageLimit) {
            $data['currentLimit'] = $ajaxPageLimit;
        }
        $this->view->assign('data', $data);
    }

    public function ajaxListAction()
    {
        if (
            !empty(\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('ajaxPageLimit'))
        ) {
            $ajaxPageLimit = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
                'ajaxPageLimit'
            );
        }
        if (!empty(\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('pageNumber'))) {
            $currentPage = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
                'pageNumber'
            );
        }

        $currentPage = (int) $currentPage;

        $ajaxPageLimit = (int) $ajaxPageLimit;
        $data=[];
        $data = $this->personRepository->pagination(
            $currentPage,
            $ajaxPageLimit
        );

      
        
        $data['pageLimit'] = [1, 2, 4, 6, 8, 10];
        $data['currentPage'] = $currentPage;
        $data['nextPage'] = $currentPage + 1;
        $data['previousPage'] = $currentPage - 1;

        $loggedInUser = $GLOBALS['TSFE']->fe_user->user;
        $data['currentLimit'] = $ajaxPageLimit;
        $data['loggedInUser'] = $loggedInUser;
        $data['defaultLimit'] = $this->settings['limitForPersons'];

        $haLllo="'ahalallala";
        // return json_encode($haLllo);
        $this->view->assign('json', $haLllo );
    }

    public function ajaxSearchAction()
    {
        $query = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('query');

        $personProperty = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'personProperty'
        );

        $limit = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('limit');

        $currentPage = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'currentPage'
        );
        $data = [];

        $data = $this->personRepository->ajaxSearch(
            $query,
            $personProperty,
            $currentPage,
            $limit
        );
        $data['currentPage'] = $currentPage;
        $data['nextPage'] = $currentPage + 1;
        $data['previousPage'] = $currentPage - 1;

        $loggedInUser = $GLOBALS['TSFE']->fe_user->user;

        $data['loggedInUser'] = $loggedInUser;
        $data['defaultLimit'] = $ajaxPageLimit;
        $loggedInUser = $GLOBALS['TSFE']->fe_user->user;

        $data['loggedInUser'] = $loggedInUser;
        $data['defaultLimit'] = $this->settings['limitForPersons'];
        $data['currentLimit'] = $ajaxPageLimit;

        $this->view->assign('data', $data);
    }

    /**
     * show all Persons for a corresponding company
     *
     * @param \Heiner\Heiner\Domain\Model\Person $person
     * @return void
     */

    public function showAction(\Heiner\Heiner\Domain\Model\Person $person)
    {
        $persons = $this->personRepository->findAllPersonsBelongingToCompany(
            $person->getFirma()->getUid()
        );

        $this->view->assign('persons', $persons);
    }

    /**
     * action new
     * get all companies to populate select menu with domain models of Company
     * @return void
     */

    public function newAction()
    {
        $companies = $this->companyRepository->findAll();
        $this->view->assign('companies', $companies);
    }

    /**
     *
     * action create
     *
     * @param \Heiner\Heiner\Domain\Model\Person $newPerson
     * @return void
     */

    public function createAction(\Heiner\Heiner\Domain\Model\Person $newPerson)
    {
        $this->personRepository->add($newPerson);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \Heiner\Heiner\Domain\Model\Person $person
     * @ignorevalidation $person
     * @return void
     */

    public function editAction(\Heiner\Heiner\Domain\Model\Person $person)
    {
        $allCompanies = $this->companyRepository->findAll();
        $data['allCompanies'] = $allCompanies;
        $data['person'] = $person;
        $this->view->assign('data', $data);
    }

    /**
     * update action: called when the company data is edited and submitted. Gets the updated company and saves it to the database
     * @param \Heiner\Heiner\Domain\Model\Person $person
     * @return void
     */

    public function updateAction(\Heiner\Heiner\Domain\Model\Person $person)
    {
        $this->personRepository->update($person);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \Heiner\Heiner\Domain\Model\Person $person
     * @return void
     */
    public function deleteAction(\Heiner\Heiner\Domain\Model\Person $person)
    {
        $this->personRepository->remove($person);
        $this->redirect('list');
    }
    /**
     * custom method for deleting multiple entries at once; getting a comma-seperated list of uids to delete
     * @var array $personsToDelete Array of person uids to delete
     * @return void
     */
    public function deleteMultipleEntriesAction()
    {
        $personsToDelete = $this->request->getArguments()['personsToDelete'];
        $this->personRepository->deleteMultipleEntries($personsToDelete);
        $this->redirect('list');
    }
}