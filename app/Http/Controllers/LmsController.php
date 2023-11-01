<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserProgresMateri;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LmsController extends Controller
{
    public function index() {
        $d['forms'] = DB::table('forms')->whereNull('forms.deleted_at')->get();
        // return view('import-page', $d);
    }

    public function listKategori() {
        $d['kategori'] = DB::table('m_kategori_materi')->where('aktif', 1)->orWhere('aktif', 2)->get();
        
        return view('list-kategori-page', $d);
    }
    
    public function listMateri() {
        if (session('id_role') == 2 or session('id_role') == 3) {
            $d['materi'] = DB::table('m_materi')->where('aktif', 1)->orWhere('aktif', 2)->get();
        }else{
            $d['materi'] = DB::table('m_materi')->where('created_by', session('id_user'))->where('aktif', 1)->orWhere('aktif', 2)->get();
        }

        return view('list-materi-page', $d);
    }

    public function approve($id){
        DB::table('m_materi')->where('id', $id)->update(['aktif' => 1]);
        return redirect('list-materi');
    }
    
    public function listPengumuman() {
        $d['pengumuman'] = DB::table('notifikasis')->get();

        return view('list-pengumuman-page', $d);
    }

    public function addKategori(Request $request){
        if ($request->session()->get('id_user') == null) {
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Silahkan periksa kembali email password anda.',
            ]);
            return redirect('login');
        }
        DB::table('m_kategori_materi')->insert([
            'nama' => $request->nama,
            'created_by' => $request->session()->get('id_user'),
            'created_at' => date("Y-m-d")
        ]);
        return redirect('list-kategori-materi');
    }

    public function addMateri(Request $request){
        if ($request->session()->get('id_user') == null) {
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Silahkan periksa kembali email password anda.',
            ]);
            return redirect('login');
        }

        DB::table('m_materi')->insert([
            'nama' => $request->nama,
            'keterangan' => $request->deskripsi,
            'created_by' => $request->session()->get('id_user'),
            'created_at' => date("Y-m-d")
        ]);
        return redirect('list-materi');
    }

    public function subMateri($id, $name) {
        $d['name'] = $name;
        $d['id'] = $id;
        $d['sub_materi'] = DB::table('t_sub_materi')
        ->select('t_sub_materi.*', 't_sub_materi_file.file_location')
        ->leftJoin('t_sub_materi_file', 't_sub_materi.id', '=', 't_sub_materi_file.id_sub_materi')
        ->where('t_sub_materi.aktif', 1)
        ->where('t_sub_materi.id_materi', $id)
        ->get();

        return view('sub-materi', $d);
    }

    public function addSubMateri(Request $request, $id, $name) {
        if ($request->session()->get('id_user') == null) {
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Silahkan periksa kembali email password anda.',
            ]);
            return redirect('login');
        }
        try {
            DB::beginTransaction();
            $request->validate([
                'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ]);
            // dd($publicUrl);    
            $lastId = DB::table('t_sub_materi')->insertGetId([
                'nama' => $request->title,
                'deskripsi' => $request->deskripsi,
                'id_materi' => $id,
                'created_by' => $request->session()->get('id_user'),
                'created_at' => date("Y-m-d")
            ]);

            $file = $request->file('file');
    
            // Generate a hashed filename using the original file name and a unique identifier
            $hashedFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
    
            // Store the file in the storage/app/public directory
            $filePath = $file->storeAs('data_upload_lms', $hashedFileName, 'public');

            // Create a public URL for the file using the storage link
            $publicUrl = Storage::disk('public')->url($filePath);   

            DB::table('t_sub_materi_file')->insert([
                'id_sub_materi' => $lastId,
                'kategori_materi' => "PDF",
                'video_url' => $request->video_url,
                'file_location' => $publicUrl,
                'created_by' => $request->session()->get('id_user'),
                'created_at' => date("Y-m-d")
            ]);
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            //throw $th;
        }

        return redirect('sub-materi/'.$id.'/'.$name);
    }

    public function addPengumuman() {
        return view('list-pengumuman-page', $d);
    }

    public function deletePengumuman($id) {
        DB::table('notifikasis')->where('id', $id)->update(['final_level' => $level]);
        return view('list-pengumuman-page', $d);
    }

    public function editPengumuman($id) {
        $d['pengumumanById'] = DB::table('notifikasis')->where('id', $id)->first();
        return view('list-pengumuman-page', $d);
    }

    public function user_progres(){
        // $data = DB::table('user_progres_materis')
        // ->select(
        //     'user_progres_materis.materi_id', 
        //     'm_materi.nama', 
        //     'users.name', 
        //     'users.id', 
        //     DB::raw('COUNT(user_progres_materis.id) as jumlah_user'),
        //     DB::raw('COUNT(user_progres_materis.sub_materi_id) as jumlah_sub_materi_user'))
        // ->leftJoin('users','user_progres_materis.user_id','=','users.id')
        // ->leftJoin('m_materi','user_progres_materis.materi_id','=','m_materi.id')
        // ->groupBy('user_progres_materis.materi_id', 'm_materi.nama', 'users.name','users.id')
        // ->get();
        // $data->each(function($item){
        //     $item->total_sub_bdsarkan_materi = DB::table('t_sub_materi')->selectRaw('COUNT(id_materi) as tot')->where('id_materi', $item->materi_id)->count();
        //     $item->progres = ($item->jumlah_sub_materi_user * 100) / $item->total_sub_bdsarkan_materi;
        // });
        // dd($data);
        if (request()->ajax()) {
            $data = DB::table('user_progres_materis')
            ->select(
                'user_progres_materis.materi_id', 
                'm_materi.nama', 
                'users.name', 
                'users.id', 
                DB::raw('COUNT(user_progres_materis.id) as jumlah_user'),
                DB::raw('COUNT(user_progres_materis.sub_materi_id) as jumlah_sub_materi_user'))
            ->leftJoin('users','user_progres_materis.user_id','=','users.id')
            ->leftJoin('m_materi','user_progres_materis.materi_id','=','m_materi.id')
            ->groupBy('user_progres_materis.materi_id', 'm_materi.nama', 'users.name','users.id')
            ->get();
            $data->each(function($item){
                $item->total_sub_bdsarkan_materi = DB::table('t_sub_materi')->selectRaw('COUNT(id_materi) as tot')->where('id_materi', $item->materi_id)->count();
                $item->progres = ($item->jumlah_sub_materi_user * 100) / $item->total_sub_bdsarkan_materi;
            });
            return DataTables::of($data)->make(true);
        }
        
        return view('user-progres');
    }
    public function detail_user_progres($id, $materiid){
        // dd($id,$materiid);
        $user = User::find($id);
        $materi = DB::table('m_materi')
        ->select('nama')
        ->find($materiid);
        // dd($materi);
        if (request()->ajax()) {
            $data = DB::table('user_progres_materis')
            ->select('user_progres_materis.*','t_sub_materi.nama')
            ->leftJoin('t_sub_materi','user_progres_materis.sub_materi_id','=','t_sub_materi.id')
            ->where('user_id',$id)
            ->where('materi_id',$materiid)
            ->get();
            return DataTables::of($data)->make(true);

        }
        return view('detail-user-progres',compact('user','materi'));
    }
}
