<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\MateriChat;
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
        return redirect('/list-materi')->with(['success' => 'Materi Berhasil DiPublish']);
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

    public function subMateri($name, $id) {
        $d['name'] = $name;
        $d['id'] = $id;
        $d['sub_materi'] = DB::table('t_sub_materi')
        ->select('t_sub_materi.*')
        ->where('t_sub_materi.aktif', 1)
        ->where('t_sub_materi.id_materi', $id)
        ->get();
// dd($d['sub_materi']);
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

            $lastId = DB::table('t_sub_materi')->insertGetId([
                'nama' => $request->title,
                'deskripsi' => $request->deskripsi,
                'id_materi' => $id,
                'created_by' => $request->session()->get('id_user'),
                'created_at' => date("Y-m-d")
            ]);
            if ($request->hasFile('file') && $request->hasFile('video') ) {
                $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                $request->file('file')->move(env('APP_CHILD').'/storage/data_upload_lms/', $file);
                $video = Str::random(3).time().'.'.$request->video->getClientOriginalExtension();
                $request->file('video')->move(public_path().'/storage/data_upload_lms/', $video);

                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'video_url' => env('APP_CHILD').'/storage/data_upload_lms/'.$video,
                    'file_location' => env('APP_CHILD').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'video_name' => $video,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);

            }elseif ($request->hasFile('file')) {
                $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                $request->file('file')->move(env('APP_CHILD').'storage/data_upload_lms/', $file);
                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'file_location' => env('APP_CHILD').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            }elseif ($request->hasFile('video')) {
                $video = Str::random(3).time().'.'.$request->video->getClientOriginalExtension();
                $request->file('video')->move(public_path().'/storage/data_upload_lms/', $video);
                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'video_url' => env('APP_CHILD').'/storage/data_upload_lms/'.$video,
                    'video_name' => $video,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            } else{
                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            }


          
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            throw $th;
        }

        return redirect($name.'/sub-materi/'.$id)->with(['success' => 'Data Berhasil Ditambahkan!']);
    }

    public function addPengumuman(Request $request) {
        DB::table('notifikasis')->insert([
            'judul_notifikasi' => $request->judul_notifikasi,
            'keterangan' => $request->keterangan,
            'created_by' => $request->session()->get('id_user'),
            'tanggal' => date("Y-m-d")
        ]);
        return redirect('/list-pengumuman');
    }

    public function deletePengumuman($id) {
        DB::table('notifikasis')->where('id', $id)->update(['status_aktif' => 0]);
        return redirect('/list-pengumuman');
    }

    public function editPengumuman($id) {
        $d['pengumumanById'] = DB::table('notifikasis')->where('id', $id)->first();
        return view('edit-pengumuman', $d);
    }

    public function updatePengumuman(Request $request, $id) {
        $d['pengumumanById'] = DB::table('notifikasis')->where('id', $id)->update([
            'judul_notifikasi' =>$request->judul_notifikasi,
            'keterangan' =>$request->keterangan,
        ]);
        return redirect('list-pengumuman');
    }

    public function user_progres(){
        
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
            // $data->each(function($item){
                //     $item->total_sub_bdsarkan_materi = DB::table('t_sub_materi')->selectRaw('COUNT(id_materi) as tot')->where('id_materi', $item->materi_id)->count();
                
            //     // Memeriksa apakah total_sub_bdsarkan_materi adalah nol
            //     $item->progres = ($item->jumlah_sub_materi_user * 100) / $item->total_sub_bdsarkan_materi;
            //     // if ($item->total_sub_bdsarkan_materi != 0) {
            //     // } else {
            //     //     $item->progres = 0; // Jika total_sub_bdsarkan_materi adalah nol, atur progres menjadi 0
            //     // }
            // });
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
        $all_sub_materi = DB::table('t_sub_materi')->where('id_materi',$materiid)->get();
        $materi_progres_user = DB::table('user_progres_materis')
        ->select('user_progres_materis.*','t_sub_materi.nama')
        ->leftJoin('t_sub_materi','user_progres_materis.sub_materi_id','=','t_sub_materi.id')
        ->where('user_id',$id)
        ->where('materi_id',$materiid)
        ->get();
        $sub_materi_yg_dikerjain = [];
        foreach ($materi_progres_user as $item) {
            $sub_materi_yg_dikerjain[$item->sub_materi_id] = $item->progres;
        }

        return view('detail-user-progres',compact('user','materi','all_sub_materi','sub_materi_yg_dikerjain'));
    }
    public function detail_sub_materi($id){
        $a = DB::table('t_sub_materi')->find($id);
        $data = DB::table('t_sub_materi_file')
        ->where('id_sub_materi',$id)
        ->first();
        return view('detail-sub-materi',compact('data','a'));
    }
    public function edit_sub_materi($id){
        $a = DB::table('t_sub_materi')->find($id);
        $data = DB::table('t_sub_materi_file')
        ->where('id_sub_materi',$id)
        ->first();
        // dd($a);
        return view('edit-sub-materi',compact('data','a'));
    }
    public function update_sub_materi(Request $request, $id){
        $sub_materi = DB::table('t_sub_materi')->find($id);
        $sub_materi_file = DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->first();
        
        if($request->hasFile('file') && $request->hasFile('video') ) {
            $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
            $request->file('file')->move(public_path().'/storage/data_upload_lms/', $file);

            $video = Str::random(3).time().'.'.$request->video->getClientOriginalExtension();
            $request->file('video')->move(public_path().'/storage/data_upload_lms/', $video);
                
            DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                    'video_url' => env('APP_URL').'/storage/data_upload_lms/'.$video,
                    'file_location' => env('APP_URL').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'video_name' => $video,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
        }elseif ($request->hasFile('file')) {
                $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                $request->file('file')->move(public_path().'/storage/data_upload_lms/', $file);
                DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                    'file_location' => env('APP_URL').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
        }elseif ($request->hasFile('video')) {
                $video = Str::random(3).time().'.'.$request->video->getClientOriginalExtension();
                $request->file('video')->move(public_path().'/storage/data_upload_lms/', $video);
                DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                    'video_url' => env('APP_URL').'/storage/data_upload_lms/'.$video,
                    'video_name' => $video,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
        }

       
            DB::table('t_sub_materi')->where('id',$id)->update([
                'nama' => $request->title,
                'deskripsi' => $request->deskripsi,
            ]);
            // dd($sub_materi);
            return redirect('/list-materi')->with(['success'=>'Data Berhasil Diedit!']);

    }

    public function deleteSubmateri($id){
        DB::table('t_sub_materi')->where('id',$id)->update([
            'aktif'=>0
        ]);
        DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
            'aktif'=>0
        ]);

        return redirect('/list-materi')->with(['success'=>'Data Berhasil DiHapus!']);

    }
    public function get_file_by_name(Request $request){
        dd($request->filename);
        $file = 'http://127.0.0.1:8000/storage/data_upload_lms/'. $request->filename;
        return response()->json(['file' => $file]);
    }

    public function materi_chatting(){
        if (request()->ajax()) {
            if (session('id_role') == 2 or session('id_role') == 3) {
                $data = DB::table('m_materi')->where('aktif', 1)->orWhere('aktif', 2)->get();
            }else{
                $data = DB::table('m_materi')->where('created_by', session('id_user'))->where('aktif', 1)->orWhere('aktif', 2)->get();
            }
           
            return DataTables::of($data)->make(true);
        }
        return view('materi-chatting');
    }

    public function materi_chatting_by_id($id, $nama){
        if (request()->ajax()) {
            $data = DB::table('t_sub_materi')
            ->select('t_sub_materi.*')
            ->where('t_sub_materi.aktif', 1)
            ->where('t_sub_materi.id_materi', $id)
            ->get();
           
            return DataTables::of($data)->make(true);
        }
        return view('sub-materi-chatting',compact('nama'));
    }

    public function sub_materi_chatting_by_id($id){
        $name = DB::table('t_sub_materi')
        ->select('*')
        ->where('id',$id)->first();
        $chats = DB::table('materi_chats')
        ->select('materi_chats.*','users.name','users.id')
        ->leftJoin('users','materi_chats.user_id','=','users.id')
        ->where('materi_chats.sub_materi_id',$id)
        ->get();

        return view('chatting',compact('id','chats','name'));
    }

    public function send_chatting(Request $request){
        $now = now()->setTimezone('Asia/Jakarta');

        MateriChat::create([
            'user_id' => $request->id_user,
            'sub_materi_id' => $request->sub_materi_id,
            'chat' => $request->chat,
            'tanggal' => $now,
        ]);
        return response()->json(['message'=>'success']);
    }
}
