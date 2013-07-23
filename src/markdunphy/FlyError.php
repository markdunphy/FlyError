<?php
/**
 * Fly Error
 *
 * Store errors in session. Display them. Unset them. Forget them.
 *
 * Use this however you want for whatever you want. Modify it, but please
 * don't take credit as your own because that's just not cool.  Plus it's
 * not even an impressive class so why would you even both?
 *
 * @author Mark Dunphy @dunphtastic ( http://github.com/markdunphy )
 *
 */
class FlyError {

	/**
	 * This will contain all of your errors in a numbered array.
	 *
	 * @var array Reference to $_SESSION[$this->index]
	 */
	private $errors;

	/**
	 * @var array Reference to $_SESSION. Used for unsetting .
	 */
	private $session;

	/**
	 * This is a config option. This is the index we use in the session
	 * array to store all of the errors. Set to 'fly_error' by default
	 * since it shouldn't interfere with anything else you're storing in there.
	 * Change it if you'd like.
	 *
	 * @var string Name of the index in $_SESSION to store errors in. String
	 */
	private $index = 'fly_error';

	/**
	 * Constructor
	 *
	 * Initialize the error array in session if it doesn't exist already.
	 * Set up references.
	 */
	public function __construct()
	{
		// Lazily create the error array in session
		if ( !is_array( $_SESSION[ $this->index ] ) ) $_SESSION[ $this->index ] = array();

		$this->errors  = &$_SESSION[ $this->index ];
		$this->session = &$_SESSION;
	}

	/**
	 * Set an array of errors in the session.
	 *
	 * This will overwrite any other errors in session.
	 *
	 * @param array $errors Required. An array of error strings.
	 * @param string $redirect Optional. Provide a string location (e.g. errors.php)
	 * to redirect to after setting the errors. You would most likely use this page to display them.
	 */
	public function set( $errors = array(), $redirect = NULL )
	{
		// Check to make sure this is an array and is not empty
		if ( $this->validate( $errors ) )
		{
			$this->errors = $errors;

			if ( $redirect ) $this->redirect( $redirect );
		}

		return TRUE;
	}

	/**
	 * Get a specific index from the error stack.
	 *
	 * @param integer $index
	 */
	public function get( $index = 0 )
	{
		return ( isset( $this->errors[ $index ] ) ) ? $this->errors[ $index ] : FALSE;
	}

	/**
	 * Push method
	 *
	 * Pushes errors onto the stack.
	 *
	 * @param string|array $error Required. An error string|array to push onto the error array.
	 * @param string $redirect Where to redirect to. Leave blank to not redirect.
	 */
	public function push( $errors, $redirect = NULL )
	{
		// Check to make sure we were given something
		if ( !empty( $errors ) )
		{
			foreach ( (array) $errors as $error )
			{
				$this->errors[] = $error;
			}

			if ( $redirect ) $this->redirect( $redirect );
		}
	}

	/**
	 * Display method
	 *
	 * Display all of the errors in the array.
	 *
	 * @param boolean $unset Whether to unset the errors after displaying them. True by default.
	 */
	public function display( $unset = TRUE )
	{
		if ( !$this->validate( $this->errors ) ) return FALSE;

		print implode( '<br />', $this->errors );

		if ( $unset ) $this->clear();
	}

	/**
	 * Return all errors in session
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->errors;
	}

	/**
	 * Clear method
	 *
	 * Unset all errors stored in the session
	 */
	public function clear()
	{
		$_SESSION[ $this->index ] = array();
		$this->errors  			  = &$_SESSION[ $this->index ];
	}

	/**
	 * Has errors method
	 *
	 * Do we have any errors set?
	 *
	 * @return boolean True if we have errors, false if not.
	 */
	public function hasErrors()
	{
		return $this->validate( $this->errors );
	}

	/**
	 * Redirect method
	 *
	 * Used for redirecting to a new page.
	 * @param string $location Required. Where to redirect to.
	 * @return boolean False if no location is set. Otherwise void.
	 */
	private function redirect( $location = NULL )
	{
		if ( $location )
		{
			header( "Location: $location" );
			exit();
		}

		return FALSE;
	}

	/**
	 * Array validate method
	 *
	 * Validate an array. Checks if it is an array and if it is empty.
	 *
	 * @param array $array Required. The array to check.
	 * @return boolean Returns true if is array and not empty.
	 */
	private function validate( $array = NULL )
	{
		return ( is_array( $array ) && !empty( $array ) );
	}

}

?>