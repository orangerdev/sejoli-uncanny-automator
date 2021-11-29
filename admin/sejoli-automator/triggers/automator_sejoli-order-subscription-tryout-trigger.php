<?php
use Uncanny_Automator\Recipe;

/**
 * Class Automator_Sejoli_Order_Subscription_Tryout_Trigger
 */
class Automator_Sejoli_Order_Subscription_Tryout_Trigger {
	
	use Recipe\Triggers;

	/**
	 * Automator_Sejoli_Order_Subscription_Tryout_Trigger constructor.
	 */
	public function __construct() {
	
		$this->setup_trigger();
	
	}

	/**
	 * Setup Trigger
	 */
	protected function setup_trigger() {

		$this->set_integration( 'SEJOLI' );

		$this->set_trigger_code( 'SEJOLI_ORDER_SUBSCRIPTION_TRYOUT' ); // Unique Trigger code

		$this->set_trigger_meta( 'SEJOLI_CREATE_ORDER_SUBSCRIPTION_TRYOUT' ); // Re-useable meta, selectable value in blue boxes

		/* Translators: Some information for translators */
		$this->set_sentence( sprintf( 'If there is a "tryout" subscription order type' ) ); // Sentence to appear when trigger is added. {{a page:%1$s}} will be presented in blue box as selectable value

		/* Translators: Some information for translators */
		$this->set_readable_sentence( 'If there is a "tryout" subscription order type' ); // Non-active state sentence to show

		$this->add_action( 'sejoli/thank-you/render', 999, 2 ); // which do_action() fires this trigger

		$this->register_trigger(); // Registering this trigger

	}

	/**
	 * Validate Trigger
	 * @return bool
	 */
	protected function validate_trigger( $order ) : bool {

		$order_id = $order[0]['ID'];
		$subscription_type = $order[0]['type'];
	    if ( empty( $order ) && empty( $order_id ) ) {
			return false;
		} else {
			if( $subscription_type === 'subscription-tryout' ) :
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
	protected function prepare_to_run( $order ) {

		// Set Order ID
		$order_id = absint( $order[0]['ID'] );
		$this->set_ignore_post_id( $order_id );

	}

}
