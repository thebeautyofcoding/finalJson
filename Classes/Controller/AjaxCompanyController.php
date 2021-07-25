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
class AjaxCompanyController extends
    \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * companyToUpdate.
     *
     * @var \Heiner\Heiner\Domain\Repository\companyToUpdate
     */
    protected $companyToUpdate = null;

    /**
     * companyRepository.
     *
     * @var \Heiner\Heiner\Domain\Repository\CompanyRepository
     */
    protected $companyRepository = null;

    // protected $defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;

    // public function injectcompanyToUpdate(
    //     \Heiner\Heiner\Domain\Repository\companyToUpdate $companyToUpdate
    // ) {
    //     $this->companyToUpdate = $companyToUpdate;
    // }

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
        $data = $this->companyRepository->pagination(
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
        $companies = [];
        $companies = [];
        foreach ($data['companies'] as $company) {
            $companies[] = [
                'name' => $company->getName() ? $company->getName() : '',
                'unterzeile' => $company->getUnterzeile()
                    ? $company->getUnterzeile()
                    : '',
                'strasse' => $company->getStrasse()
                    ? $company->getStrasse()
                    : '',
                'plz' => $company->getPlz(),
                'ort' => $company->getOrt(),
                'telefon' => $company->getTelefon(),
                'fax' => $company->getFax(),
                'web' => $company->getWeb(),
                'uid' => $company->getUid(),
            ];
        }
        if (count($data['pages']) <= 1) {
            $data['onlyOnePage'] = true;
        }else{
            $data['onlyOnePage'] = false;
        }
        $data['companies'] = $companies;

        $data = json_encode($data);

        return $data;
        // $this->view->setVariablesToRender(['data']);

        // $this->view->assign('data', $data);
    }

    public function ajaxSearchAction()
    {
        $query = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('query');

        $companyProperty = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'companyProperty'
        );

        $limit = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('limit');

        $currentPage = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'currentPage'
        );
        $data = [];

        $data = $this->companyRepository->ajaxSearch(
            $query,
            $companyProperty,
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
        $data['isLastPage'] = $isLastPage;
        $data['isFirstPage'] = $isFirstPage;
        $data['loggedInUser'] = $loggedInUser;
        $data['defaultLimit'] = $this->settings['limitForPersons'];
        $data['currentLimit'] = $ajaxPageLimit;
        // $this->view->setVariablesToRender(['data']);
        $companies = [];
        $companies = [];
        foreach ($data['companies'] as $company) {
            $companies[] = [
                'name' => $company->getName() ? $company->getName() : '',
                'unterzeile' => $company->getUnterzeile()
                    ? $company->getUnterzeile()
                    : '',
                'strasse' => $company->getStrasse()
                    ? $company->getStrasse()
                    : '',
                'plz' => $company->getPlz(),
                'ort' => $company->getOrt(),
                'telefon' => $company->getTelefon(),
                'fax' => $company->getFax(),
                'web' => $company->getWeb(),
                'uid' => $company->getUid(),
            ];
        }
        if (count($data['pages']) <= 1) {
            $data['onlyOnePage'] = true;
        }else{
            $data['onlyOnePage'] = false;
        }
        $data['companies'] = $companies;

        $data = json_encode($data);

        return $data;
    }

    public function ajaxUpdateAction()
    {
        $uid = $this->request->getArgument('uid');

        $companyToUpdate = $this->companyRepository->findByUid($uid);
        $companyToUpdate->setName($this->request->getArgument('name'));
        $companyToUpdate->setUnterzeile(
            $this->request->getArgument('unterzeile')
        );
        $companyToUpdate->setStrasse($this->request->getArgument('strasse'));
        $companyToUpdate->setPlz($this->request->getArgument('plz'));
        $companyToUpdate->setOrt($this->request->getArgument('ort'));
        $companyToUpdate->setTelefon($this->request->getArgument('telefon'));
        $companyToUpdate->setWeb($this->request->getArgument('web'));

        $this->companyRepository->update($companyToUpdate);
        $updatedCompany = $this->companyRepository->findByUid($uid);
        $updatedCompanyArr[] = [
            'name' => $updatedCompany->getName(),
            'unterzeile' => $updatedCompany->getUnterzeile(),
            'strasse' => $updatedCompany->getStrasse(),
            'plz' => $updatedCompany->getPlz(),
            'ort' => $updatedCompany->getOrt(),
            'telefon' => $updatedCompany->getTelefon(),
            'web' => $updatedCompany->getWeb(),
            'uid' => $updatedCompany->getUid(),
        ];
        $updatedCompanyArr = json_encode($updatedCompanyArr);

        return $updatedCompanyArr;
    }

    // public function getAllCompaniesAction()
    // {
    //     $companies = $this->companyRepository->findAll();

    //     foreach($companies as $company){
    //         $companiesArr[]=[
    //             'name'=>$company->getName(),
    //             'uid'=>$company->getUid()
    //           ];
    //     }
    //    $companiesArr=json_encode( $companiesArr);
    //     return $companiesArr;
    // }

    public function ajaxDeleteAction()
    {
        $companiesToDelete = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'companiesToDelete'
        );
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($personsToDelete);

        $this->companyRepository->deleteMultipleEntries($companiesToDelete);
        $data = 'SUCCESS';
        $data = json_encode($data);
        return $data;
        // $this->view->setVariablesToRender(['data']);
        // $this->view->assign('data', $data);
    }
}
