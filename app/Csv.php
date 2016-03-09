<?php 

namespace App;

use App\ApplicationRepository;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Csv 
{
    protected $filter;
	protected $collection;
    protected $file;

    public static function formatIntoApplications(UploadedFile $file)
    {
        $application_keys = ['name', 'email', 'company'];
        return static::fetchCols($file, $application_keys)->mapToApplications();
    }

    public static function fetchCols(UploadedFile $file, array $cols)
    {
    	$csv = new static;
        $reader = Reader::createFromPath($file);
        $csv->collection = $reader->fetchAssoc();

        return $csv;
    }

    public function mapToApplications()
    {
        $collection = [];
        foreach ($this->collection as $row) {
            $collection[] = new Application($row);
        }
        
        return collect($collection);
    }

    public static function setupCSV($filter)
    {
        $csv = new static;
        $csv->filter = $filter;
        $csv->file = Writer::createFromFileObject(new \SplTempFileObject());
        return $csv;
    }

    protected function insertApplications($applications)
    {
        // Add keys
        $keys = array_keys($applications->first()->toArray());
        $this->file->insertOne($keys);

        foreach ($applications as $application) {
            $this->file->insertOne($application->toArray());
        }
    }

    protected function generateFileName()
    {
        $filter = ($this->filter !== null) ? "-{$this->filter}" : "";
        return "New_Lab-applications{$filter}.csv";
    }

    protected function download()
    {
        $this->file->output($this->generateFileName());
    }

    protected function collectApps()
    {
        if ($this->filter == "shortlisted") {
            $applications = new ApplicationRepository();
            $applications = $applications->getAllShortlisted();
        } else {
            $applications = Application::with('ratings')->get();
        }

        return $applications;
    }

    public static function createApplicationCSV($filter = null)
    {
        $csv = Csv::setupCSV($filter);
        $applications = $csv->collectApps();
        $csv->insertApplications($applications);
        $csv->download();
    }

}
