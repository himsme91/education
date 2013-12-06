<?php

/**
 * @file advpoll-display-binary-form.tpl.php
 * Default theme implementation to show voting form for binary polls.
 *
 * $writein_choice - writein_choice element, if poll needs it.
 * $form_id
 * $form_submit
 * $choice_list - choices in the poll.
 * $footer_message - an optional message that can display below the poll.
 */
	$electionnid = db_result(db_query("select e.nid from drupal.content_type_election e left join drupal.node n on n.nid = e.nid where e.field_election_open_value = 1  and n.status = 1 and date(e.field_voting_startdate_value) <= CURDATE() and date(e.field_voting_enddate_value) >= CURDATE();"));
	$electionnode = node_load($electionnid);
	$officescnt = count($electionnode->field_election_offices);
	$renderelements = false;
	
?>
<style>
	.separator{
	border-bottom: 1px solid #ddd;
	padding: 0 0 4px;
	margin-bottom: 8px;
	}
</style>
<div class="form form-form clear-block <?php print $form_classes ?>"	id="divElections">
<h1>Election ballots</h1>
<div class="panels enabled show_single">
	<?php if($electionnid > 0 && election_eligible($electionnode)){
			if(!election_voted($electionnode)){
				$renderelements = true;
		?>
	<div id="election" class="panel show_link">
			<div class="panel_label">
				<h4 class="left"><?php print $electionnode->title;?> </h4> &nbsp;<em> ( Closing <?php print date("M j, Y", strtotime($electionnode->field_voting_enddate[0]['value']));?> )</em>

				<div class="label_link right">
					<a class="show_link" href="">details</a> <a class="hide_link"
						href="">hide</a>
				</div>
			</div>
		<div class="panel_summary settings_val displayed"> 
		 <p class=""><em> Cast your ballot</em></p>
		</div><?php }else {	?><div id="election" class="panel">
			<div class="panel_label">
				<h4 class="left"><em>Thank you for casting your vote! Every vote counts and impacts the leadership of USGBC and our green building movement. To contact the Board of Directors at any time, please email <a href='mailto:board@usgbc.org' target='_new'>board@usgbc.org</a>. Stay tuned to USGBC.org for the results! </em></h4>
			</div> <?php }?>
	<?php }elseif(!$electionnid) {?>
	<div id="election" class="panel">
			<div class="panel_label">
				<h4 class="left"><em>The Board election closed at 5pm EDT on Oct. 30. Results coming soon.</em></h4>
			</div>
	<?php }elseif(!election_eligible($electionnode)){?>
	<div id="election" class="panel">
			<div class="panel_label">
				<h4 class="left"><em>You are not eligible to vote</em></h4>
			</div>
	<?php }?>

		<?php if($renderelements){?>
    	<div class="panel_content hidden">
		    	<?php for ($i=1; $i<=$officescnt; $i++){
		    		$officenode =node_load($electionnode->field_election_offices[$i-1][nid]);
		    		$voted = _advpoll_user_voted($officenode->nid);		
		    		?>
		    		<h4 class="left"><?php print $officenode->title;?></h4>
		
		    		<?php if(!$voted[0]) :?>
		    		<div class="vote-choices" id="vote-choice<?php print $i?>">
				      <?php print  drupal_render($form['choice'.$i]) ?>
				    </div>
				    <?php if (isset($form['writein_choice'.$i])): ?>
				    <div class="writein-choice<?php print $i?>" style="display:none;"><?php print drupal_render($form['writein_choice'.$i]) ?></div>
				    <?php endif; ?>
				  <?php endif;?>
			
				  <?php if ($form['message'.$i]): ?><br/><br/><p class="message"><em><?php print drupal_render($form['message'.$i]) ?></em></p><?php endif; ?>
				  
				  <?php if ($form['#node']->footer_message): ?>
				  <p class="footer-message"><?php print $form['#node']->footer_message; ?></p>
		
				  <?php endif; ?>
				  <br/><p class="separator">&nbsp;</p>
		    	<?php }
				  ?>		
				  	 <p style="float:right">  <?php print  drupal_render($form['vote']) ?></p> 
			</div>	  
			<?php }?>
    	</div>
</div>
</div>
<div class="panels enabled ">
   <div id="show_elections" class="panel show_link">
				
				    <div class="panel_label">
				        <h4 class="left">About the Board of Directors Election</h4>
				        <div class="label_link right">
				            <a class="show_link" href="">show</a>
				            <a class="hide_link" href="">hide</a>
				        </div>
				    </div>
				

				    <div class="panel_content hidden">

				     <p style="margin-top:25px;">Oct 1 - Oct 30, 2013</p>
				
				     <p><strong>What does a director do?</strong></p>
					      <p>Directors uphold the vision, values and mission of USGBC. They make key decisions about how USGBC serves our membership, educates the industry and advances our mission. Elected directors serve three-year terms (with the exception of the Insurance seat in 2014) and may serve up to two terms. Officers are elected by members of the Board. <br />
					        <a href="http://www.usgbc.org/sites/default/files/USGBC-Board-Roles-Responsibilities.pdf" class="more-link">USGBC Board of Directors Roles and Responsibilities</a> <br />
					        <a href="http://www.usgbc.org/sites/default/files/USGBC_Board_of_Directors_Code_of_Conduct.pdf" class="more-link">USGBC Board of Director Code of Conduct </a><br />
					        <a href="http://www.usgbc.org/resources/list/minutes?keys=board+minutes" class="more-link">Recent Board Meeting Minutes</a></p>
						
					<p><strong>Who are the candidates?</strong> </p>
					<p>For the 2014 USGBC Board of Directors, there are 17 highly qualified candidates for six open elected seats:</p>
						<ul>
						<li>Sustainable Practice Leader: Architecture and Design (4 candidates)</li>
						  <li>Constructor of Buildings (3 candidates)</li>
						  <li>Residential Construction (3 candidates)</li>
						  <li>International (3 candidates)</li>
						  <li>State and Local Government Agency Employee (3 candidates)</li>
						<li>Insurance (1 candidate)</li></ul>
				    </div>
				</div>
</div>
<div  id="norender" class="hidden">
<?php print drupal_render($form);?>
</div>
