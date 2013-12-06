<?php
//The view for Popular course workshops on courses landing page

$view = views_get_view ('vws_crs_detail');
$view->set_arguments (array($fields['nid']->raw));
$view->set_display ('page_6');
$view->execute ();
$workshop_nid = $view->result[0]->nid;
$node = node_load($fields['nid']->raw);
$course_path = $fields['path']->content . '?workshop_nid=' . $workshop_nid;
$feature_img_src = '/' . $fields['field_art_feature_image_fid']->content;
$ce_hours = $fields['field_crs_leed_ap_hours_value']->content; 
$fivestar_widget = $fields['value']->content;
$title = $fields['title']->content;


?>
				<div class="inner">
					<a href="<?php echo $course_path; ?>">
						<img alt="" src="<?php echo $feature_img_src ;?>">
					</a>
				</div>
				<div class="inner-overlay block-link" style="dislay:block;">
					<a class="grid-title tooltip_link" href="<?php echo $course_path; ?>">
						<h4 class="title">
							<?php echo $title; ?>
						</h4>
					</a>
					<div class="left five-star">
						<?php echo $fivestar_widget; ?>
					</div>
					<div class="leed-badge">
						<?php
						//for leed badges
						//echo $fields['field_crs_leed_value']->content;
			
						$course_pills = array();
						$leed_cert_array = $node->field_crs_leed;
						$temp_size = sizeof($leed_cert_array);
			
						for($i = 0; $i < $temp_size; $i++){
							$value = $leed_cert_array[$i]['value'];
							if($value != null){
								$current_term = taxonomy_get_term($value);
								switch($current_term->name){
									case 'LEED AP BD+C':
										$course_pills[] = '<span class="leed-certificate-bdc pill">BD+C</span>'; break;
									case 'LEED AP Homes':
										$course_pills[] = '<span class="leed-certificate-homes pill">Homes</span>'; break;
									case 'LEED AP ID+C':
										$course_pills[] = '<span class="leed-certificate-idc pill">ID+C</span>'; break;
									case 'LEED AP ND':
										$course_pills[] = '<span class="leed-certificate-nd pill">ND</span>'; break;
									case 'LEED AP O+M':
										$course_pills[] = '<span class="leed-certificate-om pill">O+M</span>'; break;
								}
							}
						}?>
						<?php foreach($course_pills as $pill_html){
							echo $pill_html;
						}?>
					</div>
					<?php if( $ce_hours > 0){
								echo '<div class="meta-item CE">';
								echo 'CE hours <strong>' . $ce_hours.'</strong>';
								echo '</div>';
					}?>
					<div class="id">
						<span class="meta-item id">ID <strong> <?php echo $fields['field_crs_id_value']->content; ?> </strong> 
						</span>
					</div>
					
					<div class="level">
						<span class="meta-item level">Level <strong> <?php echo $fields['field_crs_level_value']->content; ?></strong>
						</span>
					</div>
					<div class=summary>
						<?php
						if(isset($fields['field_all_description_full_value']->content) && $fields['field_all_description_full_value']->content !=""){
							$length = 150;
							$text = trim( strip_tags($fields['field_all_description_full_value']->content ) );
			
							if ( strlen( $text ) > $length ) {
								$text = substr( $text, 0, $length + 1 );
								$words = preg_split( "/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY );
								preg_match( "/[\s]|&nbsp;/", $text, $lastchar, 0, $length );
								if ( empty( $lastchar ) )
								array_pop( $words );
								$text = implode( ' ', $words );
							}
							?>
							<p>
							<?php echo $text."...";?>
								<a href="<?php echo $course_path; ?>">more info</a>
							</p>
							<?php } ?>
					</div>
					<div class="provider">
						<?php
						if(isset($fields['field_crs_pvd_nid']->content) && $fields['field_crs_pvd_nid']->content!= ""){
							?>
							<h2>Provided by:</h2>
							<?php
							// for course provider
							echo " ".$fields['field_crs_pvd_nid']->content;
						} ?>
					</div>
			</div>
