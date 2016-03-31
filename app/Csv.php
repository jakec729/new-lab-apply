<?php 

namespace App;

use App\ApplicationFormatter;
use App\ApplicationRepository;
use League\Csv\Reader;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Csv 
{
    protected $filter;
	protected $collection;
    protected $file;
    protected $columns = [
        "﻿#",
        "Date Submitted",
        "First Name",
        "Last Name",
        "Contact Email",
        "Name of Company",
        "Company Website",
        "Add another related link",
        "Add another related link",
        "No. of employees / desks needed",
        "Primary Discipline",
        "Membership Type",
        "Elevator Pitch",
        "Tell us about your Technology (150 words)",
        "Founding Team",
        "Commercialization Strategy",
        "Funding Stage",
        "Resources",
        "Community",
        "Subscribe to newsletter?",
        "Newsletter",
        "Member Application"
    ];

    public static function formatIntoApplications($file)
    {
        $csv = static::createFromUploadedFile($file);

        if (! $csv) {
            return false;
        }

        $applications = $csv->mapToApplications();
        return $applications;
    }

    public static function createFromUploadedFile($file)
    {
        $csv = new static;
        $reader = Reader::createFromPath($file);
        $columns = $reader->fetchOne();

        if (! $csv->hasCorrectColumns($columns)) {
            return false;
        }

        $rows = $reader->setOffset(1)->fetch();

        // dd(iterator_to_array($rows));

        if (empty(iterator_to_array($rows))) {
            return false;
        }

        $csv->collection = $rows;


        return $csv;
    }

    protected function hasCorrectColumns($columns) 
    {
        return (($columns[5] == $this->columns[5]) || ($columns[5] == 'company'));
    }

    public function mapToApplications()
    {
        $collection = [];


        foreach ($this->collection as $row) {
            $application = ApplicationFormatter::createFromArray($row);

            if ($application) {
                $collection[] = $application;
            }
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

    public function download()
    {
        $this->file->output($this->generateFileName());
    }

    protected function collectApps()
    {
        if ($this->filter == "shortlisted") {
            $applications = new ApplicationRepository();
            $applications = $applications->shortlistedSubs();
        } else {
            $applications = Application::with('ratings')->get();
        }

        if($applications->count() == 0) {
            return false;
        }

        return $applications;
    }

    public static function createApplicationCSV($filter = null)
    {
        $csv = Csv::setupCSV($filter);
        $applications = $csv->collectApps();

        if (! $applications) {
            return false;
        }

        $csv->insertApplications($applications);
        return $csv;
    }

}
