<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hous;

class FrontController extends Controller
{
  public function index()
  {
      return view('app.index')->render();

  }

  public function result(Request $request)
		{
      $houses = Hous::searchHouses($request);
      sleep(2);
      return  response()->json($houses);
		}

}
