<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/3/2018
 * Time: 12:10 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Visitors
 * @package App\Models
 */
class Visitors extends Model
{
    /**
     * @var string
     */
    protected $table = 'visitors';

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Countries::class, 'country_id', 'entity_id');
    }
}