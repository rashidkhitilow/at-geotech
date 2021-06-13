<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function autocomplete(Request $req) {
        // if (!Auth::user()->can(Position::$PERMISSION_NAME.'-view')) return response(['result' => 'fail','message' => 'Permission denied'], 401);
        $term = $req->input('term')??'';
        $page = $req->page??1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        $term = $req->input('term')??'';
        if($term != '') {
            $a = Position::where('title', 'like', '%'.$term.'%');
            return $a
                    ->offset($offset)
                    ->limit($per_page)
                    ->get()
                    ->map(function ($item){
                                return [
                                            'label' => $item->title,
                                            'text' => $item->title,
                                            'value' => $item->title,
                                            'id' => $item->id
                                    ];
                            });
        } else {
            return [];
        }
    }
}
