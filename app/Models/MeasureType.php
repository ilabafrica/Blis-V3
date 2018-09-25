<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs	 - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Illuminate\Database\Eloquent\Model;

class MeasureType extends Model
{
    const numeric = 1;
    const alphanumeric = 2;
    const multi_alphanumeric = 3;
    const free_text = 4;

    public $timestamps = false;

    /**
     *  Check to if the Measure Type is Numeric.
     *
     * @return bool
     */
    public function isNumeric()
    {
        return ($this->id == MeasureType::numeric) ? true : false;
    }

    /**
     *  Check to if the Measure Type is Alphanumeric.
     *
     * @return bool
     */
    public function isAlphanumeric()
    {
        return ($this->id == MeasureType::alphanumeric) ? true : false;
    }

    /**
     *  Check to if the Measure Type is Autocomplete.
     *
     * @return bool
     */
    public function isMultiAlphanumeric()
    {
        return ($this->id == MeasureType::multi_alphanumeric) ? true : false;
    }

    /**
     *  Check to if the Measure Type is Free Text.
     *
     * @return bool
     */
    public function isFreeText()
    {
        return ($this->id == MeasureType::free_text) ? true : false;
    }
}
