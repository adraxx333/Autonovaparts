<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'models';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'brand',
        'year_start',
        'year_end',
        'description',
    ];

    protected $casts = [
        'year_start' => 'integer',
        'year_end' => 'integer',
    ];

    // Relación con partes
    public function parts()
    {
        return $this->belongsToMany(Part::class, 'model_part', 'model_id', 'part_id')
            ->withTimestamps();
    }

    // Generar slug automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
