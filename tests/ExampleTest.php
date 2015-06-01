<?php

use App\User;

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testRoot()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->getStatusCode());
	}

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testCAP()
	{
		$response = $this->call('GET', '/cap/search?query=34100');

    	$this->assertResponseOk();
		$this->assertEquals('[{"id":"34100","full_name":"34100 - TRIESTE"}]', $response->getContent());
    }
}
