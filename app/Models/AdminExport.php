<?php

namespace App\Models;

use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminExport extends Export
{
    use HasFactory;

    protected $table = 'exports';

    public function user(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
