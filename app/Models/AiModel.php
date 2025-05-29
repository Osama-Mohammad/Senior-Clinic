<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiModel extends Model
{
        protected $table = 'ai_models';
    protected $fillable = ['name', 'description', 'image'];
    public function predictions()
    {
        return $this->hasMany(Ai::class); // optional, if you want reverse relation
    }
}
