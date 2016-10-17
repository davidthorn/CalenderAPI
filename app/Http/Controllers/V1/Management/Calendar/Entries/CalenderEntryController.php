<?php

namespace App\Http\Controllers\V1\Management\Calendar\Entries;

use App\Models\CalenderEntry;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalenderEntry;
use App\Http\Requests\UpdateCalenderEntry;
use App\Transformers\Management\CalenderEntryTransformer;

class CalenderEntryController extends Controller
{
    protected $transformer;

    public function __construct()
    {
        $this->transformer = new CalenderEntryTransformer;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
	public function index()
    {
        $entries = CalenderEntry::paginate();

        return api_response()
            ->with($entries)
            ->transformWith($this->transformer);
	}

    /**
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $entry = CalenderEntry::findOrFail($id);

        return api_response()
            ->with($entry)
            ->transformWith($this->transformer);
    }

    /**
     * @param \App\Http\Requests\StoreCalenderEntry $request
     * @return \Dingo\Api\Http\Response
     */
	public function store(StoreCalenderEntry $request)
    {
        $entry = CalenderEntry::create($request->all());

        return api_response()
            ->with($entry)
            ->transformWith($this->transformer);
	}

    /**
     * @param int $id
     * @param \App\Http\Requests\UpdateCalenderEntry $request
     * @return \Dingo\Api\Http\Response
     */
	public function update($id, UpdateCalenderEntry $request)
    {
		$entry = CalenderEntry::findOrFail($id);

		$entry->update($request->all());

        return api_response()
            ->with($entry)
            ->transformWith($this->transformer);
	}

    /**
     * @param int $id
     * @return \Dingo\Api\Http\Response
     */
	public function destroy($id)
    {
		$entry = CalenderEntry::findOrFail($id);
		$entry->delete();

        return api_response()->accepted();
	}
}
