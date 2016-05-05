<?php 

namespace App;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CustomPaginator
{
	protected $page;
	protected $perPage;
	protected $offset;
	protected $total;
	protected $chunks;
	protected $page_items;
	protected $request;

	public function __construct(Request $request, Collection $collection)
	{
		$this->request = 		$request;
		$this->page = 			$request->input('page', 1);
		$this->perPage = 		$request->session()->get('posts_per_page');
		$this->total = 			$collection->count();
		$this->chunks = 		$collection->chunk($this->perPage);
	}

	public static function create(Request $request, Collection $collection)
	{
		$paginator = new static($request, $collection);

		if ($paginator->isOffsetPage()) {
			return false;
		}

		$paginator->page_items = $paginator->chunks[$paginator->page - 1];

	    return new LengthAwarePaginator(
	        $paginator->page_items, 
	        $paginator->total, 
	        $paginator->perPage, 
	        $paginator->page, 
	        ['path' => $paginator->request->url(), 'query' => $paginator->request->query()]
	    );
	}	

	public function isOffsetPage()
	{
	    return (! isset($this->chunks[$this->page - 1]));
	}

}