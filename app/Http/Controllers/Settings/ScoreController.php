<?php

namespace App\Http\Controllers\Settings;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ScoreController extends Controller
{
    use AuthenticatesUsers;

    public function index()
    {
        $d['data'] =  DB::table('form_submissions')->get();

        // dd($d);

        return view('score.index', $d);
    }

    public function create(Request $request)
    {
        DB::table('scores')->insert([
            'form_id' => $request->form_id,
            'max_score' => $request->max_score,
            'created_at' => date("Y-m-d")
        ]);

        return redirect('set-score');
    }

    public function delete($id = null)
    {
        // dd($id);
        if ($id == null) {
            return view('404');
        }

        DB::table('scores')->where('id', $id)->where('status', 1)
            ->update([
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return redirect('set-score');
    }
}
