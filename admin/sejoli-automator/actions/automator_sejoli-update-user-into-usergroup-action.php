<?php
use Uncanny_Automator\Recipe;

/**
 * Class Automator_Sejoli_Update_User_Into_Usergroup_Action
 */
class Automator_Sejoli_Update_User_Into_Usergroup_Action {

	use Recipe\Actions;

	/**
	 * Automator_Sejoli_Update_User_Into_Usergroup_Action constructor.
	 */
	public function __construct() {
		
		$this->setup_action();

	}

	/**
	 * Setup Actions
	 */
	protected function setup_action() {

		$this->set_integration( 'SEJOLI' );

		$this->set_action_code( 'SEJOLI_USER_GROUP' );
		
		$this->set_action_meta( 'SEJOLI_SET_USER_GROUP' );
		
		/* translators: Action - WordPress */
		$this->set_sentence( sprintf( esc_attr__( 'Update User into {{User Group:%1$s}}', 'sejoli-uncanny-automator' ), $this->get_action_meta() ) );
		
		/* translators: Action - WordPress */
		$this->set_readable_sentence( esc_attr__( 'Update User into {{User Group}}', 'sejoli-uncanny-automator' ) );

		$args = [
			'post_type'      		 => 'sejoli-user-group',
			'posts_per_page' 		 => 200,
			'orderby'        		 => 'title',
			'order'     	 		 => 'ASC',
			'no_found_rows'  		 => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'post_status'    		 => 'publish',
		];

		$user_group_option = Automator()->helpers->recipe->options->wp_query( $args, false, esc_attr__( 'Select User Group', 'sejoli-uncanny-automator' ) );

		$options_group = array(
		
			$this->get_action_meta() => array(
				
				/* translators: User Group field */
				Automator()->helpers->recipe->field->select_field_args(
					array(
						'option_code' => 'SEJOLI_SET_USER_GROUP',
						'label'       => __( 'Select User Group', 'sejoli-uncanny-automator' ),
						'input_type'  => 'select',
						'options'	  => $user_group_option
					)
				),
			)
		
		);

		$this->set_options_group( $options_group );

		$this->register_action();

	}

	/**
	 * @param int $user_id
	 * @param array $action_data
	 * @param int $recipe_id
	 * @param array $args
	 * @param $parsed
	 */
	protected function process_action( $user_id, $action_data, $recipe_id, $args, $parsed ) {
		
		$action_meta    = $action_data['meta'];
		$get_user_group = Automator()->parse->text( $action_meta['SEJOLI_SET_USER_GROUP'], $recipe_id, $user_id, $args );
		if( !empty( $user_id ) && !empty( $get_user_group ) ) :
            
            $update_user_group = sejolisa_update_user_group( $user_id, intval( $get_user_group ), true );

            // If there was an error, it'll be logged in action log with an error message.
			if ( is_automator_error( $update_user_group ) ) {

				$error_message = $this->get_error_message();
				// Complete action with errors and log Error message.
				Automator()->complete->action( $user_id, $action_data, $recipe_id, $error_message );
			
			}
			
			// Everything went fine. Complete action.
			Automator()->complete->action( $user_id, $action_data, $recipe_id );
        
        endif;

	}

}