<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'type',
        'photo',
        'created_by',
        'updated_by',
    ];

    /**
     * Get all of the announcement's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
