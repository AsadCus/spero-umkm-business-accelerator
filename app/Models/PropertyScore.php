<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyScore extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'property_scores';

    /**
     * Relationships
     */
    public function score()
    {
        return $this->belongsTo(Score::class);
    }
}
