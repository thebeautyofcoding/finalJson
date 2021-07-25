<?php

defined('TYPO3_MODE') || exit('Access denied.');

call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Heiner.Heiner',
        'Persons',
        [
            'Person' =>
                'list, show, new, create, edit, update, delete, deleteMultipleEntries, ajaxList, ajaxSearch',
            'Company' => 'list, show, new, create, edit, update, delete',
            'AjaxPerson' =>
                'ajaxList, ajaxUpdate, getAllCompanies, ajaxSearch, ajaxDelete',
            'AjaxCompany' =>
                'ajaxList, ajaxUpdate, getAllCompanies, ajaxSearch, ajaxDelete',
        ],
        // non-cacheable actions
        [
            'Person' =>
                'list, show, new, create, edit, update, delete,deleteMultipleEntries, ajaxList, ajaxSearch',
            'Company' => 'list, show, new, create, edit, update, delete',
            'AjaxPerson' =>
                'ajaxList, ajaxUpdate, getAllCompanies, ajaxSearch, ajaxDelete',
            'AjaxCompany' =>
                'ajaxList, ajaxUpdate, getAllCompanies, ajaxSearch, ajaxDelete',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Heiner.Heiner',
        'Companies',
        [
            'Company' =>
                'list, show, new, create, edit, update, delete, deleteMultipleEntries, ajaxSearch, ajaxList',
            'Person' =>
                'list, show, new, create, edit, update, delete, deleteMultipleEntries, ajaxList, ajaxSearch',
            'AjaxPerson' =>
                'ajaxList, ajaxUpdate, getAllCompanies, ajaxSearch,ajaxDelete',
            'AjaxCompany' =>
                'ajaxList, ajaxUpdate, getAllCompanies, ajaxSearch, ajaxDelete',
        ],
        // non-cacheable actions
        [
            'Company' =>
                'list, show, new, create, edit, update, delete, deleteMultipleEntries, ajaxSearch, ajaxList',
            'Person' =>
                'list, show, new, create, edit, update, delete, deleteMultipleEntries, ajaxList, ajaxSearch',
            'AjaxPerson' =>
                'ajaxList, ajaxUpdate, getAllCompanies, ajaxSearch, ajaxDelete',
            'AjaxCompany' =>
                'ajaxList, ajaxUpdate, getAllCompanies, ajaxSearch, ajaxDelete',
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        persons {
                            iconIdentifier = heiner-plugin-persons
                            title = LLL:EXT:heiner/Resources/Private/Language/locallang_db.xlf:tx_heiner_persons.name
                            description = LLL:EXT:heiner/Resources/Private/Language/locallang_db.xlf:tx_heiner_persons.description
                            tt_content_defValues {
                                CType = list
                                list_type = heiner_persons
                            }
                        }
                        companies {
                            iconIdentifier = heiner-plugin-companies
                            title = LLL:EXT:heiner/Resources/Private/Language/locallang_db.xlf:tx_heiner_companies.name
                            description = LLL:EXT:heiner/Resources/Private/Language/locallang_db.xlf:tx_heiner_companies.description
                            tt_content_defValues {
                                CType = list
                                list_type = heiner_companies
                            }
                        }
                    }
                    show = *
                }
           }'
    );
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );

    $iconRegistry->registerIcon(
        'heiner-plugin-persons',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' =>
                'EXT:heiner/Resources/Public/Icons/user_plugin_persons.svg',
        ]
    );

    $iconRegistry->registerIcon(
        'heiner-plugin-companies',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' =>
                'EXT:heiner/Resources/Public/Icons/user_plugin_companies.svg',
        ]
    );
});
