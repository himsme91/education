<?php
// $Id: twocol.inc,v 1.1.2.3 2012-12-03 jmehta $

// Plugin definition
$plugin = array(
  'title' => t('Two column w/ left main'),
  'category' => t('USGBC: Content Pages'),
  'icon' => 'page_twocol-leftmain.png',
  'theme' => 'page_twocol-leftmain',
  'css' => 'page_twocol_leftmain.css',
  'panels' => array(
    'main' => t('Main Column'),
    'side' => t('Side Column')
  ),
);
