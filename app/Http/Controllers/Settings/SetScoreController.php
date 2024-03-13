<?php

namespace App\Http\Controllers\Settings;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Forms\Form;
use App\Models\PropertyScore;
use App\Models\Score;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SetScoreController extends Controller
{
    use AuthenticatesUsers;

    public function __construct(Form $form, Score $score, PropertyScore $propertyScore)
    {
        $this->score = $score;
        $this->form = $form;
        $this->propertyScore = $propertyScore;
    }

    public function index()
    {
        $d['data'] =  $this->score->where('status', 1)->get();
        $d['forms'] =  $this->form->whereNull('deleted_at')->whereDoesntHave('score')->get();

        return view('score.index-set', $d);
    }

    public function store(Request $request)
    {
        DB::table('scores')->insert([
            'form_id' => $request->form_id,
            'max_score' => $request->max_score,
            'created_at' => date("Y-m-d")
        ]);

        return redirect('set-score');
    }

    public function show($id = null)
    {
        if ($id == null) {
            return view('404');
        }

        $d['dataForm'] = DB::table('forms')->where('id', $id)->first();
        $d['dataPropertyScore'] = $this->propertyScore->where('score_id', $d['dataForm']->id)->get();
        $d['dataJson'] = json_decode($d['dataForm']->properties, true);

        return view('score.properties', $d);
    }

    public function addLogic(request $request)
    {
        // dd($request);
        $logic = json_decode(DB::table('m_logic_level')->where('id', $request->id)->first()->logic, true);
        $count = count($logic);
        $data_json = json_decode($request->forms, true);
        $key = array_search($request->input, array_column($data_json, 'id'));
        $logic[$count]['input_id'] = $request->input;
        $logic[$count]['name'] = $data_json[$key]['name'] . ' [' . $data_json[$key]['type'] . ']';
        $logic[$count]['parameter'] = $request->parameter;
        if ($request->valueParam != '') {
            $logic[$count]['val-param'] = $request->valueParam;
        }

        $logic = json_encode($logic);

        DB::table('m_logic_level')->where('id', $request->id)
            ->update([
                'logic' => $logic
            ]);
        return redirect('set-logic/' . $request->id);
    }

    // public function edit($id = null)
    // {
    //     if ($id == null) {
    //         return view('404');
    //     }

    //     $d['data'] =  $this->score->find($id);

    //     return view('score.edit-set', $d);
    // }

    public function update(Request $request, $id)
    {
        $score =  $this->score->find($id);
        $score->update([
            'max_score' => $request->max_score
        ]);

        return redirect('set-score');
    }

    public function delete($id = null)
    {
        dd($id);
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
