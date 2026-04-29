<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
    ];
    protected $casts = [
        'completed_at',
        'due_date'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeSearch( $query, string $search)
    {
        return $query->where(fn($q)=>
            $q->where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
        );
    }
    public function scopeStatus( $query, string $status)
    {
        return $query->when($status && in_array($status, ['pending', 'in_progress', 'completed']),
         function ($q) use ($status) {
         $q->where('status', $status);
        });
    }

}
