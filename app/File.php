<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Model
{
    protected $fillable = ['name', 'path', 'url'];
    protected $file_dir = 'uploads';
    protected $file;
    protected $filename;


    public static function createFromForm(Request $request)
    {
    	$file = new File([
    		'name' => $request->name
    	]);

        $file->file = $request->file('file');

    	$file->setFileName()
    	     ->setPath()
    	     ->setUrl();

    	if($file->save()) {
    	    $file->file->move($file->file_dir, $file->filename);
            return $file;
    	}
    }

    public function createMovies()
    {
        $csv = Reader::createFromPath($this->url);
        $results = $csv->setOffset(1)->setLimit(10)->fetchAssoc(["Movie", "Year", "Watched"]);
        $movies = iterator_to_array($results, false);

        foreach ($movies as $movie) {
            Movie::create([
                'name' => $movie['Movie'],
                'year' => $movie['Year'],
                'watched' => $movie['Watched']
            ]);
        }
    }

    protected function setFileName()
    {
        $filename = sha1( time() . $this->file->getClientOriginalName() );
        $ext = $this->file->getClientOriginalExtension();
    	$this->filename = "{$filename}.{$ext}";
        return $this;
    }

    protected function setPath()
    {
    	$this->path = "public/{$this->file_dir}/{$this->filename}";
        return $this;
    }

    protected function setUrl()
    {
    	$this->url = "{$this->file_dir}/{$this->filename}";
        return $this;
    }
}
