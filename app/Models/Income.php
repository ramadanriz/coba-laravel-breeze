<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters) {
        $query->when($filters['search'] ?? false, function($query, $search) {
            $monthNumber = \Carbon\Carbon::parse($search)->format('m');
            return $query->whereRaw("MONTH(date) = ?", [$monthNumber]);
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
