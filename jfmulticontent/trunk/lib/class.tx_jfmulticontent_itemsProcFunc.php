<?php/*************************************************************** *  Copyright notice * *  (c) 2009 Juergen Furrer <juergen.furrer@gmail.com> *  All rights reserved * *  This script is part of the TYPO3 project. The TYPO3 project is *  free software; you can redistribute it and/or modify *  it under the terms of the GNU General Public License as published by *  the Free Software Foundation; either version 2 of the License, or *  (at your option) any later version. * *  The GNU General Public License can be found at *  http://www.gnu.org/copyleft/gpl.html. * *  This script is distributed in the hope that it will be useful, *  but WITHOUT ANY WARRANTY; without even the implied warranty of *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the *  GNU General Public License for more details. * *  This copyright notice MUST APPEAR in all copies of the script! ***************************************************************/require_once (PATH_t3lib . 'class.t3lib_page.php');/** * 'itemsProcFunc' for the 'jfmulticontent' extension. * * @author     Juergen Furrer <juergen.furrer@gmail.com> * @package    TYPO3 * @subpackage tx_jfmulticontent */class tx_jfmulticontent_itemsProcFunc{	/**	 * Get defined Class inner for drupdown	 * @return array	 */	function getClassInner($config, $item)	{		$setup = $this->loadTS($config['row']['pid']);		$items = t3lib_div::trimExplode(",", $setup['plugin.']['tx_jfmulticontent_pi1.']['classInner']);		if (count($items) < 1) {			$items = array('','16','20','25','33','38','40','50','60','62','66','75','80');		}		$optionList = array();		foreach ($items as $item) {			$optionList[] = array(				trim($item),				trim($item)			);		}		$config['items'] = array_merge($config['items'], $optionList);		return $config;	}	/**	 * Get the setup of the curront page	 * @param integer $pageUid	 * @return void	 */	function loadTS($pageUid) {		$sysPageObj = t3lib_div::makeInstance('t3lib_pageSelect');		$rootLine = $sysPageObj->getRootLine($pageUid);		$TSObj = t3lib_div::makeInstance('t3lib_tsparser_ext');		$TSObj->tt_track = 0;		$TSObj->init();		$TSObj->runThroughTemplates($rootLine);		$TSObj->generateConfig();		return $TSObj->setup;	}}if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jfmulticontent/lib/class.tx_jfmulticontent_itemsProcFunc.php']) {	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jfmulticontent/lib/class.tx_jfmulticontent_itemsProcFunc.php']);}?>