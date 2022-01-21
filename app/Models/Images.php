<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'images';
    protected $fillable = array(
                            'name',
                            'image',
                            'courseid',
                            'userid',
                            'filename',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function getImageAttribute($value)
    {
        if ($value) {
            //return url(Storage::url('public/empresa' . '/' . $value));
            return base64_encode($value);
        }
        return $value;
    }
}
