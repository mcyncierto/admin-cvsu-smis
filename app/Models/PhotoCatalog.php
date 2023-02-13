<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoCatalog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'school_year',
        'semester_id',
    ];

    /**
     * Get all of the announcement's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get the semester associated with the photo catalog.
     */
    public function semester()
    {
        return $this->hasOne(Semester::class, 'id', 'semester_id');
    }
}
