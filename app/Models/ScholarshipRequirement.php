<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipRequirement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scholarship_id',
        // 'requirement_type_id',
        'attachment',
    ];

    /**
     * Get the scholarship that owns the scholarship requirement.
     */
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    /*
     * Get the requirement type that owns the scholarship requirement.
     */
    // public function requirementType()
    // {
    //     return $this->belongsTo(RequirementType::class);
    // }
}
