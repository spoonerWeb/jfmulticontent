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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class implements a all needed functions to add Javascripts and Stylesheets to a page
 *
 * @author     Juergen Furrer <juergen.furrer@gmail.com>
 * @package    TYPO3
 * @subpackage tx_jfmulticontent
 */
class tx_jfmulticontent_pagerenderer
{
    public $conf = [];
    public $extKey = 'jfmulticontent';
    private $jsFiles = [];
    private $js = [];
    private $cssFiles = [];
    private $cssFilesInc = [];
    private $css = [];

    /**
     * Set the configuration for the pagerenderer
     *
     * @param array $conf
     */
    public function setConf($conf)
    {
        $this->conf = $conf;
    }

    /**
     * Include all defined resources (JS / CSS)
     *
     * @return void
     */
    public function addResources()
    {
        $pagerender = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        // Fix moveJsFromHeaderToFooter (add all scripts to the footer)
        if ($GLOBALS['TSFE']->config['config']['moveJsFromHeaderToFooter']) {
            $allJsInFooter = true;
        } else {
            $allJsInFooter = false;
        }
        // add all defined JS files
        if (count($this->jsFiles) > 0) {
            foreach ($this->jsFiles as $jsToLoad) {
                $file = $this->getPath($jsToLoad);
                if ($file) {
                    if ($this->conf['jsInFooter'] || $allJsInFooter) {
                        $pagerender->addJsFooterFile($file, 'text/javascript', $this->conf['jsMinify']);
                    } else {
                        $pagerender->addJsFile($file, 'text/javascript', $this->conf['jsMinify']);
                    }
                } else {
                    GeneralUtility::devLog("'{$jsToLoad}' does not exists!", $this->extKey, 2);
                }
            }
        }
        // add all defined JS script
        $temp_js = '';
        if (count($this->js) > 0) {
            foreach ($this->js as $jsToPut) {
                $temp_js .= $jsToPut;
            }
            $conf = [];
            $conf['jsdata'] = $temp_js;
            // Add script only once
            $hash = md5($temp_js);
            if ($this->conf['jsInline']) {
                $GLOBALS['TSFE']->inlineJS[$hash] = $temp_js;
            } else {
                if ($this->conf['jsInFooter'] || $allJsInFooter) {
                    $pagerender->addJsFooterInlineCode($hash, $temp_js, $this->conf['jsMinify']);
                } else {
                    $pagerender->addJsInlineCode($hash, $temp_js, $this->conf['jsMinify']);
                }
            }
        }
        // add all defined CSS files
        if (count($this->cssFiles) > 0) {
            foreach ($this->cssFiles as $cssToLoad) {
                // Add script only once
                $file = $this->getPath($cssToLoad);
                if ($file) {
                    $pagerender->addCssFile($file, 'stylesheet', 'all', '', $this->conf['cssMinify']);
                } else {
                    GeneralUtility::devLog("'{$cssToLoad}' does not exists!", $this->extKey, 2);
                }
            }
        }
        // add all defined CSS files for IE
        if (count($this->cssFilesInc) > 0) {
            foreach ($this->cssFilesInc as $cssToLoad) {
                // Add script only once
                $file = $this->getPath($cssToLoad['file']);
                if ($file) {
                    // Theres no possibility to add conditions for IE by pagerenderer, so this will be added in additionalHeaderData
                    $GLOBALS['TSFE']->additionalHeaderData['cssFile_' . $this->extKey . '_' . $file] = '<!--[if ' . $cssToLoad['rule'] . ']><link rel="stylesheet" type="text/css" href="' . $file . '" media="all" /><![endif]-->' . chr(
                            10
                        );
                } else {
                    GeneralUtility::devLog("'{$cssToLoad['file']}' does not exists!", $this->extKey, 2);
                }
            }
        }
        // add all defined CSS Script
        $temp_css = '';
        if (count($this->css) > 0) {
            foreach ($this->css as $cssToPut) {
                $temp_css .= $cssToPut;
            }
            $hash = md5($temp_css);
            $pagerender->addCssInlineBlock($hash, $temp_css, $this->conf['cssMinify']);
        }
    }

    /**
     * Return the webbased path
     *
     * @param string $path
     * @return null|string
     */
    public function getPath($path = '')
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
    public function addJsFile($script = '', $first = false)
    {
        if ($this->getPath($script) && !in_array($script, $this->jsFiles)) {
            if ($first === true) {
                $this->jsFiles = array_merge([$script], $this->jsFiles);
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
    public function addJS($script = '')
    {
        if (!in_array($script, $this->js)) {
            $this->js[] = $script;
        }
    }

    /**
     * Add additional CSS file
     *
     * @param string $script
     * @return void
     */
    public function addCssFile($script = '')
    {
        if ($this->getPath($script) && !in_array($script, $this->cssFiles)) {
            $this->cssFiles[] = $script;
        }
    }

    /**
     * Add additional CSS file to include into IE only
     *
     * @param string $script
     * @param string $include for example use "lte IE 7"
     * @return void
     */
    public function addCssFileInc($script = '', $include = 'IE')
    {
        if ($this->getPath($script) && !in_array($script, $this->cssFiles) && $include) {
            $this->cssFilesInc[] = [
                'file' => $script,
                'rule' => $include,
            ];
        }
    }

    /**
     * Add CSS to header
     *
     * @param string $script
     * @return void
     */
    public function addCSS($script = '')
    {
        if (!in_array($script, $this->css)) {
            $this->css[] = $script;
        }
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/jfmulticontent/lib/class.tx_jfmulticontent_pagerenderer.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/jfmulticontent/lib/class.tx_jfmulticontent_pagerenderer.php']);
}
