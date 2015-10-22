<?php

class MoreTestCases extends \PHPUnit_Framework_TestCase
{

/**
 * @group test
 */
  public function testThisIsRandom()
  {
	print_r("THE EXECUTOR" . getenv("EXECUTOR_NUMBER"));
	$this->assertTrue(true);
	//$this->fail('THIS IS A FAILURE');
  }	


}
