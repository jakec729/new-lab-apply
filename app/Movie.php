<?php

namespace App;

use App\Comment;
use App\File;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Movie extends Model
{
    protected $fillable = ['name', 'year', 'watched'];

    public static function formatMoviesFromFile(UploadedFile $file)
    {
        return Csv::fetchCols($file, ["Movie", "Year", "Watched"])->mapToMovies();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

