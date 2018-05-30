<?php
namespace App\Models;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class QualityControlResult extends Model
{
	/**
	* Relationship between result and measure
	*
	* @return relationship
	*/
	public function qualityControlMeasures()
	{
		return $this->belongsTo('QualityControlMeasure');
	}

	/**
	* Relationship between result and test
	*
	* @return relationship
	*/
	public function QualityControlTest()
	{
		return $this->belongsTo('QualityControlTest');
	}
}