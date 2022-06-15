<?php

/*
*  Meta box - locations
*
*  This template file is used when editing a field group and creates the interface for editing location rules.
*
*  @type	template
*  @date	23/06/12
*/


// global
global $post;
		
		
// vars
$groups = apply_filters('acf/field_group/get_location', array(), $post->ID);


// at lease 1 location rule
if( empty($groups) )
{
	$groups = array(
		
		// group_0
		array(
			
			// rule_0
			array(
				'param'		=>	'post_type',
				'operator'	=>	'==',
				'value'		=>	'post',
				'order_no'	=>	0,
				'group_no'	=>	0
			)
		)
		
	);
}


?>
<table class="acf_input widefat" id="acf_location">
	<tbody>
	<tr>
		<td class="label">
			<label for="post_type"><?php esc_html_e("Rules",'acf'); ?></label>
			<p class="description"><?php esc_html_e("Create a set of rules to determine which edit screens will use these advanced custom fields",'acf'); ?></p>
		</td>
		<td>
			<div class="location-groups">
				
<?php if( is_array($groups) ): ?>
	<?php foreach( $groups as $group_id => $group ): 
		$group_id = 'group_' . $group_id;
		?>
		<div class="location-group" data-id="<?php echo $group_id; ?>">
			<?php if( $group_id == 'group_0' ): ?>
				<h4><?php esc_html_e("Show this field group if",'acf'); ?></h4>
			<?php else: ?>
				<h4><?php esc_html_e("or",'acf'); ?></h4>
			<?php endif; ?>
			<?php if( is_array($group) ): ?>
			<table class="acf_input widefat">
				<tbody>
					<?php foreach( $group as $rule_id => $rule ): 
						$rule_id = 'rule_' . $rule_id;
					?>
					<tr data-id="<?php echo $rule_id; ?>">
					<td class="param"><?php 
						
						$choices = array(
                            esc_html__("Basic",'acf') => array(
								'post_type'		=>	esc_html__("Post Type",'acf'),
								'user_type'		=>	esc_html__("Logged in User Type",'acf'),
							),
							esc_html__("Post",'acf') => array(
								'post'			=>	esc_html__("Post",'acf'),
								'post_category'	=>	esc_html__("Post Category",'acf'),
								'post_format'	=>	esc_html__("Post Format",'acf'),
								'post_status'	=>	esc_html__("Post Status",'acf'),
								'taxonomy'		=>	esc_html__("Post Taxonomy",'acf'),
							),
							esc_html__("Page",'acf') => array(
								'page'			=>	esc_html__("Page",'acf'),
								'page_type'		=>	esc_html__("Page Type",'acf'),
								'page_parent'	=>	esc_html__("Page Parent",'acf'),
								'page_template'	=>	esc_html__("Page Template",'acf'),
							),
							esc_html__("Other",'acf') => array(
								'ef_media'		=>	esc_html__("Attachment",'acf'),
								'ef_taxonomy'	=>	esc_html__("Taxonomy Term",'acf'),
								'ef_user'		=>	esc_html__("User",'acf'),
							)
						);
								
						
						// allow custom location rules
						$choices = apply_filters( 'acf/location/rule_types', $choices );
						
						
						// create field
						$args = array(
							'type'	=>	'select',
							'name'	=>	'location[' . $group_id . '][' . $rule_id . '][param]',
							'value'	=>	$rule['param'],
							'choices' => $choices,
						);
						
						do_action('acf/create_field', $args);							
						
					?></td>
					<td class="operator"><?php 	
						
						$choices = array(
							'=='	=>	esc_html__("is equal to",'acf'),
							'!='	=>	esc_html__("is not equal to",'acf'),
						);
						
						
						// allow custom location rules
						$choices = apply_filters( 'acf/location/rule_operators', $choices );
						
						
						// create field
						do_action('acf/create_field', array(
							'type'	=>	'select',
							'name'	=>	'location[' . $group_id . '][' . $rule_id . '][operator]',
							'value'	=>	$rule['operator'],
							'choices' => $choices
						)); 	
						
					?></td>
					<td class="value"><?php 
						
						$this->ajax_render_location(array(
							'group_id' => $group_id,
							'rule_id' => $rule_id,
							'value' => $rule['value'],
							'param' => $rule['param'],
						)); 
						
					?></td>
					<td class="add">
						<a href="#" class="location-add-rule button"><?php esc_html_e("and",'acf'); ?></a>
					</td>
					<td class="remove">
						<a href="#" class="location-remove-rule acf-button-remove"></a>
					</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
	
	<h4><?php esc_html_e("or",'acf'); ?></h4>
	
	<a class="button location-add-group" href="#"><?php esc_html_e("Add rule group",'acf'); ?></a>
	
<?php endif; ?>
				
			</div>
		</td>
	</tr>
	</tbody>
</table>