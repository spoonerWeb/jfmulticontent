<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Juergen Furrer <juergen.furrer@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * 'itemsProcFunc' for the 'jfmulticontent' extension.
 *
 * @author     Juergen Furrer <juergen.furrer@gmail.com>
 * @package    TYPO3
 * @subpackage tx_jfmulticontent
 */
class tx_jfmulticontent_itemsProcFunc
{
    /**
     * Get defined views for dropdown (from hook)
     *
     * @return array
     */
    public function getViews($config, $item)
    {
        $optionList = [];
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['jfmulticontent']['getViews'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['jfmulticontent']['getViews'] as $_classRef) {
                $_procObj = GeneralUtility::getUserObj($_classRef);
                if (!method_exists($_procObj, 'isActive') || (method_exists($_procObj, 'isActive') && $_procObj->isActive())) {
                    $optionList[] = [
                        trim($_procObj->getname()),
                        trim($_procObj->getIdentifier()),
                    ];
                }
            }
        }
        $config['items'] = array_merge($config['items'], $optionList);

        return $config;
    }

    /**
     * Get the defined styles by pagesetup
     *
     * @param array $config
     * @param array $item
     * @return array
     */
    public function getStyle($config, $item)
    {
        $allStyles = [
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.0'),
                '2column',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_0.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.1'),
                '3column',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_1.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.2'),
                '4column',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_2.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.6'),
                '5column',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_6.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.3'),
                'tab',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_3.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.4'),
                'accordion',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_4.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.5'),
                'slider',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_5.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.7'),
                'slidedeck',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_7.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.8'),
                'easyaccordion',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_8.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.9'),
                'booklet',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_9.gif',
            ],
            [
                $GLOBALS['LANG']->sL('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.style.I.10'),
                'typoscript',
                'EXT:jfmulticontent/selicon_tt_content_tx_jfmulticontent_style_10.png',
            ],
        ];
        $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jfmulticontent']);
        $styles = $confArr['style.'];
        if (count($styles) > 0) {
            foreach ($styles as $key => $val) {
                if ($val) {
                    $availableStyles[] = $key;
                }
            }
        }
        if (count($availableStyles) < 1) {
            $availableStyles = [
                '2column',
                '3column',
                '4column',
                '5column',
                'tab',
                'accordion',
                'slider',
                'slidedeck',
                'easyaccordion',
                'booklet'
            ];
        }
        $allowedStyles = [];
        foreach ($allStyles as $key => $style) {
            if (in_array(trim($style[1]), $availableStyles)) {
                $allowedStyles[] = $style;
            }
        }
        $pageTS = BackendUtility::getPagesTSconfig($config['row']['pid']);
        $jfmulticontentStyles = GeneralUtility::trimExplode(",", $pageTS['mod.']['jfmulticontent.']['availableStyles'], true);
        $optionList = [];
        if (count($jfmulticontentStyles) > 0) {
            foreach ($allowedStyles as $key => $style) {
                if (in_array(trim($style[1]), $jfmulticontentStyles)) {
                    $optionList[] = $style;
                }
            }
        } else {
            $optionList = $allowedStyles;
        }
        $config['items'] = array_merge($config['items'], $optionList);

        return $config;
    }

    /**
     * Get defined Class inner for dropdown
     *
     * @return array
     */
    public function getClassInner($config, $item)
    {
        $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jfmulticontent']);
        $availableClasses = GeneralUtility::trimExplode(",", $confArr['classInner']);
        if (count($availableClasses) < 1 || !$confArr['classInner']) {
            $availableClasses = ['', '16', '20', '25', '33', '38', '40', '50', '60', '62', '66', '75', '80'];
        }
        $pageTS = BackendUtility::getPagesTSconfig($config['row']['pid']);
        $jfmulticontentClasses = GeneralUtility::trimExplode(",", $pageTS['mod.']['jfmulticontent.']['classInner'], true);
        $optionList = [];
        if (count($jfmulticontentClasses) > 0) {
            foreach ($availableClasses as $key => $availableClass) {
                if (in_array(trim($availableClass), $jfmulticontentClasses)) {
                    $optionList[] = [
                        trim($availableClass),
                        trim($availableClass),
                    ];
                }
            }
        } else {
            foreach ($availableClasses as $key => $availableClass) {
                $optionList[] = [
                    trim($availableClass),
                    trim($availableClass),
                ];
            }
        }
        $config['items'] = array_merge($config['items'], $optionList);

        return $config;
    }

    /**
     * Get all themes for anythingSlider
     *
     * @return array
     */
    public function getAnythingSliderThemes($config, $item)
    {
        $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jfmulticontent']);
        if (!is_dir(GeneralUtility::getFileAbsFileName($confArr['anythingSliderThemeFolder']))) {
            // if the defined folder does not exist, define the default folder
            $confArr['anythingSliderThemeFolder'] = "EXT:jfmulticontent/res/anythingslider/themes/";
        }
        $items = GeneralUtility::get_dirs(GeneralUtility::getFileAbsFileName($confArr['anythingSliderThemeFolder']));
        if (count($items) > 0) {
            $optionList = [];
            foreach ($items as $key => $item) {
                $item = trim($item);
                if (strpos($item, "\.") === false) {
                    $optionList[] = [
                        $item,
                        $item
                    ];
                }
            }
            $config['items'] = array_merge($config['items'], $optionList);
        }

        return $config;
    }

    /**
     * Get all modes for anythingSlider
     *
     * @return array
     */
    public function getAnythingSliderModes($config, $item)
    {
        $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jfmulticontent']);
        $availableModes = GeneralUtility::trimExplode(",", $confArr['anythingSliderModes']);
        if (count($availableModes) < 1 || !$confArr['anythingSliderModes']) {
            $availableModes = ['horizontal', 'vertical', 'fade'];
        }
        $pageTS = BackendUtility::getPagesTSconfig($config['row']['pid']);
        $jfmulticontentModes = GeneralUtility::trimExplode(",", $pageTS['mod.']['jfmulticontent.']['anythingSliderModes'], true);
        $optionList = [];
        if (count($jfmulticontentModes) > 0) {
            foreach ($availableModes as $key => $availableMode) {
                if (in_array(trim($availableMode), $jfmulticontentModes)) {
                    $optionList[] = [
                        trim($availableMode),
                        trim($availableMode),
                    ];
                }
            }
        } else {
            foreach ($availableModes as $key => $availableMode) {
                $optionList[] = [
                    trim($availableMode),
                    trim($availableMode),
                ];
            }
        }
        $config['items'] = array_merge($config['items'], $optionList);

        return $config;
    }

    /**
     * Get all skins for easyAccordion
     *
     * @return array
     */
    public function getEasyaccordionSkin($config, $item)
    {
        $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jfmulticontent']);
        if (!is_dir(GeneralUtility::getFileAbsFileName($confArr['easyAccordionSkinFolder']))) {
            // if the defined folder does not exist, define the default folder
            $confArr['easyAccordionSkinFolder'] = "EXT:jfmulticontent/res/easyaccordion/skins/";
        }
        $items = GeneralUtility::get_dirs(GeneralUtility::getFileAbsFileName($confArr['easyAccordionSkinFolder']));
        if (count($items) > 0) {
            $optionList = [];
            foreach ($items as $key => $item) {
                $item = trim($item);
                if (strpos($item, "\.") === false) {
                    $optionList[] = [
                        ucfirst($item),
                        $item
                    ];
                }
            }
            $config['items'] = array_merge($config['items'], $optionList);
        }

        return $config;
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/jfmulticontent/lib/class.tx_jfmulticontent_itemsProcFunc.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/jfmulticontent/lib/class.tx_jfmulticontent_itemsProcFunc.php']);
}
