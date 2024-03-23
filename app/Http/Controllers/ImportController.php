<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use App\Models\User;
use App\Imports\ImportExcel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function index()
    {
        $d['forms'] = DB::table('forms')->whereNull('forms.deleted_at')->get();

        return view('import-page', $d);
    }

    public function importData(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $arrPenghasilan = array('1 - 5 Juta' => 'a. 1 - 5 juta','5 - 10 Juta' => 'b. 5 - 10 juta','10 - 20 Juta' => 'c. 10 - 20 juta','20 - 50 Juta' => 'd. 20 - 50 juta','> 50 Juta' => 'e. > 50 juta',);
        $arrWa = array('Sudah' => 'a. sudah','Belum' => 'b. belum','Sudah tapi hanya Whatsapp biasa' => 'c. sudah tapi hanya whatsapp biasa',);

        try {
            DB::beginTransaction();
            if ($extension == 'xlsx' || $extension == 'xls') {
                $spreadsheet = IOFactory::load($file);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                // dd($worksheet);
                $headers = array_shift($rows);

                foreach ($rows as $row) {
                    if ($row[2] == null) {
                        continue;
                    }
                    $date = date('Y-m-d H:i:s', strtotime($row[1]));
                    // dd($date);
                    if ($row[67] == "LEADER" ) {
                        $level = 4;
                    }elseif ($row[67] == 'ADOPTER') {
                        $level = 3;
                    }
                    elseif ($row[67] == 'OBSERVER') {
                        $level = 2;
                    }
                    elseif ($row[67] == 'BEGINNER') {
                        $level = 1;
                    }elseif ($row[67] == 'NOVICE') {
                        $level = 5;
                    }else{
                        $level = 0;
                    }
                    $cekUser = DB::table('users')->where('email', $row[5])->first();
                    if ($cekUser == null) {
                        $id_user = DB::table('users')->insertGetId([
                            'name' => $row[2],
                            'no_wa' => $row[12],
                            'email' => $row[5],
                            'profil' => 1,
                            'aktif' => 1,
                            'final_level' => $level,
                            'created_at' => $date,
                            'password' => bcrypt('password'),
                        ]);
                    }else{
                        $cekSubmission = DB::table('form_submissions')->where('id_user', $cekUser->id)->first();
                        DB::table('users')->where('id', $cekUser->id)
                        ->update(['final_level' => $level]);
                        if($cekSubmission == null){
                        }else{
                            continue;
                        }
                        $id_user = $cekUser->id;
                    }

                    $cekProfil = DB::table('profil_user')->where('id_user', $id_user)->first();

                    if ($cekProfil == null) {
                        $cekProv = DB::table('m_provinsi')->where('nama_provinsi','LIKE','%'.$row[6].'%')->first();
                        $dataProfil = [
                            'id_user' => $id_user,
                            'nama_pemilik' => $row[2],
                            'id_provinsi' => ($cekProv->id_provinsi ?? 0),
                            'nama_provinsi' => $row[6],
                            'id_kabupaten' => 0,
                            'nama_kabupaten' => $row[7],
                            'id_kecamatan' => 0,
                            'nama_kecamatan' => $row[8],
                            'id_keluarahan' => 0,
                            'nama_kelurahan' => $row[9],
                            'alamat_lengkap' => $row[10],
                            'nama_usaha' => $row[4],
                            'email_usaha' => $row[5],
                            'no_telp' => $row[11],
                            'no_hp' => $row[12],
                            'jenis_kelamin' => $row[3],
                            'nik' => $row[13],
                            'nib' => $row[14],
                            'created_at' => $date,
                            'updated_at' => null,
                        ];
                        DB::table('profil_user')->insert($dataProfil);
                    }

                    // Form Array Data Submission
                    $arrayData = json_encode($this->array_data($row, $arrPenghasilan, $arrWa));
                    // dd($arrayData);

                    DB::table('form_submissions')->insert([
                        'id_user' => $id_user,
                        'form_id' => $request->id_form,
                        'data' => ($arrayData ?? '{}'),
                        'savedSession' => 0,
                        'import' => 1,
                        'created_at' => $date,
                        'updated_at' => null,
                    ]);

                }
            } else {
                DB::rollBack();
                return back()->with('error', 'Invalid file format.');
            }
            // dd('sukses');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }

        return redirect('umkm-verif');
    }

    function array_data($row, $arrPenghasilan, $arrWa){
        // Cek jika memilih makanan
        $trigMakanan = ($row[15] == 'Makanan' ? true : false);
        $trigMinuman = ($row[15] == 'Minuman' ? true : false);
        $trigPakaian = ($row[15] == 'Pakaian' ? true : false);
        $trigKerajinanKulit = ($row[15] == 'Kerajinan Kulit' ? true : false);
        $trigKerajinanTangan = ($row[15] == 'Kerajinan Tangan' ? true : false);

        // kondisi memasukkan inputan pilihan dari atas
        $produkMakanan = ($trigMakanan == true ? $row[16] : null);
        $produkMinuman = ($trigMinuman == true ? $row[16] : null);
        $produkPakaian = ($trigPakaian == true ? $row[16] : null);
        $produkKerajinanKulit = ($trigKerajinanKulit == true ? $row[16] : null);
        $produkKerajinanTangan = ($trigKerajinanTangan == true ? $row[16] : null);

        $pendapatan = ($row[17] != '' ? $arrPenghasilan[$row[17]] : null);
        $urlWebsite = ($row[23] == 'Ya' ? $row[24] : null);

        $checkFacebook = (str_contains($row[26], 'Facebook') ? true : false);
        $checkInstagram = (str_contains($row[26], 'Instagram') ? true : false);
        $checkTiktok = (str_contains($row[26], 'Tiktok') ? true : false);
        $checkSnackVideo = (str_contains($row[26], 'Snack Video') ? true : false);

        $checkTokopedia = (str_contains($row[29], 'Tokopedia') ? true : false);
        $checkShoope = (str_contains($row[29], 'Shoope') ? true : false);
        $checkBukalapak = (str_contains($row[29], 'Bukalapak') ? true : false);
        $checkLazada = (str_contains($row[29], 'Lazada') ? true : false);
        $checkBlibli = (str_contains($row[29], 'Blibli') ? true : false);

        $checkQRIS = (str_contains($row[33], 'QRIS') ? true : false);
        $checkOvo = (str_contains($row[33], 'OVO') ? true : false);
        $checkGopay = (str_contains($row[33], 'GOPAY') ? true : false);
        $checkLinkAja = (str_contains($row[33], 'LINK AJA') ? true : false);
        $checkDana = (str_contains($row[33], 'DANA') ? true : false);

        $checkMoka = (str_contains($row[40], 'Moka POS') ? true : false);
        $checkMajoo = (str_contains($row[40], 'Majoo') ? true : false);
        $checkPawonPos = (str_contains($row[40], 'Pawoon POS') ? true : false);
        $checkQasir = (str_contains($row[40], 'Qasir') ? true : false);
        $checkMySooltan = (str_contains($row[40], 'My Sooltan') ? true : false);
        $checkSooltanKasir = (str_contains($row[40], 'Sooltan Kasir') ? true : false);
        $checkPOSLainnya = (str_contains($row[40], 'POS Sistem lainnya') ? true : false);
        $checkKasirPintar = (str_contains($row[40], 'Kasir Pintar') ? true : false);

        $checkAI = (str_contains($row[47], 'Artificial Intelligence') ? true : false);
        $checkBigData = (str_contains($row[47], 'Big Data') ? true : false);
        $checkCloudCompute = (str_contains($row[47], 'Cloud Computing') ? true : false);
        $checkVR = (str_contains($row[47], 'Virtual Reality') ? true : false);
        $checkAR = (str_contains($row[47], 'Augmented Reality') ? true : false);
        $check3D = (str_contains($row[47], '3D Printing') ? true : false);
        $checkRobotic = (str_contains($row[47], 'Robotic') ? true : false);

        $checkGofood = (str_contains($row[57], 'Go Food') ? true : false);
        $checkGrabFood = (str_contains($row[57], 'Grab Food') ? true : false);
        $checkShoopeFood = (str_contains($row[57], 'Shoope Food') ? true : false);

        $data = array(
            "cc8e0137-5a07-4873-bc54-77e53c7a0b91" => $trigMakanan,
            "4cf9b09f-ec8a-4fd7-a608-3eaa98a58e41" => $produkMakanan,
            "7c991113-f761-40c1-9673-3a9164d46852" => $trigMinuman,
            "d250293f-14f1-4a24-a895-e2b4ebb46fbe" => $produkMinuman,
            "0d78540f-14c4-4878-9576-77f2a6e3c532" => $trigPakaian,
            "11a70372-6c0e-412e-a4f4-348fb39394e9" => $produkPakaian,
            "da8ee909-8bff-49d9-9514-361713220b18" => $trigKerajinanKulit,
            "7c585f42-2306-4b03-bcfc-7bfe2b0e6532" => $produkKerajinanKulit,
            "cec6436e-431e-4f82-a3bb-11a6af141484" => $trigKerajinanTangan,
            "ef549b93-e1fb-4d54-be5a-7564a58386d6" => $produkKerajinanTangan,
            "2edce79e-0944-4427-a820-552b8764527b" => $pendapatan,
            "2a59d9d0-7ed7-4263-8003-b4c2285cb007" => $row[18],
            "2ff63fcf-6648-45d8-82af-790dc263cc54" => $row[19],
            "86fd1876-8903-4378-b1ad-8ccf9840a802" => $row[20],
            "1a60b8d5-5335-4c75-832f-35bd6b1f42da" => $row[21],
            "4f8e2914-4468-4fff-9741-8ae8744f8e25" => $arrWa[$row[22]],
            "6d7cc3ee-0833-4706-a121-89080d5d778f" => ($row[23] == 'Ya' ? 'a. Iya' : 'b. tidak'),
            "da94d901-77d7-44c8-b42f-be0b3d4438bb" => $urlWebsite,
            "3d35aa20-4505-451b-95f7-ae5a1f4bc742" => ($row[25] == 'Sudah' ? 'a. Sudah' : 'b. Belum'),
            "8285d9a0-e209-4bf4-a858-21c942efc67d" => $checkFacebook,
            "2e5b96c6-efdc-4c1a-a427-f9562d1e255c" => ($checkFacebook == true ? $row[27] : null),
            "c2a98326-3f8f-48f5-8ec3-a4043267ee17" => ($checkFacebook == true ? $row[53] : null),
            "21f77341-fa46-45d9-bac6-1a04d3cf3764" => $checkInstagram,
            "7c040781-8ffb-474b-8c9f-640521284851" => ($checkInstagram == true ? $row[27] : null),
            "2e2ec935-3d35-4611-9274-8ed1c21259ea" => ($checkInstagram == true ? $row[53] : null),
            "bc329487-d123-4f53-ac72-e2c343422ff1" => $checkTiktok,
            "97a0d3e9-3882-4f95-9feb-8dbf31b50dda" => ($checkTiktok == true ? $row[27] : null),
            "1f0d220a-91dd-4b72-a6e0-19ca5fce24b5" => ($checkTiktok == true ? $row[53] : null),
            "f02eebeb-d578-4c39-a383-984e33dceea7" => $checkSnackVideo,
            "f51cb2ad-11e4-4aba-b1a3-68103ab02642" => ($checkSnackVideo == true ? $row[27] : null),
            "e16adb70-a404-45b3-9358-c5eaebaed7b9" => ($checkSnackVideo == true ? $row[53] : null),
            "480579d2-c1b8-407b-81a3-bd9365ad9d95" => false,
            "e202d492-56c4-452c-876b-f0c6526134ff" => null,
            "4c602cfe-a10d-437c-b044-a6f433019e1b" => null,
            "0612b4c3-fa71-4882-9afd-bf4c83d447fa" => ($row[28] == 'Sudah' ? 'a. sudah' : 'b. belum'),
            "52747ee5-a58c-4eef-ba80-747b19fd454f" => $checkTokopedia,
            "6db871b1-91f3-471f-84d3-2ec0fd399cab" => ($checkTokopedia == true ? $row[30] : null),
            "e15c9565-cfd2-4482-8ca4-ceba62b8dc4e" => ($checkTokopedia == true ? $row[54] : null),
            "42514dbe-8bbb-4300-8d4a-ccb1e69c5e97" => null,
            "7e7d93fe-f890-4912-b5f7-8cec9aeb07f9" => $checkShoope,
            "a7ddf7b5-dc49-4c6d-8ffd-0719278d1463" => ($checkShoope == true ? $row[30] : null),
            "95d46da1-c02a-4149-b8d8-484471c4f2a7" => ($checkShoope == true ? $row[54] : null),
            "ff46de53-0e41-4b4e-aa48-40547d4a7fd5" => null,
            "43a9fd21-c843-46ab-873b-32c9e2cf07e9" => $checkBukalapak,
            "106daff7-2143-4053-a207-afec5fb52c16" => ($checkBukalapak == true ? $row[30] : null),
            "b667dde4-210b-415b-90c5-e1e23865570d" => ($checkBukalapak == true ? $row[54] : null),
            "efbda78d-b99e-459c-91a3-b301cedb022c" => null,
            "4899bd76-84fe-4d3b-b026-98369b812b16" => $checkLazada,
            "7b1a1354-01f4-429c-9252-c1e913cb6f89" => ($checkLazada == true ? $row[30] : null),
            "b9240332-959a-4cd4-8593-2e663eec21fe" => ($checkLazada == true ? $row[54] : null),
            "6e288e73-22c0-4884-95db-4e0cffbe2ff7" => null,
            "933d946d-6b6d-401f-93ce-796b7d53eefe" => $checkBlibli,
            "b91c6e86-34a3-4849-86e7-ed275bd18ce5" => ($checkBlibli == true ? $row[30] : null),
            "6628a7c1-26d4-4c4f-903c-3846e7f2ed84" => ($checkBlibli == true ? $row[54] : null),
            "a4c1f951-6b17-4f8f-9d35-decfa85541b2" => null,
            "fcf89cf1-1f61-4fe7-bc32-2242201886de" => false,
            "e5dae43a-b690-4ee5-9417-628bcab47e96" => null,
            "d3282a21-79b8-4a5a-bb22-fd323c8ca18e" => null,
            "f68f4209-251b-4b22-b3e9-4ca021765c19" => null,
            "9fd98221-0e07-4ff7-b30f-348a9bb8fc35" => $checkGofood,
            "d45541c6-b8d1-433f-80c3-530f3d60c477" => ($checkGofood == true ? $row[56] : null),
            "bd25f454-6a71-49b0-9262-dfff42f9f47d" => ($checkGofood == true ? $row[58] : null),
            "4643a601-394a-4662-8f6f-c8fef846b9c5" => ($checkGofood == true ? $row[59] : null),
            "8acf25cb-2477-462f-8468-6bf514dde2d0" => $checkShoopeFood,
            "8c1f3ad5-d90e-47c4-bff8-130d534a5032" => ($checkShoopeFood == true ? $row[56] : null),
            "5bca729d-7f06-4344-8845-708a3596043a" => ($checkShoopeFood == true ? $row[58] : null),
            "c8e0cb1d-777b-4dad-8d21-f94051ef43b0" => ($checkShoopeFood == true ? $row[59] : null),
            "d0f5410f-66e2-4a93-ae25-19f1dbd6d401" => $checkGrabFood,
            "8b14256b-5e34-4a02-9cc5-24dbe4874b80" => ($checkGrabFood == true ? $row[56] : null),
            "ddc27fc7-72a7-419d-9b88-3e09de44663f" => ($checkGrabFood == true ? $row[58] : null),
            "7c7f8de6-c4be-431e-bdb9-ec79e5475b6b" => ($checkGrabFood == true ? $row[59] : null),
            "3df62c7c-6764-4fc4-bb9f-0110dfbfd056" => ($row[31] == "Ada" ? 'a. ada' : 'b. tidak'),
            "9ee7e459-80e2-47fc-a1a1-390621804113" => ($row[32] == "Sudah" ? 'a. sudah' : 'b. belum'),
            "e54a07b2-fbf8-4001-8505-df473e3b5b03" => $checkQRIS,
            "be020e1e-89a0-4fd8-8730-a561c4f88e95" => ($checkQRIS == true ? ($row[34] != '' ? $row[34] : null) : null),
            "77558b6a-00ac-449b-9288-1264182db45b" => $checkOvo,
            "38b9b057-f979-4cad-9232-1e9bcbaf9613" => ($checkOvo == true ? ($row[34] != '' ? $row[34] : null) : null),
            "91a3427c-b0cb-4586-8ebe-5296b5f45cd7" => $checkLinkAja,
            "f1077d1b-79a0-4e29-b6f0-6d81a8c4081c" => ($checkLinkAja == true ? ($row[34] != '' ? $row[34] : null) : null),
            "aaa75bd9-3722-45aa-b43c-b2a68d2715ca" => $checkGopay,
            "bb117e19-81f8-4545-91b7-9270a02e9762" => ($checkGopay == true ? ($row[34] != '' ? $row[34] : null) : null),
            "c9f2dd23-31b7-4d3e-8216-685b891a25b2" => $checkDana,
            "d3c84004-571f-4211-9840-a9c784dfccda" => ($checkDana == true ? ($row[34] != '' ? $row[34] : null) : null),
            "0fab9dae-05cc-4d49-94a7-a13030f8e68b" => null,
            "808e905d-9c16-4352-9de2-e9975f2e482b" => null,
            "058bb895-ed78-4e20-9deb-9bb954240e6d" => ($row[35] == 'Sudah' ? 'a. sudah' : 'b. belum'),
            "05a060f2-6d82-4135-bab9-cd08ad98c729" => null,
            "363c884c-7a59-45ae-884e-5a3758ec96ea" => null,
            "5ec0c797-5fcd-4c4a-83f2-a51653a553c3" => null,
            "3ccb7072-546d-4914-b40c-ea72bbfc5186" => null,
            "ad4357b5-2ce4-496a-afa2-d0e6e0c82150" => null,
            "9a3d313c-5dc8-4370-b917-9cbf8201a5d0" => null,
            "3ce3c008-dc22-4656-913d-983042f5411a" => null,
            "39f89f05-c7d2-4412-be73-a419baf4b087" => null,
            "b44578d1-b3c7-47eb-b256-cba788681fdd" => null,
            "08fb3963-13fb-4741-b5ca-2ad0b08f475c" => null,
            "8d4cf8bf-ad34-47aa-a4f3-0015a8cdf8f8" => null,
            "7d60daf0-becf-4030-b94f-dd61587dd1d0" => null,
            "180239cc-0730-4380-a011-c7f46020ef08" => null,
            "2a0e4164-6bb3-4189-a6c5-740cd2bff9e1" => null,
            "82422c9f-c49e-4e13-b8db-66628bec10f2" => null,
            "f32d84c6-b1ab-49a0-8459-f2ea181ec8f5" => $row[60],
            "f884f363-f00d-405b-bb97-c1a8d434541c" => ($row[38] != '' ? $row[38] : null),
            "0cdaa29f-1468-4c8f-8eb4-9fb0ed19f2d8" => ($row[39] == 'Sudah' ? 'a. sudah' : 'b. belum'),
            "4a120a4b-2c1e-4b6e-bfac-d7fba575cafc" => $checkMoka,
            "98a5cac1-982d-48e2-99f5-eb38cb3269dd" => ($checkMoka == true ? $row[41] : null),
            "a906b929-21a6-471a-8055-13900abd2890" => ($checkMoka == true ? $row[61] : null),
            "0a3458c1-f37b-44f7-899d-4f8282215db4" => ($checkMoka == true ? ($row[42] != '' ? $row[42] : null) : null),
            "75ed3f3e-2ab7-48f4-89b8-bc191e231ce5" => $checkMajoo,
            "fe7fdb56-16db-4226-a0af-0f9256ac1a47" => ($checkMajoo == true ? $row[41] : null),
            "fba45369-2f54-464f-89a0-4678aa34c7ac" => ($checkMajoo == true ? $row[61] : null),
            "e41dca96-dc68-4606-ae41-0727e81e0459" => ($checkMajoo == true ? ($row[42] != '' ? $row[42] : null) : null),
            "4e168472-fb29-455e-ab0a-c8ad2b25aaea" => $checkPawonPos,
            "c964e723-68e4-4709-9b59-f50b01e0210a" => ($checkPawonPos == true ? $row[41] : null),
            "75b6c035-5845-4afc-9faa-4dbeb0d0c2a3" => ($checkPawonPos == true ? $row[61] : null),
            "08cb9918-9b99-48f3-b792-8b57a7d39e82" => ($checkPawonPos == true ? ($row[42] != '' ? $row[42] : null) : null),
            "8761aab7-9e9b-42bf-ba2b-25d3addb617d" => $checkKasirPintar,
            "07f803c5-783f-4450-8364-4340e606d98d" => ($checkKasirPintar == true ? $row[41] : null),
            "ae3eacaf-846f-4ddf-8ead-d6aa74db4267" => ($checkKasirPintar == true ? $row[61] : null),
            "1751e783-e185-490a-b0c9-17fa8f9069d1" => ($checkKasirPintar == true ? ($row[42] != '' ? $row[42] : null) : null),
            "dfd54654-30d7-431b-a7e0-23f9a2c1bacf" => $checkQasir,
            "28e983a2-56a0-4171-836e-ceaa0d39608c" => ($checkQasir == true ? $row[41] : null),
            "e31ae58b-22f6-4f32-84e6-7e45d33d9ddf" => ($checkQasir == true ? $row[61] : null),
            "9ee19c49-c69e-4f16-921e-36beecf09bef" => ($checkQasir == true ? ($row[42] != '' ? $row[42] : null) : null),
            "ae626a05-059c-49e1-972e-7aa130d11c3e" => $checkMySooltan,
            "7e16b669-fe94-47e6-8d88-236cb86ed83b" => ($checkMySooltan == true ? $row[41] : null),
            "77184ede-8aaf-4af9-8a0e-145dcc478538" => ($checkMySooltan == true ? $row[61] : null),
            "911a2b50-ebe1-4fa4-a4bd-0e7752e4737f" => ($checkMySooltan == true ? ($row[42] != '' ? $row[42] : null) : null),
            "a00d7198-eb31-4f57-8b4f-a8f71070b813" => $checkSooltanKasir,
            "73b00f2b-3d82-4645-adce-46f256a326dc" => ($checkSooltanKasir == true ? $row[41] : null),
            "d989e6c4-0a49-44e5-b295-73c86f2b1f58" => ($checkSooltanKasir == true ? $row[61] : null),
            "384a0331-7616-4874-89e8-800e4d769326" => ($checkSooltanKasir == true ? ($row[42] != '' ? $row[42] : null) : null),
            "b177d915-d4d9-44f9-9980-645cf8879eb7" => $checkPOSLainnya,
            "1fe9581e-6cc3-4946-91fd-26e85e753821" => ($checkPOSLainnya == true ? $row[41] : null),
            "91317962-cd99-42ff-b771-dffeb3603efa" => ($checkPOSLainnya == true ? $row[41] : null),
            "6cdb6837-a978-4f73-9161-342cb6a0bce4" => ($checkPOSLainnya == true ? $row[61] : null),
            "5255e083-405b-442c-b574-471374d00abb" => ($checkPOSLainnya == true ? ($row[42] != '' ? $row[42] : null) : null),
            "62dee761-f2b7-464a-8a46-ba09b95406f8" => ($row[43] == 'Sudah' ? 'a. sudah' : 'b. belum'),
            "065aabf2-703c-4f3a-901f-4b131c865fca" => $row[63],
            "b5d26f02-1548-4c71-a8ce-adea51e1041f" => ($row[45] != '' ? $row[45] : null),
            "3f0956df-f591-4356-901b-b75cac205a74" => ($row[46] == 'Sudah' ? 'a. sudah' : 'b. belum'),
            "63992413-37db-4601-824f-307d970b94c7" => $checkAI,
            "daaf2c4f-1ae8-49bc-ad13-b26175214598" => ($checkAI == true ? $row[48] : null),
            "343d8493-f772-47d7-9e1d-6242177a7965" => $checkBigData,
            "1780c927-9f30-46ac-8a51-01c296270349" => ($checkBigData == true ? $row[48] : null),
            "a8efbb4d-8ecd-4b3e-9de1-3ba88285658d" => $checkCloudCompute,
            "072fca75-b3ef-465c-a386-48c9cb4b880a" => ($checkCloudCompute == true ? $row[48] : null),
            "c797f9c8-3efb-4867-a980-d9cd7616ccec" => $checkVR,
            "5872b07e-8b6f-42e4-8645-2a79878771f2" => ($checkVR == true ? $row[48] : null),
            "a7bee191-ec67-4525-bf37-a06db211b832" => $checkAR,
            "8119005a-b1e4-4060-a37d-517e6393ef39" => ($checkAR == true ? $row[48] : null),
            "0802f87a-ceba-4c55-bf89-5eabdbb47586" => $check3D,
            "dd24f49e-7400-4329-9711-e69be32378cc" => ($check3D == true ? $row[48] : null),
            "6c424697-004a-482c-9d33-ecd7102101fa" => $checkRobotic,
            "c10985f7-3d47-4145-81c4-d94bdce23010" => ($checkRobotic == true ? $row[48] : null),
            "8faab822-07eb-468b-a089-03250d157018" => ($row[49] == 'Ya' ? 'a. Iya' : 'b. tidak'),
            "078a2553-a80f-4757-a0d5-07b66aef8aca" => $row[62],
            "02d594aa-a872-4f56-b44f-74f62639d744" => ($row[50] == 'Bersedia' ? 'a. bersedia' : 'b. tidak bersedia'),
            "1faaeb76-077a-43ad-9f4b-b8b2d28363cc" => ($row[51] == '(✓)' ? true : false),
            "fd3948c7-0659-43d8-9254-9f349e0afdd6" => ($row[52] == '(✓)' ? true : false)
        );
        return $data;
    }

    public function import_penerima_sertifikat(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('file');

        // Process the Excel file
        Excel::import(new ImportExcel, $file);

        return redirect('management-sertifikat');
    }
}
