<?php
require __DIR__ . '/../src/FlyError.php';

class FlyErrorTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		$_SESSION  = array();
		$this->fly = new FlyError;
	}

	public function testArray()
	{
		$this->assertInternalType( 'array', $this->fly->all() );
	}

	public function testPushSingle()
	{
		$error = 'Failed to validate username!';
		$this->fly->push( $error );

		$this->assertEquals( $error, $this->fly->get(0) );
	}

}