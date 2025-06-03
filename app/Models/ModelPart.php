<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ModelPart extends Model
{
    use HasFactory;

    protected $table = 'model_part';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'model_id',
        'part_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelPart) {
            if (empty($modelPart->id)) {
                $modelPart->id = (string) Str::uuid();
            }
        });
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_id');
    }
}
