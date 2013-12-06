<?php
// $Id: onecol.inc,v 1.1.2.3 2010/06/22 15:54:24 merlinofchaos Exp $

/**
 * implementation of hook_panels_layouts()
 */
// Plugin definition
$plugin = array(
  'title' => t('Single column'),
  'category' => t('USGBC: Content Pages'),
  'icon' => 'page_onecol.png',
  'theme' => 'page_onecol',
  'css' => 'page_onecol.css',
  'panels' => array('main' => t('Main column')),
);
