<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'answers',
        'total_yes',
        'total_no',
        'total_questions',
        'percentage',
        'passed'
    ];

    protected $casts = [
        'answers' => 'array',
        'passed' => 'boolean',
        'percentage' => 'decimal:2'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}