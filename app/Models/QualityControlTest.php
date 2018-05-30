<?php
namespace App\Models;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class QualityControlTest extends Model
{
	/**
	* Relationship between control measure and its result
	*/
	public function qualityControlResults()
	{
		return $this->hasMany('QualityControlMeasureResult');
	}

	/**
	* Relationship between control test and its control
	*/
	public function qualityControl()
	{
		return $this->belongsTo('QualityControl');
	}
}