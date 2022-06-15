<div class="mp-admin-metabox">
	<?php $role = $object['data'];

	$this->__construct( array(
		'class'		=> 'mp-role-composer',
		'prefix_id'	=> 'role',
		'fields' => array(
			array(
				'id'		    => 'read_song',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To view Songs', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to view song on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['read_song'] ) ? $role['read_song'] : 0,
			)
		)
	) );
	$this->render_form();
	?>
</div>