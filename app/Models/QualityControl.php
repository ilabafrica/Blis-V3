<?php
namespace App\Models;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class QualityControl extends Model
{
	/**
	 * ConrolMeasures relationship
	 */
	public function qualityControlMeasures()
	{
	  return $this->hasMany('QualityControlMeasure');
	}

	/**
	* relationship between a control and its results
	*/
	public function qualityControlTests()
	{
		return $this->hasMany('QualityControlTest');
	}

	/**
	* Relationship between control and lots
	*/
	public function lot()
	{
		return $this->belongsTo('Lot');
	}

}