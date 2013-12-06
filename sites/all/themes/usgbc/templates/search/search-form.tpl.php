<?php	
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//print_r($form['form_array']);
?>

<script type="text/javascript">
$(document).ready(function(){

	$("a.facet-link").mouseover(function () {
		$(this).parent().addClass("active");
	});
	$("a.facet-link").mouseleave(function () {
		$(this).parent().removeClass("active");
	});
		
	$("#edit-keys").live('keyup', function(e){
		console.log($(this).val().length);
		if ($(this).val().length == 0 && e.keyCode != 13){ $(".facet-filter").hide(); return;}
		$(".facet-filter").show();
		load_facet_pulldown($(this).val());
	});
});

function load_facet_pulldown($term){
	$(".facet-filter").load("/facets/pulldown/"+$term.replace(' ','%20'), 
		function (responseText, textStatus, XMLHttpRequest) {
		if (textStatus == "success") {	}
		if (textStatus == "error") {   }
	});
}
</script>

<style type="text/css">
input.form-text,select,textarea {
	border: none;
}

#edit-apachesolr-search-retain-filters-wrapper {
	display: none;
}

.facet-filter {
	margin-top: 0;
	position: absolute;
}

.search-cover {
	position: relative;
}
</style>
<div class="search-cover">
	<div class="jumbo-search">
		<div class="jumbo-search-container">
			<?php $form['basic']['#title']=t('');
				$form['basic']['inline']['keys']['#attributes'] = Array('class'=>'jumbo-search-field default','autocomplete'=>'off');
				$form['basic']['inline']['submit']['#attributes'] = Array('class'=>'jumbo-search-button');
				print drupal_render($form); ?>
		</div>
	</div>
	<div class="facet-filter"><ul><li><a class="facet-link" href"#"></a></li></ul></div>
</div>