<?php 

namespace App;

use App\Application;
use Carbon\Carbon;

class ApplicationFormatter 
{
	public static function createFromArray($array)
	{
		$app = new Application();

		if ($array[1] == "") {
			return false;
		} 

		if (strlen($array[1]) <= 10) {
			$array[1] = Carbon::createFromFormat('d/m/Y', $array[1]);
		} else {
			$array[1] = Carbon::parse($array[1]);
		}

		$app->submitted_on          = $array[1];
		$app->first_name            = ucwords($array[2]);
		$app->last_name             = ucwords($array[3]);
		$app->email                 = $array[4];
		$app->company               = ucwords($array[5]);
		$app->website               = $array[6];
		$app->link_1                = ($array[7] == "Add another related link") ? "" : $array[7];
		$app->link_2                = ($array[8] == "Add another related link") ? "" : $array[8];
		$app->desks                 = $array[9];
		$app->discipline            = $array[10];
		$app->membership_type       = $array[11];
		$app->text_pitch            = $array[12];
		$app->text_tech             = $array[13];
		$app->text_team             = $array[14];
		$app->additional_message    = $array[15];
		$app->funding_stage         = $array[16];
		$app->new_lab_resources     = str_replace(",", ", ", $array[17]);
		$app->text_community        = $array[18];

		return $app;
	}

}