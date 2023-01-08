<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scholarship_type_name',
        'description',
        'max_scholars_allowed',
        'lowest_gpa_allowed',
        'highest_gpa_allowed',
        'restrictions',
    ];

    /**
     * Get the requirement types for the scholarship type.
     */
    public function requirementTypes()
    {
        return $this->hasMany(RequirementType::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($scholarshipType) { // before delete() method call this
            $scholarshipType->requirementTypes()->delete();
        });
    }
}
