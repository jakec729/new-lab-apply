<?php 

namespace App;

use League\Csv\Reader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Csv 
{
	protected $collection;
	
    public static function fetchCols(UploadedFile $file, array $cols)
    {
    	$csv = new static;
        $reader = Reader::createFromPath($file);
        $csv->collection = $reader->setOffset(1)->fetchAssoc($cols);

        return $csv;
    }

    public function mapToMovies()
    {
    	$catalog = [];

    	foreach ($this->collection as $movie) {
    	    $catalog[] = new Movie([
    	        'name' => $movie['Movie'],
    	        'year' => $movie['Year'],
    	        'watched' => $movie['Watched']
    	    ]);
    	}

    	return collect($catalog);
    }
}
