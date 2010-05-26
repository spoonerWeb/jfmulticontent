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

require_once(PATH_tslib.'class.tslib_pibase.php');

if (t3lib_extMgm::isLoaded('t3jquery')) {
	require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
}


/**
 * Plugin 'Multiple Content' for the 'jfmulticontent' extension.
 *
 * @author     Juergen Furrer <juergen.furrer@gmail.com>
 * @package    TYPO3
 * @subpackage tx_jfmulticontent
 */
class tx_jfmulticontent_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_jfmulticontent_pi1';               // Same as class name
	var $scriptRelPath = 'pi1/class.tx_jfmulticontent_pi1.php'; // Path to this script relative to the extension dir.
	var $extKey        = 'jfmulticontent';                      // The extension key.
	var $pi_checkCHash = true;
	var $lConf = array();
	var $templateFile = null;
	var $templateFileJS = null;
	var $templatePart = null;
	var $contentKey = null;
	var $contentCount = null;
	var $contentClass = array();
	var $contentWrap = array();
	var $jsFiles = array();
	var $js = array();
	var $cssFiles = array();
	var $css = array();
	var $titles = array();
	var $attributes = array();
	var $cElements = array();

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)
	{
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		if ($this->cObj->data['list_type'] == $this->extKey.'_pi1') {
			// It's a content, all data from flexform
			// Set the Flexform information
			$this->pi_initPIflexForm();
			$piFlexForm = $this->cObj->data['pi_flexform'];
			foreach ($piFlexForm['data'] as $sheet => $data) {
				foreach ($data as $lang => $value) {
					foreach ($value as $key => $val) {
						if (! isset($this->lConf[$key])) {
							$this->lConf[$key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
						}
					}
				}
			}
			// define the titles to overwrite
			if (trim($this->lConf['titles'])) {
				$this->titles = t3lib_div::trimExplode(chr(10), $this->lConf['titles']);
			}
			// define the attributes
			if (trim($this->lConf['attributes'])) {
				$this->attributes = t3lib_div::trimExplode(chr(10), $this->lConf['attributes']);
			}
			// get the content ID's
			$content_ids = t3lib_div::trimExplode(",", $this->cObj->data['tx_jfmulticontent_contents']);
			// get the informations for every content
			for ($a=0; $a < count($content_ids); $a++) {
				// Select the content
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tt_content', 'uid='.intval($content_ids[$a]), '', '', 1);
				$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				if ($GLOBALS['TSFE']->sys_language_content) {
					$row = $GLOBALS['TSFE']->sys_page->getRecordOverlay('tt_content', $row, $GLOBALS['TSFE']->sys_language_content, $GLOBALS['TSFE']->sys_language_contentOL);
				}
				if ($this->titles[$a] == '' || !isset($this->titles[$a])) {
					$this->titles[$a] = $row['header'];
				}
				// define content conf
				$cConf = array(
					'tables' => 'tt_content',
					'source' => ($row['_LOCALIZED_UID'] ? $row['_LOCALIZED_UID'] : $row['uid']),
					'dontCheckPid' => 1,
				);
				$this->cElements[] = $this->cObj->RECORDS($cConf);
			}
			// define the key of the element
			$this->contentKey = 'jfmulticontent_c' . $this->cObj->data['uid'];
		} else {
			// TS config will be used
			if (count($this->conf['config.']) > 0) {
				foreach ($this->conf['config.'] as $key => $val) {
					$this->lConf[$key] = trim($val);
				}
				// define the key of the element
				$this->contentKey = $this->lConf['contentKey'];
			} else {
				$this->contentKey = 'jfmulticontent_ts1';
			}
			// Render the contents
			if (count($this->conf['contents.']) > 0) {
				foreach ($this->conf['contents.'] as $key => $contents) {
					$title = trim($this->cObj->cObjGetSingle($contents['title'], $contents['title.']));
					$content = trim($this->cObj->cObjGetSingle($contents['content'], $contents['content.']));
					if ($content) {
						$this->cElements[] = $content;
						$this->titles[] = $title;
					}
				}
			}
		}
		$this->contentCount = count($this->cElements);
		// return false, if there is no element
		if ($this->contentCount == 0) {
			return false;
		}

		// The template
		if (! $this->templateFile = $this->cObj->fileResource($this->conf['templateFile'])) {
			$this->templateFile = $this->cObj->fileResource("EXT:jfmulticontent/pi1/tx_jfmulticontent_pi1.tmpl");
		}
		// The template for JS
		if (! $this->templateFileJS = $this->cObj->fileResource($this->conf['templateFileJS'])) {
			$this->templateFileJS = $this->cObj->fileResource("EXT:jfmulticontent/pi1/tx_jfmulticontent_pi1.js");
		}


		// add the CSS file
		$this->addCssFile($this->conf['cssFile']);

		// define the jQuery mode and function
		if ($this->conf['jQueryNoConflict']) {
			$jQueryNoConflict = "jQuery.noConflict();";
		} else {
			$jQueryNoConflict = "";
		}

		// style
		switch ($this->lConf['style']) {
			case "2column" : {
				$this->templatePart = "TEMPLATE_COLUMNS";
				$this->contentCount = 2;
				$this->contentClass = t3lib_div::trimExplode("|*|", $this->conf['2columnClasses']);
				$this->contentWrap = t3lib_div::trimExplode("|*|", $this->conf['columnWrap.']['wrap']);
				break;
			}
			case "3column" : {
				$this->templatePart = "TEMPLATE_COLUMNS";
				$this->contentCount = 3;
				$this->contentClass = t3lib_div::trimExplode("|*|", $this->conf['3columnClasses']);
				$this->contentWrap = t3lib_div::trimExplode("|*|", $this->conf['columnWrap.']['wrap']);
				break;
			}
			case "4column" : {
				$this->templatePart = "TEMPLATE_COLUMNS";
				$this->contentCount = 4;
				$this->contentClass = t3lib_div::trimExplode("|*|", $this->conf['4columnClasses']);
				$this->contentWrap = t3lib_div::trimExplode("|*|", $this->conf['columnWrap.']['wrap']);
				break;
			}
			case "tab" : {
				// jQuery Tabs
				$this->templatePart = "TEMPLATE_TAB";
				$this->contentWrap = t3lib_div::trimExplode("|*|", $this->conf['tabWrap.']['wrap']);
				// the id attribute is not permitted in tabs-style
				if (count($this->attributes) > 0) {
					foreach ($this->attributes as $key => $attribute) {
						if (preg_match("/id=[\"|\'](.*?)[\"|\']/i", $attribute, $preg)) {
							$this->attributes[$key] = trim(str_replace($preg[0], "", $attribute));
						}
					}
				}
				$this->addJS($jQueryNoConflict);
				$fx = array();
				if ($this->lConf['tabFxHeight']) {
					$fx[] = "height: 'toggle'";
				}
				if ($this->lConf['tabFxOpacity']) {
					$fx[] = "opacity: 'toggle'";
				}
				if ($this->lConf['tabFxDuration'] > 0) {
					$fx[] = "duration: '{$this->lConf['tabFxDuration']}'";
				}
				if ($this->lConf['delayDuration'] > 0) {
					$rotate = ".tabs('rotate' , {$this->lConf['delayDuration']}, ".($this->lConf['autoplayContinuing'] ? 'true' : 'false').")";
				}
				$options = array();
				if (count($fx) > 0) {
					$options[] = "fx:{".implode(",", $fx)."}";
				}
				if ($this->lConf['tabCollapsible']) {
					$options[] = "collapsible:true";
				}
				if ($this->lConf['tabRandomContent']) {
					$options[] = "selected:Math.floor(Math.random()*{$this->contentCount})";
				} elseif (is_numeric($this->lConf['tabOpen'])) {
					$options[] = "selected:".($this->lConf['tabOpen'] - 1);
				}
				// overwrite all options if set
				if (trim($this->lConf['options'])) {
					if ($this->lConf['optionsOverride']) {
						$options = array($this->lConf['options']);
					} else {
						$options[] = $this->lConf['options'];
					}
				}
				// get the Template of the Javascript
				$markerArray = array();
				// get the template
				if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_TAB_JS###"))) {
					$templateCode = "alert('Template TEMPLATE_TAB_JS is missing')";
				}
				// Fix the href problem (config.prefixLocalAnchors = all)
				if ($GLOBALS['TSFE']->config['config']['prefixLocalAnchors']) {
					$fixTabHref = trim($this->cObj->getSubpart($templateCode, "###FIX_HREF###"));
				} else {
					$fixTabHref = null;
				}
				$templateCode = trim($this->cObj->substituteSubpart($templateCode, '###FIX_HREF###', $fixTabHref, 0));
				// Replace default values
				$markerArray["KEY"] = $this->contentKey;
				$markerArray["PREG_QUOTE_KEY"] = preg_quote($this->contentKey, "/");
				$markerArray["OPTIONS"] = implode(", ", $options);
				$markerArray["ROTATE"] = $rotate;
				$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);
				// Add all CSS and JS files
				if (T3JQUERY === true) {
					tx_t3jquery::addJqJS();
				} else {
					$this->addJsFile($this->conf['jQueryLibrary']);
					$this->addJsFile($this->conf['jQueryUI']);
				}
				$this->addCssFile($this->conf['jQueryUIstyle']);
				$this->addJS($templateCode);
				break;
			}
			case "accordion" : {
				// jQuery Accordion
				$this->templatePart = "TEMPLATE_ACCORDION";
				$this->contentWrap = t3lib_div::trimExplode("|*|", $this->conf['accordionWrap.']['wrap']);
				$this->addJS($jQueryNoConflict);
				$options = array();
				if (! $this->lConf['accordionAutoHeight']) {
					$options['autoHeight'] = "autoHeight:false";
				}
				if ($this->lConf['accordionCollapsible']) {
					$options['collapsible'] = "collapsible:true";
				}
				if ($this->lConf['accordionClosed']) {
					$options['active'] = "active:false";
					$options['collapsible'] = "collapsible:true";
				} elseif ($this->lConf['accordionRandomContent']) {
					$options['active'] = "active:Math.floor(Math.random()*{$this->contentCount})";
				} elseif (is_numeric($this->lConf['accordionOpen'])) {
					$options['active'] = "active:".($this->lConf['accordionOpen'] - 1);
				}
				if ($this->lConf['accordionEvent']) {
					$options['event'] = "event:'{$this->lConf['accordionEvent']}'";
				}
				// get the Template of the Javascript
				$markerArray = array();
				$markerArray["KEY"]            = $this->contentKey;
				$markerArray["CONTENT_COUNT"]  = $this->contentCount;
				$markerArray["EASING"]         = (in_array($this->lConf['accordionTransition'], array("swing", "linear")) ? "" : "ease".$this->lConf['accordionTransitiondir'].$this->lConf['accordionTransition']);
				$markerArray["TRANS_DURATION"] = (is_numeric($this->lConf['accordionTransitionduration']) ? $this->lConf['accordionTransitionduration'] : 1000);
				$markerArray["DELAY_DURATION"] = (is_numeric($this->lConf['delayDuration']) ? $this->lConf['delayDuration'] : '0');
				// get the template for the Javascript
				if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_ACCORDION_JS###"))) {
					$templateCode = "alert('Template TEMPLATE_ACCORDION_JS is missing')";
				}
				$easingAnimation = null;
				if ($this->lConf['accordionTransition']) {
					$options['animated'] = "animated:'{$this->contentKey}'";
					$easingAnimation = trim($this->cObj->getSubpart($templateCode, "###EASING_ANIMATION###"));
				} else if ($this->lConf['accordionAnimated']) {
					$options['animated'] = "animated:'{$this->lConf['accordionAnimated']}'";
				}
				// set the easing animation script
				$templateCode = $this->cObj->substituteSubpart($templateCode, '###EASING_ANIMATION###', $easingAnimation, 0);
				$continuing = null;
				$autoPlay = null;
				$settimeout = null;
				if ($this->lConf['delayDuration'] > 0) {
					// does not work if (! $this->lConf['autoplayContinuing']) {}
					$continuing = trim($this->cObj->getSubpart($templateCode, "###CONTINUING###"));
					$autoPlay   = trim($this->cObj->getSubpart($templateCode, "###AUTO_PLAY###"));
					$settimeout = trim($this->cObj->getSubpart($templateCode, "###SETTIMEOUT###"));
					$settimeout = $this->cObj->substituteMarkerArray($settimeout, $markerArray, '###|###', 0);
					$options['change'] = "change:function(event,ui){{$settimeout}}";
				}
				$templateCode = $this->cObj->substituteSubpart($templateCode, '###CONTINUING###', $continuing, 0);
				$templateCode = $this->cObj->substituteSubpart($templateCode, '###AUTO_PLAY###',  $autoPlay, 0);
				$templateCode = $this->cObj->substituteSubpart($templateCode, '###SETTIMEOUT###', $settimeout, 0);
				// overwrite all options if set
				if (trim($this->lConf['options'])) {
					if ($this->lConf['optionsOverride']) {
						$options = array($this->lConf['options']);
					} else {
						$options['flexform'] = $this->lConf['options'];
					}
				}

				// Replace default values
				$markerArray["OPTIONS"] = implode(", ", $options);
				// Replace all markers
				$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);

				// Add all CSS and JS files
				if (T3JQUERY === true) {
					tx_t3jquery::addJqJS();
				} else {
					$this->addJsFile($this->conf['jQueryLibrary']);
					$this->addJsFile($this->conf['jQueryEasing']);
					$this->addJsFile($this->conf['jQueryUI']);
				}
				$this->addCssFile($this->conf['jQueryUIstyle']);
				$this->addJS(trim($templateCode));
				break;
			}
			case "slider" : {
				// anythingslider
				$this->templatePart = "TEMPLATE_SLIDER";
				$this->contentWrap = t3lib_div::trimExplode("|*|", $this->conf['sliderWrap.']['wrap']);
				$this->addJS($jQueryNoConflict);
				// 
				if ($this->lConf['sliderTransition']) {
					$options[] = "easing: '".(in_array($this->lConf['sliderTransition'], array("swing", "linear")) ? "" : "ease{$this->lConf['sliderTransitiondir']}")."{$this->lConf['sliderTransition']}'";
				}
				if ($this->lConf['sliderTransitionduration'] > 0) {
					$options[] = "animationTime: {$this->lConf['sliderTransitionduration']}";
				}
				if ($this->lConf['delayDuration'] > 0) {
					$options[] = "autoPlay: true";
					$options[] = "delay: {$this->lConf['delayDuration']}";
				} else {
					$options[] = "autoPlay: false";
				}
				$options[] = "hashTags: ".($this->lConf['sliderHashTags'] ? 'true' : 'false');
				$options[] = "startStopped: ".($this->lConf['sliderAutoStart'] ? 'false' : 'true');
				$options[] = "pauseOnHover: ".($this->lConf['sliderPauseOnHover'] ? 'true' : 'false');
				$options[] = "buildNavigation: ".($this->lConf['sliderNavigation'] ? 'true' : 'false');
				$options[] = "startText: '".t3lib_div::slashJS($this->pi_getLL('slider_start'))."'";
				$options[] = "stopText: '".t3lib_div::slashJS($this->pi_getLL('slider_stop'))."'";
				// define the paneltext
				if ($this->lConf['sliderPanelFromHeader']) {
					$tab = array();
					for ($a=0; $a < $this->contentCount; $a++) {
						$tab[] = "if(i==".($a+1).") return ".t3lib_div::quoteJSvalue($this->titles[$a]).";";
					}
					$options[] = "navigationFormatter: function(i,p){\n			".implode("\n			", $tab)."\n		}";
				} elseif (trim($this->pi_getLL('slider_panel'))) {
					$options[] = "navigationFormatter: function(i,p){ var str = '".(t3lib_div::slashJS($this->pi_getLL('slider_panel')))."'; return str.replace('%i%',i); }";
				}
				if ($this->lConf['sliderRandomContent']) {
					$options[] = "opened: Math.floor(Math.random()*".($this->contentCount + 1).")";
				} elseif ($this->lConf['sliderOpen'] > 1) {
					$options[] = "opened: ".($this->lConf['sliderOpen'] < $this->contentCount ? $this->lConf['sliderOpen'] : $this->contentCount);
				}
				// overwrite all options if set
				if (trim($this->lConf['options'])) {
					if ($this->lConf['optionsOverride']) {
						$options = array($this->lConf['options']);
					} else {
						$options[] = $this->lConf['options'];
					}
				}
				// get the Template of the Javascript
				$markerArray = array();
				// get the template
				if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_SLIDER_JS###"))) {
					$templateCode = "alert('Template TEMPLATE_SLIDER_JS is missing')";
				}
				// Replace default values
				$markerArray["KEY"] = $this->contentKey;
				$markerArray["OPTIONS"] = implode(", ", $options);
				$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);
				// Fix the href problem (config.prefixLocalAnchors = all)
				if ($GLOBALS['TSFE']->config['config']['prefixLocalAnchors']) {
					$fixTabHref = trim($this->cObj->getSubpart($templateCode, "###FIX_HREF###"));
				} else {
					$fixTabHref = null;
				}
				$templateCode = trim($this->cObj->substituteSubpart($templateCode, '###FIX_HREF###', $fixTabHref, 0));
				// Add all CSS and JS files
				if (T3JQUERY === true) {
					tx_t3jquery::addJqJS();
				} else {
					$this->addJsFile($this->conf['jQueryLibrary']);
					$this->addJsFile($this->conf['jQueryEasing']);
				}
				$this->addJsFile($this->conf['sliderJS']);
				$this->addCssFile($this->conf['sliderCSS']);
				$this->addJS($templateCode);
				break;
			}
			default: {
				return "<p>NO VALID TEMPLATE SELECTED!</p>";
			}
		}

		// Add the ressources
		$this->addResources();

		// Render the Template
		$content = $this->renderTemplate();

		return $this->pi_wrapInBaseClass($content);
	}

	/**
	 * Render the template with the defined contents
	 * 
	 * @return string
	 */
	function renderTemplate()
	{
		$markerArray = array();
		// get the template
		if (! $templateCode = $this->cObj->getSubpart($this->templateFile, "###{$this->templatePart}###")) {
			$templateCode = "<p>Template {$this->templatePart} is missing</p>";
		}
		// Replace default values
		$markerArray["KEY"] = $this->contentKey;
		$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);
		// Get the title template
		$titleCode = $this->cObj->getSubpart($templateCode, "###TITLES###");
		// Get the column template
		$columnCode = $this->cObj->getSubpart($templateCode, "###COLUMNS###");
		// Define the contentWrap
		switch (count($this->contentWrap)) {
			case 1 : {
				$contentWrap_array = array(
					$this->contentWrap[0],
					$this->contentWrap[0],
					$this->contentWrap[0],
				);
				break;
			}
			case 2 : {
				$contentWrap_array = array(
					$this->contentWrap[0],
					$this->contentWrap[0],
					$this->contentWrap[1],
				);
				break;
			}
			case 3 : {
				$contentWrap_array = $this->contentWrap;
				break;
			}
			default: {
				$contentWrap_array = array(
					null,
					null,
					null
				);
				break;
			}
		}
		// fetch all contents
		for ($a=0; $a < $this->contentCount; $a++) {
			$markerArray = array();
			// get the attribute if exist
			$markerArray["ATTRIBUTE"] = "";
			if ($this->attributes[$a] != '') {
				$markerArray["ATTRIBUTE"] .= ' ' . $this->attributes[$a];
			}
			// if the attribute does not have a class entry, the class will be wraped for yaml (c33l, c33l, c33r)
			if ($this->lConf["column".($a+1)] > 0 && isset($this->contentClass[$a]) && ! preg_match("/class\=/i", $markerArray["ATTRIBUTE"])) {
				// wrap the class
				$markerArray["ATTRIBUTE"] .= $this->cObj->stdWrap($this->lConf["column".($a+1)], array("wrap" => ' class="'.$this->contentClass[$a].'"', "required" => 1));
			}
			// render the content
			$markerArray["ID"] = $a+1;
			$markerArray["TITLE"] = null;
			// Title will be selected if not COLUMNS (TAB, ACCORDION and SLIDER)
			if ($this->templatePart != "TEMPLATE_COLUMNS") {
				// overwrite the title if set in $this->titles
				$markerArray["TITLE"] = $this->titles[$a];
			}
			// define the used wrap
			if ($a == 0) {
				$wrap = $contentWrap_array[0];
			} elseif (($a+1) == $this->contentCount) {
				$wrap = $contentWrap_array[2];
			} else {
				$wrap = $contentWrap_array[1];
			}
			// wrap the content
			$markerArray["CONTENT"] = $this->cObj->stdWrap($this->cElements[$a], array('wrap' => $wrap));
			if ($markerArray["CONTENT"]) {
				// add content to COLUMNS
				$columns .= $this->cObj->substituteMarkerArray($columnCode, $markerArray, '###|###', 0);
				// add content to TITLE
				$titles .= $this->cObj->substituteMarkerArray($titleCode, $markerArray, '###|###', 0);
			}
		}

		$return_string = $templateCode;
		$return_string = $this->cObj->substituteSubpart($return_string, '###TITLES###', $titles, 0);
		$return_string = $this->cObj->substituteSubpart($return_string, '###COLUMNS###', $columns, 0);

		if (isset($this->conf['additionalMarkers'])) {
			$additonalMarkerArray = array();
			// get additional markers
			$additionalMarkers = t3lib_div::trimExplode(',', $this->conf['additionalMarkers']);
			// get additional marker configuration
			if(count($additionalMarkers) > 0) {
				foreach($additionalMarkers as $additonalMarker) {
					$additonalMarkerArray[strtoupper($additonalMarker)] = $this->cObj->cObjGetSingle($this->conf['additionalMarkerConf.'][$additonalMarker], $this->conf['additionalMarkerConf.'][$additonalMarker.'.']);
				}
			}
			// add addtional marker content to template
			$return_string = $this->cObj->substituteMarkerArray($return_string, $additonalMarkerArray, '###|###', 0);
		}

		return $return_string;
	}

	/**
	 * Include all defined resources (JS / CSS)
	 *
	 * @return void
	 */
	function addResources()
	{
		// add all defined JS files
		if (count($this->jsFiles) > 0) {
			foreach ($this->jsFiles as $jsToLoad) {
				if (T3JQUERY === true) {
					tx_t3jquery::addJS('', array('jsfile' => $this->getPath($jsToLoad)));
				} else {
					// Add script only once
					if (! preg_match("/".preg_quote($this->getPath($jsToLoad), "/")."/", $GLOBALS['TSFE']->additionalHeaderData['jsFile_'.$this->extKey])) {
						$GLOBALS['TSFE']->additionalHeaderData['jsFile_'.$this->extKey] .= ($this->getPath($jsToLoad) ? '<script src="'.$this->getPath($jsToLoad).'" type="text/javascript"></script>'.chr(10) :'');
					}
				}
			}
		}
		// add all defined JS script
		if (count($this->js) > 0) {
			foreach ($this->js as $jsToPut) {
				$temp_js .= $jsToPut;
			}
			if ($this->conf['jsMinify']) {
				$temp_js = t3lib_div::minifyJavaScript($temp_js);
			}
			$conf = array();
			$conf['jsdata'] = $temp_js;
			if (T3JQUERY === true && t3lib_div::int_from_ver($this->getExtensionVersion('t3jquery')) >= 1002000) {
				if ($this->conf['jsInFooter']) {
					$conf['tofooter'] = true;
					tx_t3jquery::addJS('', $conf);
				} else {
					$conf['tofooter'] = false;
					tx_t3jquery::addJS('', $conf);
				}
			} else {
				if ($this->conf['jsInFooter']) {
					$GLOBALS['TSFE']->additionalFooterData['js_'.$this->extKey] .= t3lib_div::wrapJS($temp_js, true);
				} else {
					$GLOBALS['TSFE']->additionalHeaderData['js_'.$this->extKey] .= t3lib_div::wrapJS($temp_js, true);
				}
			}
		}
		// add all defined CSS files
		if (count($this->cssFiles) > 0) {
			foreach ($this->cssFiles as $cssToLoad) {
				// Add script only once
				if (! preg_match("/".preg_quote($this->getPath($cssToLoad), "/")."/", $GLOBALS['TSFE']->additionalHeaderData['cssFile_'.$this->extKey])) {
					$GLOBALS['TSFE']->additionalHeaderData['cssFile_'.$this->extKey] .= ($this->getPath($cssToLoad) ? '<link rel="stylesheet" href="'.$this->getPath($cssToLoad).'" type="text/css" />'.chr(10) :'');
				}
			}
		}
		// add all defined CSS script
		if (count($this->css) > 0) {
			foreach ($this->css as $cssToPut) {
				$temp_css .= $cssToPut;
			}
			$GLOBALS['TSFE']->additionalHeaderData['css_'.$this->extKey] .= '
<style type="text/css">
' . $temp_css . '
</style>';
		}
	}

	/**
	 * Return the webbased path
	 * 
	 * @param string $path
	 * return string
	 */
	function getPath($path="")
	{
		return $GLOBALS['TSFE']->tmpl->getFileName($path);
	}

	/**
	 * Add additional JS file
	 * 
	 * @param string $script
	 * @param boolean $first
	 * @return void
	 */
	function addJsFile($script="", $first=false)
	{
		if ($this->getPath($script) && ! in_array($script, $this->jsFiles)) {
			if ($first === true) {
				$this->jsFiles = array_merge(array($script), $this->jsFiles);
			} else {
				$this->jsFiles[] = $script;
			}
		}
	}

	/**
	 * Add JS to header
	 * 
	 * @param string $script
	 * @return void
	 */
	function addJS($script="")
	{
		if (! in_array($script, $this->js)) {
			$this->js[] = $script;
		}
	}

	/**
	 * Add additional CSS file
	 * 
	 * @param string $script
	 * @return void
	 */
	function addCssFile($script="")
	{
		if ($this->getPath($script) && ! in_array($script, $this->cssFiles)) {
			$this->cssFiles[] = $script;
		}
	}

	/**
	 * Add CSS to header
	 * 
	 * @param string $script
	 * @return void
	 */
	function addCSS($script="")
	{
		if (! in_array($script, $this->css)) {
			$this->css[] = $script;
		}
	}

	/**
	 * Returns the version of an extension (in 4.4 its possible to this with t3lib_extMgm::getExtensionVersion)
	 * @param string $key
	 * @return string
	 */
	function getExtensionVersion($key)
	{
		if (! t3lib_extMgm::isLoaded($key)) {
			return '';
		}
		$_EXTKEY = $key;
		include(t3lib_extMgm::extPath($key) . 'ext_emconf.php');
		return $EM_CONF[$key]['version'];
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jfmulticontent/pi1/class.tx_jfmulticontent_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jfmulticontent/pi1/class.tx_jfmulticontent_pi1.php']);
}
?>