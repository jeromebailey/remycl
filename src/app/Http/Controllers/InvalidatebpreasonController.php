<?php

namespace App\Http\Controllers;

use App\Models\Invalidatebpreason;
use App\Models\Invalidatebpreasonspecific;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InvalidatebpreasonController extends Controller
{
    //
    public function getInvalidateBPReasonSpecifics(Request $request)
    {
        if (! Gate::allows('get-invalidate-reason-specifics', Auth::user())) {
            abort(403);
        }

        if( empty($request) )
        {
            abort(404);
        } else {
            $_reason_id = 0;
            try{
                $_reason_row = Invalidatebpreason::where('_uid', $request->input('_reason_id'))->get();

                $_reason_id = $_reason_row[0]->id;

                $specificReasons = Invalidatebpreasonspecific::getSpecificReasonsByReasonId($_reason_id);
                //dd($_reason_row);
                return response()->json([
                    'success' => true,
                    'data' => $specificReasons
                ]);
            } catch(Exception $e)
            {
                dd($e);
            }
        }
    }
}
