<?php
// $Id: twocol.inc,v 1.1.2.3 2010/06/22 15:54:25 merlinofchaos Exp $

// Plugin definition
$plugin = array(
  'title' => t('Two column w/ Highlighted'),
  'category' => t('USGBC: Content Pages'),
  'icon' => 'page_twocol_highlighted.png',
  'theme' => 'page_twocol-highlighted',
  'css' => 'page_twocol_highlighted.css',
  'panels' => array(
    'highlighted' => t('Highlighted'),
    'main' => t('Main Column'),
    'side' => t('Side Column')
  ),
);
