<?php

class FlyErrorTest extends PHPUnit_Framework_TestCase {

	/**
	 * Instantiate a new FlyError object
	 */
	public function setUp()
	{
		$this->fly = new FlyError;
	}

	/**
	 * Test that our errors array is indeed an array
	 */
	public function testArray()
	{
		$this->assertInternalType( 'array', $this->fly->all() );
	}

	/**
	 * Test pushing a single error onto the stack
	 */
	public function testPushSingle()
	{
		$error = 'Failed to validate username!';
		$this->fly->push( $error );

		$this->assertEquals( $error, $this->fly->get() );
		$this->fly->clear(); // Clear errors for next test
	}

	/**
	 * Test pushing an array of errors onto the stack
	 */
	public function testPushMultiple()
	{
		$errors = array(
			'Failed to validate username!',
			'Password is not long enough!',
			'A vaild email must be supplied'
		);

		$this->fly->push( $errors );

		$this->assertEquals( 3, count( $this->fly->all() ) );
	}

}