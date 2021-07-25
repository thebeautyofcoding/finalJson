<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Heiner.Heiner',
            'Persons',
            'Persons'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Heiner.Heiner',
            'Companies',
            'Companies'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('heiner', 'Configuration/TypoScript', 'personenundfirmen');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_heiner_domain_model_person', 'EXT:heiner/Resources/Private/Language/locallang_csh_tx_heiner_domain_model_person.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_heiner_domain_model_person');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_heiner_domain_model_company', 'EXT:heiner/Resources/Private/Language/locallang_csh_tx_heiner_domain_model_company.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_heiner_domain_model_company');

    }
);
$pluginSignature='heiner_persons';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature]="pi_flexform";
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:heiner/Configuration/FlexForms/PaginationForPersons.xml');


$pluginSignature='heiner_companies';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature]="pi_flexform";
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:heiner/Configuration/FlexForms/PaginationForCompanies.xml');

