<div class="mp-admin-metabox">
	<?php $role = $object['data'];

	$this->__construct( array(
		'class'		=> 'mp-role-composer',
		'prefix_id'	=> 'role',
		'fields' => array(
			array(
				'id'		    => 'edit_songs',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create New Song', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a song on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_songs'] ) ? $role['edit_songs'] : 0,
			),
			array(
				'id'		    => 'publish_songs',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Publish Song', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to publish their song.', 'music-press-pro' ),
				'value'		    => isset( $role['publish_songs'] ) ? $role['publish_songs'] : 0,
			),
			array(
				'id'		    => 'edit_albums',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create New Album', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a album on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_albums'] ) ? $role['edit_albums'] : 0,
			),
			array(
				'id'		    => 'publish_albums',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Publish Album', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to publish their song.', 'music-press-pro' ),
				'value'		    => isset( $role['publish_albums'] ) ? $role['publish_albums'] : 0,
			),
			array(
				'id'		    => 'edit_genres',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create New Genre', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a genre on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_genres'] ) ? $role['edit_genres'] : 0,
			),
			array(
				'id'		    => 'publish_genres',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Publish Genre', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to publish their genre.', 'music-press-pro' ),
				'value'		    => isset( $role['publish_genres'] ) ? $role['publish_genres'] : 0,
			),
			array(
				'id'		    => 'edit_bands',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create New Band', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a band on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_bands'] ) ? $role['edit_bands'] : 0,
			),
			array(
				'id'		    => 'publish_bands',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Publish Band', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to publish their band.', 'music-press-pro' ),
				'value'		    => isset( $role['publish_bands'] ) ? $role['publish_bands'] : 0,
			),
			array(
				'id'		    => 'edit_artists',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create New Artist', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a Artist on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_artists'] ) ? $role['edit_artists'] : 0,
			),
			array(
				'id'		    => 'publish_artists',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Publish Artist', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to publish their Artist.', 'music-press-pro' ),
				'value'		    => isset( $role['publish_artists'] ) ? $role['publish_artists'] : 0,
			)
		)
	) );
	$this->render_form();
	?>
</div>