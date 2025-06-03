<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Part extends Model
{
    use HasFactory;

    protected $table = 'parts';

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
        'id',
        'name',
        'code',
        'description',
        'price',
        'stock',
        'image_url',
        'category_id',
        'model_id',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relación con categoría
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con modelos
    public function models(): BelongsToMany
    {
        return $this->belongsToMany(CarModel::class, 'model_part', 'part_id', 'model_id')
            ->withTimestamps();
    }

    // Generar UUID automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($part) {
            if (empty($part->id)) {
                $part->id = (string) Str::uuid();
            }
        });
    }
}
