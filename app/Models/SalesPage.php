<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class SalesPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'description',
        'features',
        'target_audience',
        'price',
        'unique_selling_point',
        'generated_html',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}