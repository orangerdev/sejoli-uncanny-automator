<?php
use Uncanny_Automator\Recipe;

/**
 * Class SEJOLI_ZOOM_UNREGISTERUSERLESS
 * @package Uncanny_Automator
 */
class SEJOLI_ZOOM_UNREGISTERUSERLESS {

	/**
	 * Integration code
	 *
	 * @var string
	 */
	public static $integration = 'SEJOLI-ZOOM';

	private $action_code;
	private $action_meta;

	/**
	 * Set up Automator action constructor.
	 */
	public function __construct() {
		
		$this->action_code = 'SEJOLIZOOMUNREGISTERUSERLESS';
		$this->action_meta = 'SEJOLIZOOMMEETING';
		
		$this->define_action();
	
	}

	/**
	 * Define and register the action by pushing it into the Automator object
	 */
	public function define_action() {

		$action = array(
			'author'             => Automator()->get_author_name( $this->action_code ),
			'support_link'       => Automator()->get_author_support_link( $this->action_code, 'knowledge-base/zoom/' ),
			'is_pro'             => false,
			'requires_user'      => false,
			'integration'        => self::$integration,
			'code'               => $this->action_code,
			'sentence'           => sprintf( __( 'Remove an attendee from {{a meeting:%1$s}}', 'sejoli-uncanny-automator' ), $this->action_meta ),
			'select_option_name' => __( 'Remove an attendee from {{a meeting}}', 'sejoli-uncanny-automator' ),
			'priority'           => 10,
			'accepted_args'      => 1,
			'execution_function' => array( $this, 'zoom_unregister_user' ),
			'options_callback'   => array( $this, 'load_options' )
		);

		Automator()->register->action( $action );
	
	}

	/**
	 * load_options
	 *
	 * @return void
	 */
	public function load_options() {
		
		$email_field_options = array(
			'option_code' => 'EMAIL',
			'input_type'  => 'text',
			'label'       => esc_attr__( 'Email address', 'sejoli-uncanny-automator' ),
			'placeholder' => '',
			'description' => '',
			'required'    => true,
			'tokens'      => true,
			'default'     => '',
		);

		$email_field = Automator()->helpers->recipe->field->text( $email_field_options );

		return array(
			'options_group' => array(
				$this->action_meta => array(
					$email_field,

					Automator()->helpers->recipe->zoom->get_meetings( null, $this->action_meta )
				)
			)
		);

	}

	/**
	 * Validation function when the action is hit
	 *
	 * @param $user_id
	 * @param $action_data
	 * @param $recipe_id
	 */
	public function zoom_unregister_user( $user_id, $action_data, $recipe_id, $args ) {

		$meeting_key = Automator()->parse->text( $action_data['meta'][ $this->action_meta ], $recipe_id, $user_id, $args );
		$email       = Automator()->parse->text( $action_data['meta']['EMAIL'], $recipe_id, $user_id, $args );

		if ( empty( $email ) || ! is_email( $email ) ) {
			$error_msg                           = __( 'Email address is missing or invalid.', 'sejoli-uncanny-automator' );
			$action_data['do-nothing']           = true;
			$action_data['complete_with_errors'] = true;

			Automator()->complete_action( $user_id, $action_data, $recipe_id, $error_msg );

			return;
		}

		if ( empty( $meeting_key ) ) {
			$error_msg                           = __( 'Meeting not found.', 'sejoli-uncanny-automator' );
			$action_data['do-nothing']           = true;
			$action_data['complete_with_errors'] = true;

			Automator()->complete_action( $user_id, $action_data, $recipe_id, $error_msg );

			return;
		}

		if ( ! empty( $meeting_key ) ) {
			$meeting_key = str_replace( '-objectkey', '', $meeting_key );
		}

		$result = Automator()->helpers->recipe->zoom->unregister_user( $email, $meeting_key );

		if ( ! $result['result'] ) {
			$error_msg                           = $result['message'];
			$action_data['do-nothing']           = true;
			$action_data['complete_with_errors'] = true;

			Automator()->complete_action( $user_id, $action_data, $recipe_id, $error_msg );

			return;
		}

		Automator()->complete_action( $user_id, $action_data, $recipe_id );

	}

}