<?php
// $Id: onecol.inc,v 1.1.2.3 2010/06/22 15:54:24 merlinofchaos Exp $

/**
 * implementation of hook_panels_layouts()
 */
// Plugin definition
$plugin = array(
  'title' => t('Landing Page Single column'),
  'category' => t('USGBC: Landing Pages'),
  'icon' => 'landing_onecol.png',
  'theme' => 'landing_onecol',
  'css' => 'landing_onecol.css',
  'panels' => array('main' => t('Main column')),
);
