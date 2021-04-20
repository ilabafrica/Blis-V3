<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AdhocConfig extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'adhoc_configs';

    protected $fillable = ['name', 'option'];

    public $timestamps = false;

    public function configOptions()
    {
        return $this->hasMany('App\Models\ConfigOption');
    }

    public function getReportTemplate()
    {
        return AdhocConfig::where('name','Report')->first()->option;
    }

    public static function getULINFormat()
    {
        return AdhocConfig::where('name','ULIN')->first()->option;
    }

    public static function getConfigs()
    {
        $adhocConfigs = AdhocConfig::all();
        $configsArray = [];
        foreach ($adhocConfigs as $key => $values) {
            $configsArray[$values->name] = $values->option;
        }
        return (object) $configsArray;
    }
}
