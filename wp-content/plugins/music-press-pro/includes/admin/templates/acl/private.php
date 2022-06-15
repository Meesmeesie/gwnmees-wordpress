<div class="mp-admin-metabox">
	<?php $role = $object['data'];

	$this->__construct( array(
		'class'		=> 'mp-role-private',
		'prefix_id'	=> 'role',
		'fields' => array(
			array(
				'id'		    => 'edit_private_songs',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create Private Song', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a private song on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_private_songs'] ) ? $role['edit_private_songs'] : 0,
			),
			array(
				'id'		    => 'read_private_songs',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Read Private Song', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to read private song.', 'music-press-pro' ),
				'value'		    => isset( $role['read_private_songs'] ) ? $role['read_private_songs'] : 0,
			),
			array(
				'id'		    => 'delete_private_songs',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Delete private Songs', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to delete private songs on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['delete_private_songs'] ) ? $role['delete_private_songs'] : 0,
			),
			array(
				'id'		    => 'edit_private_genres',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create Private Genre', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a private Genre on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_private_genres'] ) ? $role['edit_private_genres'] : 0,
			),
			array(
				'id'		    => 'read_private_genres',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Read Private Genres', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to read private Genres.', 'music-press-pro' ),
				'value'		    => isset( $role['read_private_genres'] ) ? $role['read_private_genres'] : 0,
			),
			array(
				'id'		    => 'delete_private_genres',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Delete private Genres', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to delete private genres on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['delete_private_genres'] ) ? $role['delete_private_genres'] : 0,
			),
			array(
				'id'		    => 'edit_private_albums',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create Private album', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a private album on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_private_albums'] ) ? $role['edit_private_albums'] : 0,
			),
			array(
				'id'		    => 'read_private_albums',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Read Private albums', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to read private albums.', 'music-press-pro' ),
				'value'		    => isset( $role['read_private_albums'] ) ? $role['read_private_albums'] : 0,
			),
			array(
				'id'		    => 'delete_private_albums',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Delete private albums', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to delete private albums on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['delete_private_albums'] ) ? $role['delete_private_albums'] : 0,
			),
			array(
				'id'		    => 'edit_private_bands',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create Private band', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a private band on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_private_bands'] ) ? $role['edit_private_bands'] : 0,
			),
			array(
				'id'		    => 'read_private_bands',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Read Private bands', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to read private bands.', 'music-press-pro' ),
				'value'		    => isset( $role['read_private_bands'] ) ? $role['read_private_bands'] : 0,
			),
			array(
				'id'		    => 'delete_private_bands',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Delete private bands', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to delete private bands on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['delete_private_bands'] ) ? $role['delete_private_bands'] : 0,
			),
			array(
				'id'		    => 'edit_private_artists',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Create Private artist', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to create a private artist on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_private_artists'] ) ? $role['edit_private_artists'] : 0,
			),
			array(
				'id'		    => 'read_private_artists',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Read Private artists', 'music-press-pro' ),
				'description'	=> __( 'User is allowed to read private artists.', 'music-press-pro' ),
				'value'		    => isset( $role['read_private_artists'] ) ? $role['read_private_artists'] : 0,
			),
			array(
				'id'		    => 'delete_private_artists',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To Delete private artists', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to delete private artists on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['delete_private_artists'] ) ? $role['delete_private_artists'] : 0,
			)
		)
	) );
	$this->render_form();
	?>
</div>