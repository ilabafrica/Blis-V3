<?php
namespace App\Models;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class QualityControlMeasureRange extends Model
{
	public function qualityControlMeasure()
	{
		return $this->belongsTo('QualityControlMeasure');
	}

	/**
	* Get ranges in printable format
	*
	* @return string
	*/
	public function getRangeUnit()
	{
		$lower = $this->lower_range;
		$upper = $this->upper_range;
		$unit = $this->unit;

		return $lower . " - " . $upper ." ". $this->ControlMeasure->unit;
	}
}