<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$courses_post_settings = get_post_meta( $post->ID, 'courses_table_data_'.$post->ID, true);		
wp_enqueue_style( 'Courses', WP_PLUGIN_URL . '/courses/css/style-admin.css',false,'1.1','all');
?>
<div class="col-lg-12 course-tab-container">
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 course-tab">
		<div class="course-tab-content active">
			<div id="pricing-container">
				<?php
				if(is_array($courses_post_settings) && isset($courses_post_settings['courses_venue'])) {
					$total_columns = count($courses_post_settings['courses_venue']);
				} else { 
					$total_columns = 0;
				}
				?>
				<input type="hidden" id="total_cols" name="total_cols" class="total_cols" value="<?php echo $total_columns; ?>">
				<?php
				if(is_array($courses_post_settings)) {
					for($i = 0; $i < $total_columns; $i++) {
				?>	
				<div class="schedule_main_div col-md-4 column_<?php echo $i; ?>">
					<div class="pri_head">
						<a data-toggle="tooltip" data-placement="top" title="Delete table" class="time" id="pri_delete" onclick="return delete_column('column_<?php echo $i; ?>')"><span class="dashicons dashicons-trash"></span></a>
						<h3>Schedule <?php echo $i+1; ?></h3>
					</div>
					<ul>
						<li>
							<label>Start Date:</label>
							<input type="date"  id="courses_startingdate" name="courses_startingdate[]" class="text" placeholder="YYYY-MM-DD" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo $courses_post_settings['courses_startingdate'][$i]; ?>" required>
						</li>
						<li>
							<label>End Date:</label>
							<input type="date" id="courses_enddate" name="courses_enddate[]" class="text" placeholder="YYYY-MM-DD" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo $courses_post_settings['courses_enddate'][$i]; ?>" required>
						</li>
						
						<li>
							<label>Venue:</label>
							<input type="text" id="courses_venue" name="courses_venue[]" class="text" placeholder="<?php _e('Venue'); ?>" value="<?php echo $courses_post_settings['courses_venue'][$i]; ?>" required>	
						</li>
						<li>
							<label>Fees(in AED):</label>
							<input type="number" id="courses_fee" name="courses_fee[]" class="text" placeholder="<?php _e('Fee'); ?>" value="<?php echo $courses_post_settings['courses_fee'][$i]; ?>" required>	
						</li>
					</ul>
				</div>
				<?php
					}
				}
				?>
			</div>
			<div class="aad-btn text-center">
				<h3><?php _e('Click On Add Schedule'); ?></h3>
				<button type="button" id="pricing_appending" class="btn-default" onclick="return add_new_column()" aria-hidden="true"><span class="dashicons dashicons-plus icon_new"></span> <?php _e('ADD'); ?></button>
				
			</div>
		</div>	
		
	</div>
</div>
<script>
	function add_new_column() {
		var total_cols = jQuery('#total_cols').val();
		var nextcol = parseInt(total_cols)+1;
		var columns_class_name = "column_" + total_cols;
		var iconpick_class_name = "iconpick_" + total_cols;
		var new_col_html = ''+
		'<div id="columns[]" class="schedule_main_div col-md-4 '+columns_class_name+'">' +
		'<div class="pri_head">' +
				'<a data-toggle="tooltip" data-placement="top" title="Delete table" class="time" id="pri_delete" onclick=delete_column("'+columns_class_name+'");><span class="dashicons dashicons-trash"></span></a><h3>Schedule '+nextcol+'</h3>' +	
			'</div>' +
			'<ul>' +
				'<li><label>Starting Date:</label>' +
					'<input type="date" id="courses_startingdate[]" name="courses_startingdate[]"" class="text"   placeholder="YYYY-MM-DD" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="" required >' +
				'</li>' +
				'<li><label>End Date:</label>' +
					'<input type="date" id="courses_enddate[]" name="courses_enddate[]" class="text"   placeholder="YYYY-MM-DD" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="" required>' +
				'</li>' +
				'<li><label>Venue:</label>' +
					'<input type="text" id="courses_venue[]" name="courses_venue[]" class="text" placeholder="<?php _e('Venue'); ?>" value="" required>' +
				'</li>' +
				'<li><label>Fees(in AED):</label>' +
					'<input type="number" id="courses_fee[]" name="courses_fee[]" class="text" placeholder="<?php _e('Fee'); ?>" value="" required>' +
				'</li>' +
			'</ul>' +
		'</div>';
		
		var new_icon_picker = '<button type="button" value="" id="pricing_icon_pick[]" name="pricing_icon_pick[]" class="'+iconpick_class_name+' '+columns_class_name+' target_picker btn btn-default" data-iconset="fontawesome" data-icon="fa-wifi" role="iconpicker"></button>';
		
		jQuery('#iconpicker-container').append(new_icon_picker);
		
		jQuery('#pricing-container').append(new_col_html);
		
		var total_cols = parseInt(jQuery('#total_cols').val());
		jQuery('#total_cols').val(total_cols + 1);
		jQuery('[data-toggle="tooltip"]').tooltip();
		jQuery('.target_picker').iconpicker();
	}
	function delete_column(col_id){
		if (confirm('Are sure to delete this columns from table?')) {
			jQuery( "."+ col_id ).fadeOut( 1000, function() {
				jQuery( "."+ col_id ).remove();
				var total_cols = parseInt(jQuery('#total_cols').val());
				//jQuery('#total_cols').val(total_cols - 1);
			});
		}
	}
</script>