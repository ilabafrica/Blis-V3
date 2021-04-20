<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ConfigOption extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'config_options';

    protected $fillable = ['name', 'adhoc_config_id'];

    public $timestamps = false;
}
