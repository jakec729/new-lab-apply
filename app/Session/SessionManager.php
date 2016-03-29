<?php 

namespace App\Session;

use Illuminate\Http\Request;

class SessionManager 
{
	public static function setTableFilter(Request $request)
	{
		$session_filter = $request->session()->get('tableSortBy');
		$table_filter =  ($request->has('tableSortBy')) ? $request->input('tableSortBy') : null;
		$new_column = null;
		$new_direction = 'desc';

		// If a change has been made
		if (isset($table_filter)) {

		    // If selecting same column as active column
		    if ($session_filter['column'] == $table_filter) {

		        // reverse the direction
		        $new_column = $table_filter;
		        $new_direction = ($session_filter['direction'] == 'asc') ? 'desc' : 'asc';
		    } else {
		        // Otherwise, set a new columm
		        $new_column = $table_filter;
		    }

		    $request->session()->forget('tableSortBy'); // Forget the current session value
		    $request->session()->put('tableSortBy', ['column' => $new_column, 'direction' => $new_direction]);
		}
	}
}