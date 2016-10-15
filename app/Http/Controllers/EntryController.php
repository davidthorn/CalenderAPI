<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreCalenderEntry;
use App\Http\Requests\UpdateCalenderEntry;
use App\Models\CalenderEntry;
use Carbon\Carbon;

class EntryController extends Controller
{
	public function index(Request $request)
    {
		return $this->returnEntries($request);
	}

    public function show($id)
    {
        $entry = CalenderEntry::findOrFail($id);

        return response()->json($entry , 200);
    }

	public function create(StoreCalenderEntry $request)
    {
		$data = array_merge($request->all(), [
			'deleted' => false
		]);

        $entry = CalenderEntry::create($data);

		return response()->json($entry, 201);
	}

	public function update($id, UpdateCalenderEntry $request)
    {
		$entry = CalenderEntry::findOrFail($id);

		$entry->update($request->all());

		return $entry;
	}

	public function delete($id)
    {
		$entry = CalenderEntry::findOrFail($id);

		$entry->deleted = true;
        $entry->save();

        return response()->json(200);
	}

	private function returnEntries(Request $request)
    {
		$whereCondition = Carbon::parse($request->header('timestamp'));

		$entries = CalenderEntry::where('updated_at', '>=', $whereCondition);

		$result = [
			'timestamp' => Carbon::now(),	 
			'entries' => [ 
				'changed' => $entries->where('deleted' , false)->get(), 
				'deleted' => $entries->where('deleted' , true)->get() 
			],
		];

		return response()->json($result ,  200);
	}
}
