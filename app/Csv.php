<?php 

namespace App;

use League\Csv\Reader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Csv 
{
	protected $collection;

    public static function formatIntoApplications(UploadedFile $file)
    {
        $application_keys = ['name', 'email', 'company'];
        return static::fetchCols($file, $application_keys)->mapToApplications();
    }

    public static function fetchCols(UploadedFile $file, array $cols)
    {
    	$csv = new static;
        $reader = Reader::createFromPath($file);
        $csv->collection = $reader->setOffset(1)->fetchAssoc($cols);

        return $csv;
    }

    public function mapToApplications()
    {
        $collection = [];
        foreach ($this->collection as $row) {
            $collection[] = new Application($row);
        }
        
        dd($collection);
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
