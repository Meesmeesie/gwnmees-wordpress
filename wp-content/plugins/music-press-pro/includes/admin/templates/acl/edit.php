<div class="mp-admin-metabox">
	<?php $role = $object['data'];

	$this->__construct( array(
		'class'		=> 'mp-role-edit',
		'prefix_id'	=> 'role',
		'fields' => array(
			array(
				'id'		    => 'edit_others_songs',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit others Songs', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit others songs on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_others_songs'] ) ? $role['edit_others_songs'] : 0,
			),
			array(
				'id'		    => 'edit_published_songs',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit published Songs', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit published songs on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_published_songs'] ) ? $role['edit_published_songs'] : 0,
			),
			array(
				'id'		    => 'edit_others_albums',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit others albums', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit others albums on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_others_albums'] ) ? $role['edit_others_albums'] : 0,
			),
			array(
				'id'		    => 'edit_published_albums',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit published albums', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit published albums on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_published_albums'] ) ? $role['edit_published_albums'] : 0,
			),
			array(
				'id'		    => 'edit_others_genres',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit others genres', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit others genres on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_others_genres'] ) ? $role['edit_others_genres'] : 0,
			),
			array(
				'id'		    => 'edit_published_genres',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit published genres', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit published genres on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_published_genres'] ) ? $role['edit_published_genres'] : 0,
			),
			array(
				'id'		    => 'edit_others_bands',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit others bands', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit others bands on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_others_bands'] ) ? $role['edit_others_bands'] : 0,
			),
			array(
				'id'		    => 'edit_published_bands',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit published bands', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit published bands on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_published_bands'] ) ? $role['edit_published_bands'] : 0,
			),
			array(
				'id'		    => 'edit_others_artists',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit others artists', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit others artists on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_others_artists'] ) ? $role['edit_others_artists'] : 0,
			),
			array(
				'id'		    => 'edit_published_artists',
				'type'		    => 'checkbox',
				'label'		    => __( 'Allowed To edit published artists', 'music-press-pro' ),
				'description'	=> __( 'Users in this group is allowed to edit published artists on the site.', 'music-press-pro' ),
				'value'		    => ! empty( $role['edit_published_artists'] ) ? $role['edit_published_artists'] : 0,
			),
		)
	) );
	$this->render_form();
	?>
</div>