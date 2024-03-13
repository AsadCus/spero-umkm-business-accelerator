<?php

namespace App\Models;

use App\Models\Forms\Form;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'scores';

    /**
     * Relationships
     */
    public function propertyScores()
    {
        return $this->hasMany(PropertyScore::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
