<?php
  // $Id: template.theme.php 64932 2013-10-20 19:01:40Z himanshu $
  /**
   * @file
   * theme usgbc overwrites
   * - Code for each content type form -- Ankit Patel and Jay Mehta
   */


  function usgbc_theme () {

    return array(

    	'diff_node_revisions'            => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/revisions',
        'template'       => 'usgbc-revisions',
        'render element' => NULL,
      ),
     'user_registration_user_form'            => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/user',
        'template'       => 'user-register',
        'render element' => NULL,
      ),
     'user_registration_existing_member_form' => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/user',
        'template'       => 'contact-form-noadmin',
        'render element' => NULL,
      ),
      'user_login'                             => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/user',
        'template'       => 'user-login',
        'render element' => NULL,
      ),
      'user_pass'                              => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/user',
        'template'       => 'user-password',
        'render element' => NULL,
      ),
       'usgbc_user_registration_form_user_pass_reset'                              => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/user',
        'template'       => 'user-password-reset',
        'render element' => NULL,
      ),
      'search_form'                            => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/search',
        'template'       => 'search-form',
        'render element' => NULL,
      ),
      'print_mail_form'                        => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/misc',
        'template'       => 'print-mail-form',
        'render element' => NULL,
      ),
      'send_to_friend_form'                        => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/sendtofriend',
        'template'       => 'send-to-friend-form',
        'render element' => NULL,
      ),
      'ask_a_question_form'                        => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/help',
        'template'       => 'ask-question',
        'render element' => NULL,
      ),
      'myaccount_home_form'                    => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'myaccount-home-form', // this is the name of the template
      ),
      'account_settings_form'                  => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'account-settings-form', // this is the name of the template
      ),
      'membership_account_form'                => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'membership-account-form', // this is the name of the template
      ),
      'billing_account_form'                => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'billing-account-form', // this is the name of the template
      ),
      'tax_exempt_form'                        => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'tax-exempt-form', // this is the name of the template
      ),
      'personal_profile_form'                  => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'personal-profile-form', // this is the name of the template
      ),
      'organization_profile_form'              => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'organization-profile-form', // this is the name of the template
      ),
      'chapter_profile_form'                   => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'chapter-profile-form', // this is the name of the template
      ),
      'online_access_form'                     => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'online-access-form', // this is the name of the template
      ),
      'subscriptions_form'                     => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'subscriptions-form', // this is the name of the template
      ),
      'election_account_form'                     => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'election-account-form', // this is the name of the template
      ),
       'credits_form'                     => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'credits-form', // this is the name of the template
      ),
      'order_history_form'                     => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'order-history-form', // this is the name of the template
      ),
      'order_details_form'                     => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'order-details-form', // this is the name of the template
      ),
      'contribution_article_form'              => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'       => 'contribution-article-form',
        'render element' => NULL,
      ),
      'contribution_project_form'              => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'       => 'contribution-project-form',
        'render element' => NULL,
      ),
      'contribution_resource_form'             => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'       => 'contribution-resource-form',
        'render element' => NULL,
      ),
      'comment_form'                           => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/comment',
        'template'       => 'comment-form',
        'render element' => NULL,
      ),
      'confirm_form'                           => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/misc',
        'template'       => 'confirm-form',
        'render element' => NULL,
      ),

      'usgbc_store_cart_form'                  => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/store',
        'template'       => 'usgbc-store-cart-form',
        'render element' => NULL,
      ),
      'user_login_block'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/user',
        'template'       => 'user-login-block-form',
        'render element' => NULL,
      ),
 		'ask-question'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/help',
        'template'       => 'ask-question',
        'render element' => NULL,
      ),
       	'merge_accounts_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/accountmerge',
        'template'       => 'merge-accounts-form',
        'render element' => NULL,
      ),
      	'chapter_map_leave_usgbc_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/chaptermap',
        'template'       => 'leave-usgbc',
        'render element' => NULL,
      ),  
       	'credit_watch_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/credits',
        'template'       => 'credit-watch',
        'render element' => NULL,
      ),
       	'usgbc_ce_migration_pkg_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/cemigrationpkg',
        'template'       => 'user-signup',
        'render element' => NULL,
      ),
      'usgbc_ce_migration_pkg_conf_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/cemigrationpkg',
        'template'       => 'user-confirmation',
        'render element' => NULL,
      ),
       'pilot_credit_registration_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/pilotcredit',
        'template'       => 'pilot-credit-registration',
        'render element' => NULL,
      ),
       'leed_v4_ballot_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/pilotcredit',
        'template'       => 'leed-v4-ballot',
        'render element' => NULL,
      ),
    	'leed_v4_ballotv4_form'                       => array(
    	 'arguments'      => array('form' => NULL),
    	 'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/pilotcredit',
    	 'template'       => 'leed-v4-ballotv4',
    	 'render element' => NULL,
     ),
       'leed_automation_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/pilotcredit',
        'template'       => 'leed-automation',
        'render element' => NULL,
      ),
       'usgbc_providers_roster_upload_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/providerrosterupload',
        'template'       => 'roster-upload',
        'render element' => NULL,
      ),
       	'usgbc_providers_roster_upload_confirmation_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/providerrosterupload',
        'template'       => 'upload-confirmation',
        'render element' => NULL,
      ),
       	'mailchimp_subscribe_auth_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'       => 'user-subscriptions-form',
        'render element' => NULL,
      ),
      	'autoarterms_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'       => 'autoar-terms',
        'render element' => NULL,
      ),
      'usgbc_project_download_form'                       => array(
        'arguments'      => array('form' => NULL),
        'path'           => drupal_get_path ('theme', 'usgbc') . '/templates/projects',
        'template'       => 'user-search',
        'render element' => NULL,
      ),
    	'credentials_form' =>array(
    	'arguments' 	=> array('form' =>NULL),
    	'path'			=> drupal_get_path('theme', 'usgbc') . '/templates/myaccount',
    	'template'		=> 'credentials-form',
    	'render element'=> NULL,		
      ),
    	'exam_history_form' =>array(
    		'arguments'	=> array('form' =>NULL),
    		'path' 		=> drupal_get_path('theme', 'usgbc') . '/templates/myaccount',
    		'template'  => 'exam-history-form',
    		'render element' => NULL,
    	),
    	'ce_activity_history_form' =>array(
    			'arguments'	=> array('form' =>NULL),
    			'path' 		=> drupal_get_path('theme', 'usgbc') . '/templates/myaccount',
   				'template'  => 'ce-activity-history-form',
   				'render element' => NULL,
   		),
   		'friendship_account_form'                => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'friendship-account-form', // this is the name of the template
      ),
       'edit_profile_form'                  => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'edit-personal-profile-form', // this is the name of the template
      ),
      'subsidiary_profile_form'                  => array(
        'arguments' => array('form' => NULL),
        'path'      => drupal_get_path ('theme', 'usgbc') . '/templates/myaccount',
        'template'  => 'subsidiary-profile-form', // this is the name of the template
      ),
    );
  }
