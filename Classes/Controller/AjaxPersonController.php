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
 * PersonController.
 */
class AjaxPersonController extends
    \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * personRepository.
     *
     * @var \Heiner\Heiner\Domain\Repository\PersonRepository
     */
    protected $personRepository = null;

    /**
     * companyRepository.
     *
     * @var \Heiner\Heiner\Domain\Repository\CompanyRepository
     */
    protected $companyRepository = null;

    // protected $defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;

    public function injectPersonRepository(
        \Heiner\Heiner\Domain\Repository\PersonRepository $personRepository
    ) {
        $this->personRepository = $personRepository;
    }

    public function injectCompanyRepository(
        \Heiner\Heiner\Domain\Repository\CompanyRepository $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
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
        $data = [];
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

        $lastPage = end($data['pages']);
        if ($lastPage == $data['currentPage']) {
            $isLastPage = true;
        } else {
            $isLastPage = false;
        }

        if ($data['pages']['0'] == $data['currentPage']) {
            $isFirstPage = true;
        } else {
            $isFirstPage = false;
        }
        $data['isLastPage'] = $isLastPage;
        $data['isFirstPage'] = $isFirstPage;
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data['persons']);
        $personsWithCompany = [];
        $personWithCompany = [];
        foreach ($data['persons'] as $person) {
            $personsWithCompany[] = [
                'anrede' => $person->getAnrede() ? $person->getAnrede() : '',
                'vorname' => $person->getVorname() ? $person->getVorname() : '',
                'nachname' => $person->getNachname()
                    ? $person->getNachname()
                    : '',
                'email' => $person->getEmail(),
                'telefon' => $person->getTelefon(),
                'handy' => $person->getHandy(),
                'uid' => $person->getUid(),
                'firmaUid' => $person->getFirma()
                    ? $person->getFirma()->getUid()
                    : '',
                'firmaName' => $person->getFirma()
                    ? $person->getFirma()->getName()
                    : '',
            ];
        }
        if (count($data['pages']) <= 1) {
            $data['onlyOnePage'] = true;
        }
        $data['persons'] = $personsWithCompany;

        $data = json_encode($data);

        return $data;
        // $this->view->setVariablesToRender(['data']);

        // $this->view->assign('data', $data);
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
        $lastPage = end($data['pages']);
        if ($lastPage == $data['currentPage']) {
            $isLastPage = true;
        } else {
            $isLastPage = false;
        }

        if ($data['pages']['0'] == $data['currentPage']) {
            $isFirstPage = true;
        } else {
            $isFirstPage = false;
        }

        if (count($data['pages']) == 1) {
            $data['onlyOnePage'] = true;
        } else {
            $data['onlyOnePage'] = false;
        }
        $data['isLastPage'] = $isLastPage;
        $data['isFirstPage'] = $isFirstPage;
        $data['loggedInUser'] = $loggedInUser;
        $data['defaultLimit'] = $this->settings['limitForPersons'];
        $data['currentLimit'] = $ajaxPageLimit;
        // $this->view->setVariablesToRender(['data']);
        $personsWithCompany = [];
        $personWithCompany = [];
        foreach ($data['persons'] as $person) {
            $personsWithCompany[] = [
                'anrede' => $person->getAnrede() ? $person->getAnrede() : '',
                'vorname' => $person->getVorname() ? $person->getVorname() : '',
                'nachname' => $person->getNachname()
                    ? $person->getNachname()
                    : '',
                'email' => $person->getEmail(),
                'telefon' => $person->getTelefon(),
                'handy' => $person->getHandy(),
                'uid' => $person->getUid(),
                'firmaUid' => $person->getFirma()
                    ? $person->getFirma()->getUid()
                    : '',
                'firmaName' => $person->getFirma()
                    ? $person->getFirma()->getName()
                    : '',
            ];
        }

        $data['persons'] = $personsWithCompany;

        $data = json_encode($data);

        return $data;
    }

    public function ajaxUpdateAction()
    {
        $uid = $this->request->getArgument('uid');

        $personToUpdate = $this->personRepository->findByUid($uid);
        $personToUpdate->setAnrede($this->request->getArgument('anrede'));
        $personToUpdate->setVorname($this->request->getArgument('vorname'));
        $personToUpdate->setNachname($this->request->getArgument('nachname'));
        $personToUpdate->setEmail($this->request->getArgument('email'));
        $personToUpdate->setTelefon($this->request->getArgument('telefon'));
        $personToUpdate->setHandy($this->request->getArgument('handy'));

        $personsFirma = $this->companyRepository->findByUid(
            $this->request->getArgument('firma')
        );
        $personToUpdate->setFirma($personsFirma);

        $this->personRepository->update($personToUpdate);
        $updatedPerson = $this->personRepository->findByUid($uid);
        $updatedPersonArr[] = [
            'anrede' => $updatedPerson->getAnrede(),
            'vorname' => $updatedPerson->getVorname(),
            'nachname' => $updatedPerson->getNachname(),
            'email' => $updatedPerson->getEmail(),
            'telefon' => $updatedPerson->getTelefon(),
            'handy' => $updatedPerson->getHandy(),
            'firma' => $updatedPerson->getFirma()->getName(),
            'firmaUid' => $updatedPerson->getFirma()->getUid(),
        ];
        $updatedPersonArr = json_encode($updatedPersonArr);

        return $updatedPersonArr;
    }

    public function getAllCompaniesAction()
    {
        $companies = $this->companyRepository->findAll();

        foreach ($companies as $company) {
            $companiesArr[] = [
                'name' => $company->getName(),
                'uid' => $company->getUid(),
            ];
        }
        $companiesArr = json_encode($companiesArr);
        return $companiesArr;
    }

    public function ajaxDeleteAction()
    {
        $personsToDelete = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'personsToDelete'
        );
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($personsToDelete);

        $this->personRepository->deleteMultipleEntries($personsToDelete);
        $data = 'SUCCESS';
        $data = json_encode($data);
        return $data;
        // $this->view->setVariablesToRender(['data']);
        // $this->view->assign('data', $data);
    }
}
