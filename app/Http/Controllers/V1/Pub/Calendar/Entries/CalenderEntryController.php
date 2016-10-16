<?php

namespace App\Http\Controllers\V1\Pub\Calendar\Entries;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CalenderEntry;
use App\Http\Controllers\Controller;

class CalenderEntryController extends Controller
{
	public function index(Request $request)
    {
        // When no input parameter (either per get param or header) is given, default date is today
        $timestampDefault = Carbon::now();

        // Get's timestamp from url like ?timestamp=2016-10-11
        $timestamp = $request->input('timestamp', $timestampDefault);

        // Get's timestamp from header
        $timestamp = $request->header('timestamp', $timestamp);

        // Filter all entries by given date
        $dateFilter = Carbon::parse($timestamp);

        $changed = CalenderEntry::withTrashed()
            ->whereDate('updated_at', '=', $dateFilter)
            ->whereNull('deleted_at');

        $deleted = CalenderEntry::withTrashed()
            ->whereDate('updated_at', '=', $dateFilter)
            ->whereNotNull('deleted_at');

        $data = [
            'timestamp' => $dateFilter,
            'entries' => [
                'changed' => $changed->get(),
                'deleted' => $deleted->get(),
            ],
        ];

        if (env('APP_DEBUG')) {
            $data = array_merge([
                'debug' => [
                    'changed' => $changed->toSql(),
                    'deleted' => $deleted->toSql(),
                ]
            ], $data);
        }

        return response()->json($data ,  200);
	}
}
