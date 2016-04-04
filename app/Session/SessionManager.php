<?php 

namespace App\Session;

use Illuminate\Http\Request;

class SessionManager 
{
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	protected function getTableFilter()
	{
		return ($this->request->has('tableSortBy')) ? $this->request->input('tableSortBy') : null;
	}

	protected function setNewFilter($filter, $value, $direction = 'desc')
	{
		$this->request->session()->forget($filter); // Forget the current session value
		$this->request->session()->put($filter, ['column' => $value, 'direction' => $direction]);
	}

	protected function onSamePage()
	{
		return ($this->request->fullUrl() == $this->request->session()->previousUrl());
	}

	protected function flipFilterDirection($session_filter, $table_filter)
	{
		$direction = ($session_filter['direction'] == 'asc') ? 'desc' : 'asc';
		return $this->setNewFilter('tableSortBy', $table_filter, $direction);
	}

	public static function setTableFilter(Request $request)
	{
		$manager = new static($request);

		$session_filter = $manager->request->session()->get('tableSortBy');
		$table_filter =  $manager->getTableFilter();

		if ($table_filter == null) {
			return false;
		}

		if ($session_filter['column'] !== $table_filter) {
			return $manager->setNewFilter('tableSortBy', $table_filter);
		} else {
			if ($manager->onSamePage()) {
				return $manager->flipFilterDirection($session_filter, $table_filter);
			}
		}
	}
}