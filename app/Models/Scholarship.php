<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'semester_id',
        'school_year',
        'scholarship_type_id',
        // 'gpa',
        'status',
        'organization',
        'remarks',
        'is_qualified',
        'created_by',
    ];

    /**
     * Get the scholarship requirements for the scholarship.
     */
    public function requirements()
    {
        return $this->hasMany(ScholarshipRequirement::class);
    }

    /**
     * Boot.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($scholarship) {
            $scholarship->requirements()->delete();
        });
    }
}
