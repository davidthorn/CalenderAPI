<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreCalenderEntry;
use App\Models\CalenderEntry;
use Carbon\Carbon;
//use Symfony\Component\HttpKernel\Exception\HttpException;

class EntryController extends Controller
{


    
	public function entries( Request $request ){
		return $this->returnEntries( $request);
	}


	public function create( StoreCalenderEntry $request ){
		$data = array_merge($request->all(), [
			'deleted' => false
		]);

        $entry = CalenderEntry::create($data);
		return response()->json($entry, 201);
	}



	public function entry( $id ){
		$entry = CalenderEntry::findOrFail( $id );
		if( $entry ){
			return response()->json( $entry , 200 );
		}


		return response()->json( null , 404 );
	}


	public function update( Request $request ){
		$entry = CalenderEntry::find($request->input('id'));

		if( !$entry ){
			return $this->notfound();
		}

		$entry->update( $request->all() );
		$entry->save();
		return $entry;
	}

	public function delete( Request $request){

		$entry = CalenderEntry::findOrFail($request->input('id'));

		if( !$entry ){
			return $this->notfound();
		}

		$entry->deleted = true;
$entry->update();

		if ($entry->save()){
			return response()->json(200);
		}
		else{
			return response()->json(200);
		}

	}

	private function returnEntries( Request $request  ){
		$whereCondition = Carbon::parse($request->header('timestamp'));

		$entries = CalenderEntry::where( "updated_at" , ">=" ,  $whereCondition );
		$deleted_scope = CalenderEntry::where( "updated_at" , ">=" ,  $whereCondition ); ;

		$result = [
			"timestamp" => Carbon::now(),	 
			"entries" => [ 
				"changed" => $entries->where("deleted" , false )->get(), 
				"deleted" => $deleted_scope->where("deleted" , true )->get() 
			],
		];

		return response()->json($result ,  200);
	}
}