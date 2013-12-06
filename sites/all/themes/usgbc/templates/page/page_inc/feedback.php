<?php
  global $user;
  $url = $_SERVER['REQUEST_URI'];

$task_endPoints = array(
    '/join-center/member/receipt',
    '/course-registration/receipt',
    '/store/checkout/receipt'
);
$tasks = array(
    '/join-center/member/receipt' => array('task_id'=>1,'title'=>'Join%20USGBC'),
    '/course-registration/receipt' => array('task_id'=>2,'title'=>'Register%20for%20a%20course'),
    '/store/checkout/receipt' => array('task_id'=>3,'title'=>'Buy%20a%20reference%20guide')
);

if(in_array($url,$task_endPoints)):?>
<link rel="stylesheet" type="text/css" media="screen" href="/sites/all/themes/usgbc/lib/css/section/feedback.css" />
<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/section/complete.js"></script>

<div id="feedback-container">
	<div id="feedback-bar" class="feedback">
		<div id="complete" class="sub-form-element">
			<h2>Congratulations!</h2>
			<p>Now that you've worked through this task, please rate your experience.</p>

			<div class="button-group">
				<a href="/private-beta/feedback?task_id=<?php print $tasks[$url]['task_id']; ?>&task=<?php print $tasks[$url]['title']; ?>" class="button">Rate your experience</a>
			</div>
		</div>
	</div>
</div>

<?php else: ?>

<link rel="stylesheet" type="text/css" media="screen" href="/sites/all/themes/usgbc/lib/css/section/feedback.css"/>
<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/section/feedback.js"></script>

<div id="feedback-container">
  <div id="feedback-nav"><a id="feedback-button" href="#">Give
    feedback</a></div>
  <div id="feedback-bar" class="feedback">
    <div class="sub-form-element">
      <h2>How do you feel about this page?</h2>
    <input type="hidden" name="form" value="page_feedback">
      <input type="hidden" name="name" value="<?php print $user->name; ?>">
      <input type="hidden" name="uid" value="<?php print $user->uid; ?>">
      <input type="hidden" name="email" value="<?php print $user->mail; ?>">
      <input type="hidden" name="page_title" value="<?php print $head_title; ?>">
      <input type="hidden" name="url" value="<?php print $url; ?>">

      <div class="row">
        <label>Informative <br/>content</label>
        <input type="radio" name="content-feelings" class="happy" id="content-fdbk-happy" value="happy">

        <input type="radio" name="content-feelings" class="satisfied" id="content-fdbk-satisfied" value="satisfied">

        <input type="radio" name="content-feelings" class="sad" id="content-fdbk-sad" value="sad">
      </div>

      <div class="row">
        <label>Well organized &amp; visually pleasing</label>
        <input type="radio" name="design-feelings" class="happy" id="design-fdbk-happy" value="happy">

        <input type="radio" name="design-feelings" class="satisfied" id="design-fdbk-satisfied" value="satisfied">

        <input type="radio" name="design-feelings" class="sad" id="design-fdbk-sad" value="sad">
      </div>

      <div class="row">
        <label>Performance &amp;&nbsp;speed</label>
        <input type="radio" name="technical-feelings" class="happy" id="technical-fdbk-happy" value="happy">

        <input type="radio" name="technical-feelings" class="satisfied" id="technical-fdbk-satisfied" value="satisfied">

        <input type="radio" name="technical-feelings" class="sad" id="technical-fdbk-sad" value="sad">
      </div>
      <textarea class="field not-elastic" name="comments">Additional comments</textarea>

      <div class="button-group">
        <a href="#" class="button">Submit</a>
        <a href="#" id="close-feedback" class="gray-button">Close</a>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>