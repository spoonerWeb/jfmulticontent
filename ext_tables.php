<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// get extension configuration
$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jfmulticontent']);

$tempColumns = [
    'tx_jfmulticontent_view' => [
        'exclude' => 1,
        'onChange' => 'reload',
        'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.view',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'size' => 1,
            'maxitems' => 1,
            'default' => 'content',
            'items' => [
                ['LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.view.I.0', 'content'],
                ['LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.view.I.1', 'page'],
                ['LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.view.I.2', 'irre'],
            ],
            'itemsProcFunc' => 'EXT:jfmulticontent/lib/class.tx_jfmulticontent_itemsProcFunc.php:&tx_jfmulticontent_itemsProcFunc->getViews',
        ]
    ],
    'tx_jfmulticontent_pages' => [
        'exclude' => 1,
        'displayCond' => 'FIELD:tx_jfmulticontent_view:IN:page',
        'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.pages',
        'config' => [
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'pages',
            'size' => 12,
            'minitems' => 0,
            'maxitems' => 1000,
            'wizards' => [
                'suggest' => [
                    'type' => 'suggest',
                ],
            ],
        ]
    ],
    'tx_jfmulticontent_irre' => [
        'exclude' => 1,
        'displayCond' => 'FIELD:tx_jfmulticontent_view:IN:irre',
        'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.irre',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tt_content',
            'foreign_field' => 'tx_jfmulticontent_irre_parentid',
            'foreign_sortby' => 'sorting',
            'foreign_label' => 'header',
            'maxitems' => 1000,
            'appearance' => [
                'showSynchronizationLink' => false,
                'showAllLocalizationLink' => false,
                'showPossibleLocalizationRecords' => false,
                'showRemovedLocalizationRecords' => false,
                'expandSingle' => true,
                'newRecordLinkAddTitle' => true,
                'useSortable' => true,
            ],
            'behaviour' => [
                'localizeChildrenAtParentLocalization' => 1,
                'localizationMode' => 'select',
            ],
        ]
    ],
];

if ($confArr['useStoragePidOnly']) {
    $tempColumns['tx_jfmulticontent_contents'] = [
        'exclude' => 1,
        'displayCond' => 'FIELD:tx_jfmulticontent_view:IN:,content',
        'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'tt_content',
            'foreign_table_where' => 'AND tt_content.pid=###STORAGE_PID### AND tt_content.hidden=0 AND tt_content.deleted=0 AND tt_content.sys_language_uid IN (0,-1) ORDER BY tt_content.uid',
            'size' => 12,
            'minitems' => 0,
            'maxitems' => 1000,
            'wizards' => [
                '_PADDING' => 2,
                '_VERTICAL' => 1,
                'add' => [
                    'type' => 'script',
                    'title' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents_add',
                    'icon' => 'add.gif',
                    'module' => [
                        'name' => 'wizard_add'
                    ],
                    'params' => [
                        'table' => 'tt_content',
                        'pid' => '###STORAGE_PID###',
                        'setValue' => 'prepend'
                    ],
                ],
                'list' => [
                    'type' => 'script',
                    'title' => 'List',
                    'icon' => 'list.gif',
                    'module' => [
                        'name' => 'wizard_list'
                    ],
                    'params' => [
                        'table' => 'tt_content',
                        'pid' => '###STORAGE_PID###',
                    ],
                ],
                'edit' => [
                    'type' => 'popup',
                    'title' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents_edit',
                    'icon' => 'edit2.gif',
                    'module' => [
                        'name' => 'wizard_edit'
                    ],
                    'popup_onlyOpenIfSelected' => 1,
                    'JSopenParams' => 'height=600,width=800,status=0,menubar=0,scrollbars=1',
                ],
            ],
        ]
    ];
} else {
    $tempColumns['tx_jfmulticontent_contents'] = [
        'exclude' => 1,
        'displayCond' => 'FIELD:tx_jfmulticontent_view:IN:,content',
        'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents',
        'config' => [
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tt_content',
            'size' => 12,
            'minitems' => 0,
            'maxitems' => 1000,
            'wizards' => [
                '_PADDING' => 2,
                '_VERTICAL' => 1,
                'add' => [
                    'type' => 'script',
                    'title' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents_add',
                    'icon' => 'add.gif',
                    'module' => [
                        'name' => 'wizard_add'
                    ],
                    'params' => [
                        'table' => 'tt_content',
                        'pid' => '###STORAGE_PID###',
                        'setValue' => 'prepend'
                    ],
                ],
                'list' => [
                    'type' => 'script',
                    'title' => 'List',
                    'icon' => 'list.gif',
                    'module' => [
                        'name' => 'wizard_list'
                    ],
                    'params' => [
                        'table' => 'tt_content',
                        'pid' => '###STORAGE_PID###',
                    ],
                ],
                'edit' => [
                    'type' => 'popup',
                    'title' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents_edit',
                    'icon' => 'edit2.gif',
                    'module' => [
                        'name' => 'wizard_edit'
                    ],
                    'popup_onlyOpenIfSelected' => 1,
                    'JSopenParams' => 'height=600,width=800,status=0,menubar=0,scrollbars=1',
                ],
            ],
        ]
    ];
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns, 1);
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi1'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'tx_jfmulticontent_view,tx_jfmulticontent_pages,tx_jfmulticontent_contents,tx_jfmulticontent_irre,pi_flexform';
// Add reload field to tt_content
$TCA['tt_content']['ctrl']['requestUpdate'] .= ($TCA['tt_content']['ctrl']['requestUpdate'] ? ',' : '') . 'tx_jfmulticontent_view';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.list_type_pi1',
        $_EXTKEY . '_pi1',
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
    ],
    'list_type'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $_EXTKEY . '_pi1',
    'FILE:EXT:' . $_EXTKEY . '/flexform_ds.xml'
);

if (TYPO3_MODE === 'BE') {
    $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_jfmulticontent_pi1_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'pi1/class.tx_jfmulticontent_pi1_wizicon.php';
    if (!isset($TCA['tt_content']['columns']['colPos']['config']['items'][$confArr['colPosOfIrreContent']])) {
        // Add the new colPos to the array, only if the ID does not exist...
        $TCA['tt_content']['columns']['colPos']['config']['items'][$confArr['colPosOfIrreContent']] = [
            $_EXTKEY,
            $confArr['colPosOfIrreContent']
        ];
    }
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'static/', 'Multi content');
