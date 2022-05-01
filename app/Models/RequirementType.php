<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scholarship_type_id',
        'requirement_name',
        'description',
        'input_type', // attachment, textbox, dropdown etc.
    ];

    /**
     * Get the scholarship requirements for the requirement type.
     */
    public function requirements()
    {
        return $this->hasMany(ScholarshipRequirement::class);
    }

    /*
     * Get the scholarship type that owns the requirement type.
     */
    // public function scholarshipType()
    // {
    //     return $this->belongsTo(ScholarshipType::class);
    // }
}
