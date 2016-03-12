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
        $csv->collection = $reader->setOffset(1)->fetch();

        return $csv;
    }

    public function mapToApplications()
    {
        $collection = [];

        foreach ($this->collection as $row) {

            // format_text_submission($row[13]);
            $app = new Application();

            $app->submitted_on          = $row[1];
            $app->first_name            = ucwords($row[2]);
            $app->last_name             = ucwords($row[3]);
            $app->email                 = $row[4];
            $app->company               = ucwords($row[5]);
            $app->website               = $row[6];
            $app->link_1                = ($row[7] == "Add another related link") ? "" : $row[7];
            $app->link_2                = ($row[8] == "Add another related link") ? "" : $row[8];
            $app->desks                 = $row[9];
            $app->discipline            = $row[10];
            $app->membership_type       = $row[11];
            $app->text_pitch            = $row[12];
            $app->text_tech             = $row[13];
            $app->text_team             = $row[14];
            $app->text_strategy         = $row[15];
            $app->funding_stage         = $row[16];
            $app->new_lab_resources     = str_replace(",", ", ", $row[17]);
            $app->text_community        = $row[18];

            $collection[] = $app;
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
