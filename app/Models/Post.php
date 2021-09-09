<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'img',
        'category_id',
        'user_id',
    ];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Store and replace image.
     *
     * @return string
     */

    public static function uploadImage (Request $request, $old_image = null)
    {
        if ($request->hasFile('img')){
            if ($old_image) {
                Storage::delete($old_image);    
            }
            $folder = date ('Y-m');
            return $request->file('img')->store("images/{$folder}");
        }
        return null;
    }

    /**
     * Get image src.
     *
     * @return string
     */
    public function getImage ()
    {
        return asset("uploads/{$this->img}");
    }
}
