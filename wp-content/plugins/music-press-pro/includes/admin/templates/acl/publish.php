<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$role = $object['data']; ?>

<div class="um-admin-metabox">
	<?php $this->__construct( array(
		'class'		=> 'um-role-publish um-top-label',
		'prefix_id'	=> 'role',
		'fields' => array(
			array(
				'id'		    => '_mp_priority',
				'type'		    => 'text',
				'label'    		=> __( 'Role Priority', 'ultimate-member' ),
				'tooltip' 	=> __( 'The higher the number, the higher the priority', 'music-press-pro' ),
				'value'		    => ! empty( $role['_mp_priority'] ) ? $role['_mp_priority'] : '',
			),
		)
	) );
	$this->render_form(); ?>
</div>
<div class="submitbox" id="submitpost">
	<div id="major-publishing-actions">
		<input type="submit" value="<?php echo ! empty( $_GET['id'] ) ? __( 'Update Role', 'music-press-pro' ) : __( 'Create Role', 'music-press-pro' ) ?>" class="button-primary" id="create_role" name="create_role">
		<input type="button" class="cancel_popup button" value="<?php _e( 'Cancel', 'music-press-pro' ) ?>" onclick="window.location = '<?php echo add_query_arg( array( 'page' => 'mp_roles' ), admin_url( 'admin.php' ) ) ?>';" />
		<div class="clear"></div>
	</div>
</div>