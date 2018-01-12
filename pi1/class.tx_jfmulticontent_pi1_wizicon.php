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
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

/**
 * Class that adds the wizard icon.
 *
 * @author    Juergen Furrer <juergen.furrer@gmail.com>
 * @package    TYPO3
 * @subpackage    tx_jfmulticontent
 */
class tx_jfmulticontent_pi1_wizicon
{
    /**
     * Processing the wizard items array
     *
     * @param    array $wizardItems : The wizard items
     * @return    Modified array with wizard items
     */
    public function proc($wizardItems)
    {
        $LL = $this->includeLocalLang();
        $wizardItems['plugins_tx_jfmulticontent_pi1'] = [
            'icon' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('jfmulticontent') . 'pi1/ce_wiz.gif',
            'title' => $GLOBALS['LANG']->getLLL('pi1_title', $LL),
            'description' => $GLOBALS['LANG']->getLLL('pi1_plus_wiz_description', $LL),
            'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=jfmulticontent_pi1'
        ];

        return $wizardItems;
    }

    /**
     * Reads the [extDir]/locallang.xml and returns the $LOCAL_LANG array found in that file.
     *
     * @return    The array with language labels
     */
    public function includeLocalLang()
    {
        $llFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('jfmulticontent') . 'locallang.xml';
        /** @var $llxmlParser \TYPO3\CMS\Core\Localization\Parser\LocallangXmlParser */
        $llxmlParser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Localization\Parser\LocallangXmlParser::class);
        $LOCAL_LANG = $llxmlParser->getParsedData($llFile, $GLOBALS['LANG']->lang);

        return $LOCAL_LANG;
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/jfmulticontent/pi1/class.tx_jfmulticontent_pi1_wizicon.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/jfmulticontent/pi1/class.tx_jfmulticontent_pi1_wizicon.php']);
}
