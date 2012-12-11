<script>
$(function() {

$('#<?php echo $field_slug ?>_select').keyup(function() {

	$.ajax({
		type: 'POST',
		data: 'stream_slug=<?php echo $stream_slug ?>&title_column=<?php echo $title_column ?>&search_term='+$('#<?php echo $field_slug ?>_select').val(),
		url: '<?php echo site_url('streams/public_ajax/field/'.$field_type.'/rel_search') ?>',
		success: function(response){
			$('#<?php echo $field_slug ?>_select_target').html(response);
		}
	});

});

// Select, populate, and close
$('.<?php echo $stream_slug ?>_autocomplete_item').live('click', function() {
 
 	// Populate the hidden val
 	$('#<?php echo $field_slug ?>').val($(this).attr('id'));
 	
 	// Poplate the dummy field
 	$('#<?php echo $field_slug ?>_select').val($(this).attr('name'));
 
 	// Get rid of it
 	$('#<?php echo $field_slug ?>_select_target').html('');
 	
});

});
</script>
