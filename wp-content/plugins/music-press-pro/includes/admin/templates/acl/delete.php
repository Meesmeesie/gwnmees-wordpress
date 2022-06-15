<div class="mp-admin-metabox">

	<?php $role = $object['data'];

	$this->__construct( array(
		'class'		=> 'mp-role-delete',
		'prefix_id'	=> 'role',
		'fields' => array(

			array(
				'id'		    => 'delete_songs',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Own Song', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete own song.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_songs'] ) ? $role['delete_songs'] : 0,
			),
			array(
				'id'		    => 'delete_albums',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Own Album', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete own album.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_albums'] ) ? $role['delete_albums'] : 0,
			),
			array(
				'id'		    => 'delete_genres',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Own Genre', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete own genre.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_genres'] ) ? $role['delete_genres'] : 0,
			),
			array(
				'id'		    => 'delete_bands',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Own Band', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete own Band.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_bands'] ) ? $role['delete_bands'] : 0,
			),
			array(
				'id'		    => 'delete_artists',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Own Artist', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete own Artist.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_artists'] ) ? $role['delete_artists'] : 0,
			),
			array(
				'id'		    => 'delete_others_songs',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Others Song', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete others songs.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_others_songs'] ) ? $role['delete_others_songs'] : 0,
			),
			array(
				'id'		    => 'delete_others_albums',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Others Album', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete others albums.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_others_albums'] ) ? $role['delete_others_albums'] : 0,
			),
			array(
				'id'		    => 'delete_others_genres',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Others Genre', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete others genres.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_others_genres'] ) ? $role['delete_others_genres'] : 0,
			),
			array(
				'id'		    => 'delete_others_bands',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Others Band', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete others Bands.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_others_bands'] ) ? $role['delete_others_bands'] : 0,
			),
			array(
				'id'		    => 'delete_others_artists',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete Others Artists', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete others Artists.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_others_artists'] ) ? $role['delete_others_artists'] : 0,
			),
			array(
				'id'		    => 'delete_published_songs',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete published Song', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete published songs.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_published_songs'] ) ? $role['delete_published_songs'] : 0,
			),
			array(
				'id'		    => 'delete_published_albums',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete published Album', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete published albums.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_published_albums'] ) ? $role['delete_published_albums'] : 0,
			),
			array(
				'id'		    => 'delete_published_genres',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete published Genre', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete published genres.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_published_genres'] ) ? $role['delete_published_genres'] : 0,
			),
			array(
				'id'		    => 'delete_published_bands',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete published Band', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete published Bands.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_published_bands'] ) ? $role['delete_published_bands'] : 0,
			),
			array(
				'id'		    => 'delete_published_artists',
				'type'		    => 'checkbox',
				'label'    		=> __( 'Delete published Artists', 'music-press-pro' ),
				'description' 	=> __( 'User is allowed to delete published Artists.', 'music-press-pro' ),
				'value'		    => isset( $role['delete_published_artists'] ) ? $role['delete_published_artists'] : 0,
			)
		)
	) );
	$this->render_form(); ?>

</div>