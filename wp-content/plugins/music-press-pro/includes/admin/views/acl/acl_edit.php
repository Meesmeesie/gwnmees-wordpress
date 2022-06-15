<script type="text/javascript">
    jQuery( document ).ready( function() {
        postboxes.add_postbox_toggles( '<?php echo $this->data_edit['screen_id']; ?>' );
    });
</script>

<div class="wrap">
	<h2>
		<?php echo ( 'add' == $_GET['action'] ) ? __( 'Add New Role', 'music-press-pro' ) : __( 'Edit Role', 'music-press-pro' ) ?>
        <input type="button" value="<?php echo ! empty( $_GET['id'] ) ? __( 'Update Role', 'music-press-pro' ) : __( 'Create Role', 'music-press-pro' ) ?>" class="button-primary" id="create_role" name="create_role" style="vertical-align: top;" onclick="$('#mp_edit_role').submit();">
        <input type="button" class="cancel_popup button" value="<?php _e( 'Cancel', 'music-press-pro' ) ?>" onclick="window.location = '<?php echo add_query_arg( array( 'page' => 'mp_roles' ), admin_url( 'admin.php' ) ) ?>';" />
	</h2>

	<?php if ( ! empty( $_GET['msg'] ) ) {
		switch( $_GET['msg'] ) {
			case 'a':
				echo '<div id="message" class="updated fade"><p>' . __( 'User Role <strong>Added</strong> Successfully.', 'music-press-pro' ) . '</p></div>';
				break;
			case 'u':
				echo '<div id="message" class="updated fade"><p>' . __( 'User Role <strong>Updated</strong> Successfully.', 'music-press-pro' ) . '</p></div>';
				break;
		}
	}

	if ( ! empty( $error ) ) { ?>
		<div id="message" class="error fade">
			<p><?php echo $error ?></p>
		</div>
	<?php } ?>

	<form id="mp_edit_role" action="" method="post">
		<input type="hidden" name="role[id]" value="<?php echo isset( $_GET['id'] ) ? esc_attr( $_GET['id'] ) : '' ?>" />
		<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div id="titlediv">
						<div id="titlewrap">
							<?php if ( 'add' == $_GET['action'] ) { ?>
								<label for="title" class="screen-reader-text"><?php _e( 'Title', 'music-press-pro' ) ?></label>
								<input type="text" name="role[name]" placeholder="<?php _e( 'Enter Title Here', 'music-press-pro' ) ?>" id="title" value="<?php echo isset( $this->data_edit['data']['name'] ) ? $this->data_edit['data']['name'] : '' ?>" />
							<?php } else { ?>
								<input type="hidden" name="role[name]" value="<?php echo isset( $this->data_edit['data']['name'] ) ? $this->data_edit['data']['name'] : '' ?>" />
								<h1 style="float: left;width:100%;"><?php echo isset( $this->data_edit['data']['name'] ) ? $this->data_edit['data']['name'] : '' ?></h1>
							<?php } ?>
						</div>
					</div>
				</div>
				<div id="postbox-container" class="postbox-container">
					<?php do_meta_boxes( 'mp_role_meta', 'normal', array( 'data' => $this->data_edit['data'], 'option' => $this->data_edit['option'] ) ); ?>
				</div>
			</div>
		</div>
	</form>
</div>