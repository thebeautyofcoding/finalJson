<?php
namespace Heiner\Heiner\Controller;

/***
 *
 * This file is part of the "companyenundfirmen" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Heiner Giehl <heiner.giehl@tu-dortmund.de>, HeinerGiehl
 *
 ***/
/**
 * CompanyController
 */
class CompanyController extends
    \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * companyRepository
     *
     * @var \Heiner\Heiner\Domain\Repository\CompanyRepository
     */
    protected $companyRepository = null;

    /**
     * @param \Heiner\Heiner\Domain\Repository\CompanyRepository $companyRepository
     */
    public function injectCompanyRepository(
        \Heiner\Heiner\Domain\Repository\CompanyRepository $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    /**
     * list action with pagination implemented
     *
     * @return void
     */
    public function listAction()
    {
        $currentPage = $this->request->getArguments()['pageNumber'];
        if (empty($currentPage)) {
            $currentPage = 1;
        }
        $currentPage = (int) $currentPage;
        $limit = (int) $this->settings['limitForCompanies'];
        $data = $this->companyRepository->pagination($currentPage, $limit);
        $data['pageLimit'] = [1, 2, 4, 6, 8, 10];
        $data['currentPage'] = $currentPage;
        $data['nextPage'] = $currentPage + 1;
        $data['previousPage'] = $currentPage - 1;
        $data['defaultLimit'] = $this->settings['limitForCompanies'];
        $loggedInUser = $GLOBALS['TSFE']->fe_user->user;
        $data['loggedInUser'] = $loggedInUser;

        $this->view->assign('data', $data);
    }

    /**
     * action show
     *
     * @param \Heiner\Heiner\Domain\Model\Company $company
     * @return void
     */
    // public function showAction(\Heiner\Heiner\Domain\Model\Company $company)
    // {
    //     $this->view->assign('company', $company);
    // }

    /**
     * new action, showing the the new view with input fields to be filled out
     *
     * @return void
     */

    public function newAction()
    {
    }

    /**
     * create Action: getting the new domain model instance of a company and adding it to the database
     *
     * @param \Heiner\Heiner\Domain\Model\Company $newCompany
     * @return void
     */
    public function createAction(
        \Heiner\Heiner\Domain\Model\Company $newCompany
    ) {
        // $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->companyRepository->add($newCompany);
        $this->redirect('list');
    }

    /**
     * edit action: getting the domain model instance of a company; populating the company field inputs with the company data to be edited
     *
     * @param \Heiner\Heiner\Domain\Model\Company $company
     * @ignorevalidation $company
     * @return void
     */
    public function editAction(\Heiner\Heiner\Domain\Model\Company $company)
    {
        $this->view->assign('company', $company);
    }

    /**
     * update action: called when the company data is edited and submitted. Gets the updated company and saves it to the database.
     *
     * @param \Heiner\Heiner\Domain\Model\Company $company
     * @return void
     */
    public function updateAction(\Heiner\Heiner\Domain\Model\Company $company)
    {
        $this->companyRepository->update($company);
        $this->redirect('list');
    }

    /**
     * delete action: deleting the corresponding domain model instance $company
     *
     * @param \Heiner\Heiner\Domain\Model\Company $company
     * @return void
     */
    public function deleteAction(\Heiner\Heiner\Domain\Model\Company $company)
    {
        $this->companyRepository->remove($company);
        $this->redirect('list');
    }

    /**
     * custom function for deleting multiple entries at once
     * @return void
     */
    public function deleteMultipleEntriesAction()
    {
        $companiesToDelete = $this->request->getArguments()[
            'companiesToDelete'
        ];

        $this->companyRepository->deleteMultipleEntries($companiesToDelete);
        $this->redirect('list');
    }

    // public function searchAction(){

    //     $this->view->assign('possibleSearchTerms', $possibleSearchTerms);
    // }

    public function ajaxListAction()
    {
        $ajaxPageLimit = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'ajaxPageLimit'
        );
        $currentPage = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP(
            'pageNumber'
        );

        if (empty($currentPage)) {
            $currentPage = 1;
        }
        $data=[];
        $currentPage = (int) $currentPage;

  
        $ajaxPageLimit = (int) $ajaxPageLimit;
        $data = $this->companyRepository->pagination(
            $currentPage,
            $ajaxPageLimit
        );

     
        $data['pageLimit'] = [1, 2, 4, 6, 8, 10];
        $data['currentPage'] = $currentPage;
        $data['nextPage'] = $currentPage + 1;
        $data['previousPage'] = $currentPage - 1;

        $loggedInUser = $GLOBALS['TSFE']->fe_user->user;
       
        $data['loggedInUser'] = $loggedInUser;
        $data['defaultLimit'] = $this->settings['limitForCompanies'];
        $data['currentLimit'] = $ajaxPageLimit;
       
        $this->view->assign('data', $data);
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
        $data=[];

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

        $data['loggedInUser'] = $loggedInUser;
        $data['defaultLimit'] = $this->settings['limitForCompanies'];
        $data['currentLimit'] = $ajaxPageLimit;
      
        $this->view->assign('data', $data);
    }
}