<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Tests\SetUp;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AntibioticSusceptibilityTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		//
	}

	public function testListAntibioticSusceptibility()
	{
		$response=$this->get('/api/antibioticsusceptibility');
		$this->assertEquals(200,$response->getStatusCode());
	}
}