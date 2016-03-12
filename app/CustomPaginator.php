<?php 

namespace App;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CustomPaginator
{

	public static function paginateCollection(Request $request, Collection $collection)
	{
	    $page = $request->input('page', 1); // Get the current page or default to 1, this is what you miss!
	    $perPage = session('posts_per_page');
	    $offset = ($page * $perPage) - $perPage;

	    $page_items = $collection->chunk($perPage);
	    $page_items = $page_items[$page - 1];

	    return new LengthAwarePaginator(
	        $page_items, count($collection), $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]
	    );
	}	

}