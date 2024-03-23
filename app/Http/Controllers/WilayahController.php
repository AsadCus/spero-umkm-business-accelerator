<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WilayahController extends Controller
{
    public function list_provinsi()
    {
        if (request()->ajax()) {
            $data = DB::table('m_provinsi')
                ->where('aktif', 1)
                ->select('*')
                ->get();


            return DataTables::of($data)->make(true);
        }
        return view('wilayah.provinsi.list');
    }

    public function form_input_provinsi()
    {
        return view('wilayah.provinsi.tambah');
    }

    public function add_provinsi(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_provinsi'                  => 'required',
            ],
            [
                'nama_provinsi' => 'Nama Provinsi harus diisi!',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();
            $alertMessage = $messages->first();

            // Tampilkan pesan error
            return redirect()->back()->with('success', [
                'type' => 'error',
                'message' => $alertMessage,
            ]);
        }
        try {
            DB::beginTransaction();
            DB::table('m_provinsi')->insert([
                'nama_provinsi' => $request->nama_provinsi,
                'kode' => '-'
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/provinsi')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diTambahkan',
        ]);
    }
    public function form_edit_provinsi($id)
    {
        $data = DB::table('m_provinsi')
            ->where('aktif', 1)
            ->where('id_provinsi', $id)
            ->select('*')
            ->first();
        return view('wilayah.provinsi.edit', compact('data'));
    }

    public function update_provinsi(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            DB::table('m_provinsi')->where(['id_provinsi' => $id])->update([
                'nama_provinsi' => $request->nama_provinsi
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/provinsi')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diUpdate',
        ]);
    }

    public function delete_provinsi($id)
    {
        try {
            DB::beginTransaction();
            $data = DB::table('m_provinsi')
                ->where('aktif', 1)
                ->where('id_provinsi', $id)
                ->update([
                    'aktif' => 0
                ]);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/provinsi')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diHapus',
        ]);
    }

    public function list_kabupaten()
    {
        if (request()->ajax()) {
            $data = DB::table('m_kabupaten')
                ->where('aktif', 1)
                ->select('*')
                ->get();


            return DataTables::of($data)->make(true);
        }
        return view('wilayah.kabupaten.list');
    }

    public function form_input_kabupaten()
    {
        $data = DB::table('m_provinsi')
            ->where('aktif', 1)
            ->get();
        return view('wilayah.kabupaten.tambah', compact('data'));
    }

    public function add_kabupaten(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kabupaten'                  => 'required',
                'id_provinsi'                  => 'required',
            ],
            [
                'nama_kabupaten' => 'Nama kabupaten harus diisi!',
                'id_provinsi' => 'Nama provinsi harus diisi!',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();
            $alertMessage = $messages->first();

            // Tampilkan pesan error
            return redirect()->back()->with('success', [
                'type' => 'error',
                'message' => $alertMessage,
            ]);
        }
        try {
            DB::beginTransaction();
            DB::table('m_kabupaten')->insert([
                'nama_kabupaten' => $request->nama_kabupaten,
                'id_provinsi' => $request->id_provinsi,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kabupaten')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diTambahkan',
        ]);
    }
    public function form_edit_kabupaten($id)
    {
        $data = DB::table('m_kabupaten')
            ->where('aktif', 1)
            ->where('id_kabupaten', $id)
            ->select('*')
            ->first();

        $provinsi = DB::table('m_provinsi')
            ->where('aktif', 1)
            ->select('*')
            ->get();
        return view('wilayah.kabupaten.edit', compact('data', 'provinsi'));
    }

    public function update_kabupaten(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            DB::table('m_kabupaten')->where(['id_kabupaten' => $id])->update([
                'nama_kabupaten' => $request->nama_kabupaten,
                'id_provinsi' => $request->id_provinsi
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kabupaten')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diUpdate',
        ]);
    }

    public function delete_kabupaten($id)
    {
        try {
            DB::beginTransaction();
            $data = DB::table('m_kabupaten')
                ->where('aktif', 1)
                ->where('id_kabupaten', $id)
                ->update([
                    'aktif' => 0
                ]);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kabupaten')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diHapus',
        ]);
    }

    public function list_kecamatan()
    {
        if (request()->ajax()) {
            $data = DB::table('m_kecamatan')
                ->where('aktif', 1)
                ->select('*')
                ->get();


            return DataTables::of($data)->make(true);
        }
        return view('wilayah.kecamatan.list');
    }

    public function form_input_kecamatan()
    {
        $data = DB::table('m_provinsi')
            ->where('aktif', 1)
            ->get();
        return view('wilayah.kecamatan.tambah', compact('data'));
    }

    public function add_kecamatan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kecamatan' => 'required',
                'id_kabupaten' => 'required',
            ],
            [
                'nama_kecamatan' => 'Nama kecamatan harus diisi!',
                'id_kabupaten' => 'Nama kabupaten harus diisi!',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();
            $alertMessage = $messages->first();

            // Tampilkan pesan error
            return redirect()->back()->with('success', [
                'type' => 'error',
                'message' => $alertMessage,
            ]);
        }
        try {
            DB::beginTransaction();
            DB::table('m_kecamatan')->insert([
                'nama_kecamatan' => $request->nama_kecamatan,
                'id_kabupaten' => $request->id_kabupaten,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kecamatan')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diTambahkan',
        ]);
    }
    public function form_edit_kecamatan($id)
    {
        $data = DB::table('m_kecamatan')
            ->where('aktif', 1)
            ->where('id_kecamatan', $id)
            ->select('*')
            ->first();

        $kabupaten = DB::table('m_kabupaten')
            ->where('aktif', 1)
            ->select('*')
            ->get();
        return view('wilayah.kecamatan.edit', compact('data', 'kabupaten'));
    }

    public function update_kecamatan(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            DB::table('m_kecamatan')->where(['id_kecamatan' => $id])->update([
                'nama_kecamatan' => $request->nama_kecamatan,
                'id_kabupaten' => $request->id_kabupaten
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kecamatan')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diUpdate',
        ]);
    }

    public function delete_kecamatan($id)
    {
        try {
            DB::beginTransaction();
            $data = DB::table('m_kecamatan')
                ->where('aktif', 1)
                ->where('id_kecamatan', $id)
                ->update([
                    'aktif' => 0
                ]);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kecamatan')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diHapus',
        ]);
    }
    public function get_kabupaten_by_provinsi($id)
    {
        $data = DB::table('m_kabupaten')
            ->select('*')
            ->where('id_provinsi', $id)
            ->where('aktif', 1)
            ->get();
        return response()->json($data);
    }
    public function get_kecamatan_by_kabupaten($id)
    {
        $data = DB::table('m_kecamatan')
            ->select('*')
            ->where('id_kabupaten', $id)
            ->where('aktif', 1)
            ->get();
        return response()->json($data);
    }

    public function list_kelurahan()
    {
        if (request()->ajax()) {
            $data = DB::table('m_kelurahan')
                ->where('aktif', 1)
                ->select('*')
                ->get();


            return DataTables::of($data)->make(true);
        }
        return view('wilayah.kelurahan.list');
    }

    public function form_input_kelurahan()
    {
        $data = DB::table('m_provinsi')
            ->where('aktif', 1)
            ->get();
        return view('wilayah.kelurahan.tambah', compact('data'));
    }

    public function add_kelurahan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kelurahan' => 'required',
                'id_kecamatan' => 'required',
            ],
            [
                'nama_kelurahan' => 'Nama kelurahan harus diisi!',
                'id_kecamatan' => 'Nama kecamatan harus diisi!',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();
            $alertMessage = $messages->first();

            // Tampilkan pesan error
            return redirect()->back()->with('success', [
                'type' => 'error',
                'message' => $alertMessage,
            ]);
        }
        try {
            DB::beginTransaction();
            DB::table('m_kelurahan')->insert([
                'nama_kelurahan' => $request->nama_kelurahan,
                'id_kecamatan' => $request->id_kecamatan,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kelurahan')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diTambahkan',
        ]);
    }
    public function form_edit_kelurahan($id)
    {
        $data = DB::table('m_kelurahan')
            ->where('aktif', 1)
            ->where('id_kelurahan', $id)
            ->select('*')
            ->first();

        $kecamatan = DB::table('m_kecamatan')
            ->where('aktif', 1)
            ->select('*')
            ->get();
        return view('wilayah.kelurahan.edit', compact('data', 'kecamatan'));
    }

    public function update_kelurahan(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            DB::table('m_kelurahan')->where(['id_kelurahan' => $id])->update([
                'nama_kelurahan' => $request->nama_kelurahan,
                'id_kecamatan' => $request->id_kecamatan
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kelurahan')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diUpdate',
        ]);
    }

    public function delete_kelurahan($id)
    {
        try {
            DB::beginTransaction();
            $data = DB::table('m_kelurahan')
                ->where('aktif', 1)
                ->where('id_kelurahan', $id)
                ->update([
                    'aktif' => 0
                ]);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            //throw $th;
        }

        return redirect('/kelurahan')->with('success', [
            'type' => 'success',
            'message' => 'Data berhasil diHapus',
        ]);
    }
}
