<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

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
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relación con partes
    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    // Generar slug automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->id)) {
                $category->id = (string) Str::uuid();
            }
            if (!isset($category->is_active)) {
                $category->is_active = true;
            }
        });
    }
}
