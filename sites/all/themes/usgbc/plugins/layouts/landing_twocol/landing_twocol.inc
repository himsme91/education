<?php
// $Id: landing_twocol.inc,v 1.1 $

// Plugin definition
$plugin = array(
  'title' => t('Landing Page Two column'),
  'category' => t('USGBC: Landing Pages'),
  'icon' => 'landing_twocol.png',
  'theme' => 'landing-twocol',
  'css' => 'landing_.css',
  'panels' => array(
    'left' => t('Left side'),
    'right' => t('Right side')
  ),
);
