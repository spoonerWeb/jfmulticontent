<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

if ($confArr['ttNewsCodes']) {
    // Add the additional CODES to tt_news
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['what_to_display'][] = [
        0 => 'LIST_ACCORDION',
        1 => 'LIST_ACCORDION'
    ];
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['what_to_display'][] = [
        0 => 'LIST_SLIDER',
        1 => 'LIST_SLIDER'
    ];
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['what_to_display'][] = [
        0 => 'LIST_SLIDEDECK',
        1 => 'LIST_SLIDEDECK'
    ];
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['what_to_display'][] = [
        0 => 'LIST_EASYACCORDION',
        1 => 'LIST_EASYACCORDION'
    ];
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['extraCodesHook'][] = 'EXT:' . $_EXTKEY . '/lib/class.tx_jfmulticontent_ttnews_extend.php:tx_jfmulticontent_ttnews_extend';
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['extraGlobalMarkerHook'][] = 'EXT:' . $_EXTKEY . '/lib/class.tx_jfmulticontent_ttnews_extend.php:tx_jfmulticontent_ttnews_extend';
}

// Page module hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['jfmulticontent_pi1']['jfmulticontent'] = 'EXT:' . $_EXTKEY . '/lib/class.tx_jfmulticontent_cms_layout.php:tx_jfmulticontent_cms_layout->getExtensionSummary';

// Save the content
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] = 'EXT:' . $_EXTKEY . '/lib/class.tx_jfmulticontent_tcemain.php:&tx_jfmulticontent_tcemain';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
    $_EXTKEY,
    'pi1/class.tx_jfmulticontent_pi1.php',
    '_pi1',
    'list_type',
    1
);
