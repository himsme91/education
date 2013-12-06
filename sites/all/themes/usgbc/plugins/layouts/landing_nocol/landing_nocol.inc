<?php
// $Id: onecol.inc,v 1.1.2.3 2010/06/22 15:54:24 merlinofchaos Exp $

/**
 * implementation of hook_panels_layouts()
 */
// Plugin definition
$plugin = array(
  'title' => t('Landing Page No column wrapper'),
  'category' => t('USGBC: Landing Pages'),
  'icon' => 'landing_nocol.png',
  'theme' => 'landing_nocol',
  'css' => 'landing_nocol.css',
  'panels' => array('main' => t('Main column')),
);
