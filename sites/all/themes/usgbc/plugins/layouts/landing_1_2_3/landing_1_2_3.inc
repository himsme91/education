<?php
// $Id: twocol.inc,v 1.1.2.3 2010/06/22 15:54:25 merlinofchaos Exp $

// Plugin definition
$plugin = array(
  'title' => t('Landing Page 1-2-3'),
  'category' => t('USGBC: Landing Pages'),
  'icon' => 'landing_1_2_3.png',
  'theme' => 'landing-1-2-3',
  'css' => 'landing_1_2_3.css',
  'panels' => array(
    'highlighted' => t('Highlighted Block'),
    '2-right' => t('2 Column Right side'),
    '2-left' => t('2 Column Left side'),
    '3-right' => t('3 Column Right side'),
    '3-middle' => t('3 Column Middle'),
    '3-left' => t('3 Column Left side'),
    'bottom' => t('1 Column Bottom')
  ),
);
