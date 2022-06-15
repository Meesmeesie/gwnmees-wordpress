<div class="mp-admin-metabox">

	<?php $role = $object['data'];

	$this->__construct( array(
		'class'		=> 'mp-role-subscriptions',
		'prefix_id'	=> 'role',
		'fields' => array(
			array(
				'id'		    => 'subscriber',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Subscribe To The Music Page', 'music-press-pro' ),
				'description' 	=> __( 'User\'s in this group can subscribe to the music page on the site.', 'music-press-pro' ),
				'value'		    => isset( $role['subscriber'] ) ? $role['subscriber'] : 0,
			),
			array(
				'id'		    => 'subscriber_rss',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Subscribe To The Music Page via RSS', 'music-press-pro' ),
				'description' 	=> __( 'User\'s in this group is allowed to view the subscribe to rss link.', 'music-press-pro' ),
				'value'		    => isset( $role['subscriber_rss'] ) ? $role['subscriber_rss'] : 0,
			)
		)
	) );
	$this->render_form(); ?>

</div>