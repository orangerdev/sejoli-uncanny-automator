<?php
use Uncanny_Automator\Recipe;

/**
 * Class Automator_Sejoli_Update_Order_Status_Trigger
 */
class Automator_Sejoli_Update_Order_Status_Trigger {
	
	use Recipe\Triggers;

	/**
	 * Automator_Sejoli_Update_Order_Status_Trigger constructor.
	 */
	public function __construct() {
	
		$this->setup_trigger();
	
	}

	/**
	 * Setup Trigger
	 */
	protected function setup_trigger() {

		$this->set_integration( 'SEJOLI' );
		
		$this->set_trigger_code( 'SEJOLI_UPDATE_ORDER_STATUS' ); // Unique Trigger code

		$this->set_trigger_meta( 'SEJOLI_UPDATE_ORDER' ); // Re-useable meta, selectable value in blue boxes

		/* Translators: Some information for translators */
		$this->set_sentence( sprintf( 'If there is a change in order status' ) ); // Sentence to appear when trigger is added. {{a page:%1$s}} will be presented in blue box as selectable value

		/* Translators: Some information for translators */
		$this->set_readable_sentence( 'If there is a change in order status' ); // Non-active state sentence to show

		$this->add_action( 'sejoli/order/update-status', 999, 2 ); // which do_action() fires this trigger

		$this->register_trigger(); // Registering this trigger

	}

	/**
	 * Validate Trigger
	 * @return bool
	 */
	protected function validate_trigger( $args ) : bool {

	    if ( empty( $args ) ) {
			return false;
		} else {
			$respond = sejolisa_get_order([
		        'ID' => $args[0]['ID']
		    ]);

		    if(false !== $respond['valid'] && isset($respond['orders']) && isset($respond['orders']['ID'])) :
				return true;
		    else:
		    	return false;
		    endif;
		}

	}

	/**
	 * Set Order ID
	 * @param mixed $args
	 */
	protected function prepare_to_run( $args ) {

		// Set Order ID
		$order_id = absint( $args[0]['ID'] );
		$this->set_ignore_post_id( $order_id );

	}

}
