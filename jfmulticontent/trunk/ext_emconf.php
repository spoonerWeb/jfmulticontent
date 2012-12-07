<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "jfmulticontent".
 *
 * Auto generated 07-12-2012 20:54
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Multiple Content',
	'description' => 'Arranges multiple contents into one content element with multiple columns, accordions, tabs, slider, slidedeck, easyAccordion or Booklet (Sponsored by http://www.made-in-nature.de/typo3-agentur.html). This extension will also extend tt_news with two new lists. Use t3jquery for better integration with other jQuery extensions.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '2.9.2',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-0.0.0',
			'typo3' => '4.3.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:144:{s:20:"class.ext_update.php";s:4:"07d3";s:27:"class.tx_jfmulticontent.php";s:4:"fb8e";s:21:"ext_conf_template.txt";s:4:"384b";s:12:"ext_icon.gif";s:4:"2231";s:17:"ext_localconf.php";s:4:"d66c";s:14:"ext_tables.php";s:4:"9533";s:14:"ext_tables.sql";s:4:"b1f1";s:15:"flexform_ds.xml";s:4:"1fc7";s:13:"locallang.xml";s:4:"25e0";s:16:"locallang_db.xml";s:4:"fc44";s:54:"selicon_tt_content_tx_jfmulticontent_columnOrder_0.gif";s:4:"e7df";s:54:"selicon_tt_content_tx_jfmulticontent_columnOrder_1.gif";s:4:"69da";s:54:"selicon_tt_content_tx_jfmulticontent_columnOrder_2.gif";s:4:"d72a";s:54:"selicon_tt_content_tx_jfmulticontent_columnOrder_3.gif";s:4:"0ac6";s:54:"selicon_tt_content_tx_jfmulticontent_columnOrder_4.gif";s:4:"089e";s:48:"selicon_tt_content_tx_jfmulticontent_style_0.gif";s:4:"1f44";s:48:"selicon_tt_content_tx_jfmulticontent_style_1.gif";s:4:"7caf";s:49:"selicon_tt_content_tx_jfmulticontent_style_10.png";s:4:"c239";s:48:"selicon_tt_content_tx_jfmulticontent_style_2.gif";s:4:"0e60";s:48:"selicon_tt_content_tx_jfmulticontent_style_3.gif";s:4:"8484";s:48:"selicon_tt_content_tx_jfmulticontent_style_4.gif";s:4:"0f67";s:48:"selicon_tt_content_tx_jfmulticontent_style_5.gif";s:4:"f2cb";s:48:"selicon_tt_content_tx_jfmulticontent_style_6.gif";s:4:"1c40";s:48:"selicon_tt_content_tx_jfmulticontent_style_7.gif";s:4:"cb65";s:48:"selicon_tt_content_tx_jfmulticontent_style_8.gif";s:4:"cd58";s:48:"selicon_tt_content_tx_jfmulticontent_style_9.gif";s:4:"a42b";s:12:"t3jquery.txt";s:4:"d678";s:24:"compat/flashmessages.css";s:4:"4e2c";s:20:"compat/gfx/error.png";s:4:"e4dd";s:26:"compat/gfx/information.png";s:4:"3750";s:21:"compat/gfx/notice.png";s:4:"a882";s:17:"compat/gfx/ok.png";s:4:"8bfe";s:22:"compat/gfx/warning.png";s:4:"c847";s:14:"doc/manual.sxw";s:4:"50fa";s:48:"lib/class.tx_jfmulticontent_browselinkshooks.php";s:4:"5e44";s:42:"lib/class.tx_jfmulticontent_cms_layout.php";s:4:"4a20";s:45:"lib/class.tx_jfmulticontent_itemsProcFunc.php";s:4:"7045";s:44:"lib/class.tx_jfmulticontent_pagerenderer.php";s:4:"9c98";s:39:"lib/class.tx_jfmulticontent_tceFunc.php";s:4:"1443";s:39:"lib/class.tx_jfmulticontent_tcemain.php";s:4:"991d";s:43:"lib/class.tx_jfmulticontent_tsparserext.php";s:4:"4eac";s:45:"lib/class.tx_jfmulticontent_ttnews_extend.php";s:4:"0731";s:14:"pi1/ce_wiz.gif";s:4:"ada0";s:35:"pi1/class.tx_jfmulticontent_pi1.php";s:4:"6918";s:43:"pi1/class.tx_jfmulticontent_pi1_wizicon.php";s:4:"f6d5";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.xml";s:4:"aa68";s:16:"res/tt_news.tmpl";s:4:"c9a1";s:29:"res/tx_jfmulticontent_pi1.css";s:4:"3a8e";s:28:"res/tx_jfmulticontent_pi1.js";s:4:"a9a4";s:30:"res/tx_jfmulticontent_pi1.tmpl";s:4:"fa18";s:30:"res/anythingslider/animate.css";s:4:"3ae8";s:52:"res/anythingslider/jquery.anythingslider-1.8.6.fx.js";s:4:"576f";s:56:"res/anythingslider/jquery.anythingslider-1.8.6.fx.min.js";s:4:"4211";s:49:"res/anythingslider/jquery.anythingslider-1.8.6.js";s:4:"8424";s:53:"res/anythingslider/jquery.anythingslider-1.8.6.min.js";s:4:"53a0";s:55:"res/anythingslider/jquery.anythingslider-1.8.6.video.js";s:4:"344b";s:59:"res/anythingslider/jquery.anythingslider-1.8.6.video.min.js";s:4:"42ea";s:31:"res/anythingslider/style-ie.css";s:4:"8fb9";s:28:"res/anythingslider/style.css";s:4:"183d";s:37:"res/anythingslider/images/default.png";s:4:"c2b6";s:48:"res/anythingslider/themes/construction/style.css";s:4:"0b4d";s:62:"res/anythingslider/themes/construction/images/construction.gif";s:4:"d845";s:48:"res/anythingslider/themes/cs-portfolio/style.css";s:4:"c493";s:62:"res/anythingslider/themes/cs-portfolio/images/cs-portfolio.png";s:4:"8680";s:44:"res/anythingslider/themes/metallic/style.css";s:4:"2d9f";s:61:"res/anythingslider/themes/metallic/images/arrows-metallic.png";s:4:"9f9e";s:52:"res/anythingslider/themes/minimalist-round/style.css";s:4:"af42";s:71:"res/anythingslider/themes/minimalist-round/images/arrows-minimalist.png";s:4:"1f16";s:53:"res/anythingslider/themes/minimalist-square/style.css";s:4:"0779";s:72:"res/anythingslider/themes/minimalist-square/images/arrows-minimalist.png";s:4:"1f16";s:36:"res/booklet/jquery.booklet-1.4.0.css";s:4:"439b";s:36:"res/booklet/jquery.booklet-1.4.0a.js";s:4:"485b";s:40:"res/booklet/jquery.booklet-1.4.0a.min.js";s:4:"4fdf";s:33:"res/booklet/images/arrow-next.png";s:4:"902b";s:33:"res/booklet/images/arrow-prev.png";s:4:"9a1d";s:33:"res/booklet/images/closedhand.cur";s:4:"a8c8";s:31:"res/booklet/images/openhand.cur";s:4:"b06c";s:38:"res/booklet/images/shadow-top-back.png";s:4:"e990";s:41:"res/booklet/images/shadow-top-forward.png";s:4:"f7db";s:29:"res/booklet/images/shadow.png";s:4:"5a40";s:45:"res/easyaccordion/jquery.easyAccordion-0.2.js";s:4:"2ece";s:27:"res/easyaccordion/style.css";s:4:"307a";s:38:"res/easyaccordion/skins/blue/style.css";s:4:"b49a";s:58:"res/easyaccordion/skins/blue/images/slide-title-active.jpg";s:4:"151d";s:60:"res/easyaccordion/skins/blue/images/slide-title-inactive.jpg";s:4:"f1bf";s:45:"res/easyaccordion/skins/blue/images/slide.jpg";s:4:"fd96";s:40:"res/easyaccordion/skins/orange/style.css";s:4:"8f75";s:60:"res/easyaccordion/skins/orange/images/slide-title-active.jpg";s:4:"39de";s:62:"res/easyaccordion/skins/orange/images/slide-title-inactive.jpg";s:4:"ff42";s:47:"res/easyaccordion/skins/orange/images/slide.jpg";s:4:"fd96";s:53:"res/jquery/css/theme-1.9.2/jquery-ui-1.9.2.custom.css";s:4:"15a4";s:57:"res/jquery/css/theme-1.9.2/jquery-ui-1.9.2.custom.min.css";s:4:"1115";s:75:"res/jquery/css/theme-1.9.2/images/ui-bg_diagonals-thick_18_b81900_40x40.png";s:4:"95f9";s:75:"res/jquery/css/theme-1.9.2/images/ui-bg_diagonals-thick_20_666666_40x40.png";s:4:"f040";s:65:"res/jquery/css/theme-1.9.2/images/ui-bg_flat_10_000000_40x100.png";s:4:"c18c";s:66:"res/jquery/css/theme-1.9.2/images/ui-bg_glass_100_f6f6f6_1x400.png";s:4:"5f18";s:66:"res/jquery/css/theme-1.9.2/images/ui-bg_glass_100_fdf5ce_1x400.png";s:4:"d26e";s:65:"res/jquery/css/theme-1.9.2/images/ui-bg_glass_65_ffffff_1x400.png";s:4:"e5a8";s:72:"res/jquery/css/theme-1.9.2/images/ui-bg_gloss-wave_35_f6a828_500x100.png";s:4:"58d2";s:75:"res/jquery/css/theme-1.9.2/images/ui-bg_highlight-soft_100_eeeeee_1x100.png";s:4:"384c";s:74:"res/jquery/css/theme-1.9.2/images/ui-bg_highlight-soft_75_ffe45c_1x100.png";s:4:"b806";s:61:"res/jquery/css/theme-1.9.2/images/ui-icons_222222_256x240.png";s:4:"ebe6";s:61:"res/jquery/css/theme-1.9.2/images/ui-icons_228ef1_256x240.png";s:4:"79f4";s:61:"res/jquery/css/theme-1.9.2/images/ui-icons_ef8c08_256x240.png";s:4:"ef9a";s:61:"res/jquery/css/theme-1.9.2/images/ui-icons_ffd27a_256x240.png";s:4:"ab8c";s:61:"res/jquery/css/theme-1.9.2/images/ui-icons_ffffff_256x240.png";s:4:"342b";s:33:"res/jquery/js/jquery-1.8.3.min.js";s:4:"e128";s:43:"res/jquery/js/jquery-ui-1.9.2.custom.min.js";s:4:"f9ed";s:30:"res/jquery/js/jquery.cookie.js";s:4:"634e";s:34:"res/jquery/js/jquery.easing-1.3.js";s:4:"6516";s:44:"res/jquery/js/jquery.mousewheel-3.0.6.min.js";s:4:"25db";s:39:"res/slidedeck/jquery.slidedeck-1.3.2.js";s:4:"e254";s:43:"res/slidedeck/jquery.slidedeck-1.3.2.min.js";s:4:"8d25";s:36:"res/slidedeck/skins/default/back.png";s:4:"f3cf";s:38:"res/slidedeck/skins/default/corner.png";s:4:"cb3b";s:39:"res/slidedeck/skins/default/skin-ie.css";s:4:"9624";s:36:"res/slidedeck/skins/default/skin.css";s:4:"f7fc";s:38:"res/slidedeck/skins/default/slides.png";s:4:"55b1";s:38:"res/slidedeck/skins/default/spines.png";s:4:"9406";s:43:"res/slidedeck/skins/invasion/background.jpg";s:4:"306b";s:37:"res/slidedeck/skins/invasion/skin.css";s:4:"a2a0";s:39:"res/slidedeck/skins/invasion/slides.png";s:4:"9c80";s:39:"res/slidedeck/skins/invasion/spines.jpg";s:4:"2acb";s:46:"res/slidedeck/skins/literally/index_sprite.png";s:4:"de4e";s:38:"res/slidedeck/skins/literally/skin.css";s:4:"d484";s:42:"res/slidedeck/skins/literally/skin.ie7.css";s:4:"795b";s:42:"res/slidedeck/skins/literally/skin.ie8.css";s:4:"410f";s:39:"res/slidedeck/skins/literally/slide.png";s:4:"9dac";s:40:"res/slidedeck/skins/literally/spines.png";s:4:"cbea";s:36:"res/slidedeck/skins/ribbons/skin.css";s:4:"554c";s:39:"res/slidedeck/skins/ribbons/skin.ie.css";s:4:"c100";s:38:"res/slidedeck/skins/ribbons/slides.png";s:4:"7748";s:38:"res/slidedeck/skins/ribbons/spines.png";s:4:"c71d";s:38:"res/slidedeck/skins/stitch/corners.png";s:4:"0fc6";s:35:"res/slidedeck/skins/stitch/skin.css";s:4:"fbdc";s:36:"res/slidedeck/skins/stitch/slide.png";s:4:"c162";s:37:"res/slidedeck/skins/stitch/spines.jpg";s:4:"896c";s:38:"res/slidedeck/skins/voyager/corner.png";s:4:"4f53";s:36:"res/slidedeck/skins/voyager/skin.css";s:4:"94b8";s:38:"res/slidedeck/skins/voyager/slides.png";s:4:"9195";s:38:"res/slidedeck/skins/voyager/spines.png";s:4:"0e1d";s:20:"static/constants.txt";s:4:"f28e";s:16:"static/setup.txt";s:4:"7a91";}',
	'suggests' => array(
	),
);

?>