<?php
/*	Store errors in the session. Displat em. Unset em. Forget em.
 *	Created by @dunphtastic
 *	http://github.com/markdunphy
 *	Use this however you want for whatever you want.  Modify it, but do not
 *  take credit as your own because that's just not cool, man. Plus, it's not
 *  even an impressive class, so why would you even bother?
 ************************************************************************/
class FlyError {

	private $errors;
	private $session;

	/* If the errors array doesn't yet exist in session, this is where it gets
	/* created. Additionally we pass our class variable $errors as a refernce
	/* to it for easier modification.
	/************************************************************************/
	function __construct() {
		if ( !is_array($_SESSION['errors']) ) $_SESSION['errors'] = array();
		
		$this->errors = &$_SESSION['errors'];
		$this->session = &$_SESSION; // So we can unset errors faster
	}

	/* Sets an array of errors in the session. ($_SESSION['errors'])
	/* This will overwrite any other errors in session.
	/* @param $errors - Array [Required] - An indexed array of error strings.
	/* @param $redirect - String [Optional] - Redirect to this page or leave blank to
									 		  not redirect at all. ex. login.php
	/*********************************************************/	
	public function setSessionErrors($errors, $redirect=false) {
		// Check to make sure this is in fact an array and is not empty
		if ( is_array($errors) && !empty($errors) ) {
			$this->errors = $errors;

			if ( $redirect ) {
				header("Location: ".$redirect);
				exit();
			}
		}
	}

	/* Pushes ONE error onto the errors array in session. ($_SESSION['errors'])
	/* @param $errors - String [Required] - A string to push onto the errors array.
	/* @param $redirect - String [Optional] - Redirect to this page or leave blank to
									 		  not redirect at all. ex. login.php
	/*********************************************************/	
	public function setSessionError($error, $redirect=false) {
		// Check to make sure this is in fact an array and is not empty
		if ( !empty($error) ) {
			$this->errors[] = $error;

			if ( $redirect ) {
				header("Location: ".$redirect);
				exit();
			}
		}
	}


	/* Print out all errors in $_SESSION['errors'] each on it's own line
	/* @param $unsetAll - Boolean [Optional] - True if you want to unset all of the errors
											   when you're done printing them. False otherwise.
	/*********************************************************/	
	public function displaySessionErrors($unsetAll=true) {
		foreach ( $this->errors as $err ) {
			print $err.'<br />';
		}

		if ( $unsetAll ) $this->unsetAllErrors();;
	}

	/* Unset all errors stored in the session
	/*********************************************************/	
	public function unsetAllErrors() {
		unset($this->session['errors']);
	}

	/* Do we have any errors set?
	/* @return Boolean - True if there are errors, false otherwise.
	/*********************************************************/	
	public function hasErrors() {
		if ( !empty($this->errors) ) return true;

		return false;
	}

}

?>