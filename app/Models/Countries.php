<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/3/2018
 * Time: 12:11 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Countries
 * @package App\Models
 */
class Countries extends Model
{
    /**
     * @var string
     */
    protected $table = 'countries';
    /**
     * @var array
     */
    protected $fillable = ['name'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitors()
    {
        return $this->hasMany(Visitors::class, 'country_id', 'entity_id');
    }
}