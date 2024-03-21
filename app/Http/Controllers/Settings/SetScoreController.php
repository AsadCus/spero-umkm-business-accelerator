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
        $d['forms'] =  $this->form->whereNull('deleted_at')->where(function ($q) {
            $q->orWhereDoesntHave('score')->orWhereHas('score', function ($q) {
                $q->where('status', 0);
            });
        })->get();

        return view('score.index-set', $d);
    }

    public function store(Request $request)
    {
        DB::table('scores')->insert([
            'form_id' => $request->form_id,
            'max_score' => $request->max_score,
            'created_at' => date("Y-m-d")
        ]);

        return redirect('kuesioner-skor');
    }

    public function show($id = null)
    {
        $score = $this->score->find($id);
        if ($id == null || $score == null) {
            return view('pages.error-404');
        }

        // limit score
        foreach ($score->propertyScores as $keyPropertyScores => $listPropertyScores) {
            $dataLogic[] = json_decode($listPropertyScores->logic);
        }

        $dataScore = [];
        foreach ($dataLogic as $keyLogic => $listLogic) {
            if (count($listLogic) > 1) {
                $dataListScore = [];
                foreach ($listLogic as $listLL) {
                    $dataListScore[] = $listLL->score;
                }
                $dataScore[] = $dataListScore;
            } else {
                $dataScore[] = $listLogic[0]->score;
            }
        }

        foreach ($dataScore as &$i) {
            if (is_array($i)) {
                $i = max($i);
            }
        }
        unset($i);

        $d['score'] = [
            'sum' => array_sum($dataScore),
            'limit' => $score->max_score
        ];
        $d['dataForm'] = DB::table('forms')->where('id', $score->form_id)->first();
        $dataPropertyScore = $this->propertyScore->where('score_id', $id)->pluck('property_id')->toArray();
        $d['dataPropertyScore'] = $this->propertyScore->where('score_id', $id)->get();
        $d['dataPropertyScore']->map(function ($q) {
            $q->logic = json_decode($q->logic);
            return $q;
        });
        $d['dataJson'] = json_decode($d['dataForm']->properties, true);

        foreach ($d['dataJson'] as $key => $value) {
            if (in_array($value['id'], $dataPropertyScore)) {
                unset($d['dataJson'][$key]);
            }
        }

        return view('score.properties', $d);
    }

    public function update(Request $request, $id)
    {
        $score =  $this->score->find($id);
        $score->update([
            'max_score' => $request->max_score
        ]);

        return redirect('kuesioner-skor');
    }

    public function delete($id = null)
    {
        if ($id == null) {
            return view('pages.error-404');
        }

        DB::table('scores')->where('id', $id)->where('status', 1)
            ->update([
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return redirect('kuesioner-skor');
    }

    // propertyscore
    public function storeScoreLogic(request $request)
    {
        $dataJson = json_decode($request->forms, true);
        $key = array_search($request->input, array_column($dataJson, 'id'));
        $defaultLogic = json_encode([]);
        $form = $this->form->find($request->id);

        $propertyScore = $this->propertyScore->create([
            'name' => $dataJson[$key]['name'],
            'type' => $dataJson[$key]['type'],
            'score_id' => $form->score->id,
            'property_id' => $request->input,
            'logic' => $defaultLogic,
        ]);

        $logic = json_decode(DB::table('property_scores')->where('id', $propertyScore->id)->first()->logic, true);

        foreach ($request->score as $keyScore => $listScore) {
            if ($dataJson[$key]['type'] == 'select') {
                $logic[$keyScore]['name'] = $dataJson[$key]['select']['options'][$keyScore]['name'];
            }
            $logic[$keyScore]['parameter'] = $request->parameter;
            if ($listScore != '' || $listScore != null) {
                $logic[$keyScore]['score'] = $listScore;
            } else {
                $logic[$keyScore]['score'] = '0';
            }
        }

        $logic = json_encode($logic);
        $storeLogic = $this->propertyScore->find($propertyScore->id);
        $storeLogic->logic = $logic;
        $storeLogic->save();

        return redirect()->back();
    }

    public function updateScoreLogic(request $request)
    {
        $propertyScore = $this->propertyScore->find($request->id);
        $form = $this->form->find($propertyScore->score->form_id);
        $dataJson = $form->properties;
        $key = array_search($propertyScore->property_id, array_column($dataJson, 'id'));

        $propertyScore->logic = json_encode([]);
        $propertyScore->save();
        $logic = json_decode($propertyScore->logic, true);

        foreach ($request->score as $keyScore => $listScore) {
            if ($dataJson[$key]['type'] == 'select') {
                $logic[$keyScore]['name'] = $dataJson[$key]['select']['options'][$keyScore]['name'];
            }
            $logic[$keyScore]['parameter'] = $request->parameter;
            if ($listScore != '' || $listScore != null) {
                $logic[$keyScore]['score'] = $listScore;
            } else {
                $logic[$keyScore]['score'] = '0';
            }
        }

        $logic = json_encode($logic);
        $propertyScore->logic = $logic;
        $propertyScore->save();

        return redirect()->back();
    }

    public function editScoreLogic($id = null)
    {
        $data = $this->propertyScore->where('id', $id)->first();
        $data->logic = json_decode($data->logic);

        return response()->json(['message' => 'success', 'data' => $data], 200);
    }

    public function deleteScoreLogic($id = null)
    {
        if ($id == null) {
            return view('pages.error-404');
        }

        $data = $this->propertyScore->find($id);
        $data->delete();

        return redirect()->back();
    }
}
