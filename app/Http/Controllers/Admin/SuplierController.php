<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder;

use App\Suplier;
use DataTables;
use Session;
use Auth;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if($request->ajax()){
            $datas = Suplier::with('kota')->get();

            return Datatables::of($datas)
            ->addColumn('umur', function($data){
                return $data->umur." Tahun";
            })
            ->addColumn('kota', function($data){
                return $data->kota->nama;
            })
            ->addColumn('action',function($data){
                return view('layouts._action',[
                    'model' =>$data,
                    'form_url' =>route('supliers.destroy',$data->id),
                    'edit_url'=>route('supliers.edit',$data->id),
                    'confirm_message'=>'Yakin mau menghapus '.$data->nama.' ?'
                ]);
            })->make(true);
        }

        $html=$htmlBuilder
            ->addColumn(['data'=>'nama','name'=>'nama','title'=>'Nama'])
            ->addColumn(['data'=>'email','name'=>'email','title'=>'E-mail'])
            ->addColumn(['data'=>'kota','name'=>'kota','title'=>'Kota'])
            ->addColumn(['data'=>'umur','name'=>'umur','title'=>'Umur'])
            ->addColumn(['data'=>'action','name'=>'action','title'=>'Action','orderable'=>false,'searchable'=>false]);

        return view('admin.suplier.index')->with(compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.suplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules      =   [ 
            'nama' => 'required|string',
            'kota_id' => 'required|exists:kotas,id',
            'tahun_kelahiran'  => 'required|alpha_num',
            'email' => 'required|email'
        ];
        
        $messages   =   [
            'required'  => 'Field :attribute harus diisi.',
            'string'    => 'Field :attribute harus berupa karakter.',
            'email'     => 'Field :attribute harus berupa e-mail',
            'tahun_kelahiran'      => 'Field :attribute harus berupa angka',
        ];

        $this->validate($request, $rules, $messages);
        
        DB::beginTransaction();

        $umur = date('Y') - $request->tahun_kelahiran;

        $data = Suplier::create(array_merge($request->all(),[
            'umur' => $umur
        ]));

        if($data->save()){
            DB::commit();

            Session::flash("flash_notification",[
                "level"=>"success",
                "message"=>$request->get('nama') . " successfully saved."
            ]);
        }else{
            DB::rollBack();

            Session::flash("flash_notification",[
                "level"=>"warning",
                "message"=>"Data failed to be saved."
            ]);
        }
        return redirect()->route('supliers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Suplier::with('kota')->findOrFail($id);
        $tahun_kelahiran = date('Y') - $data->umur;

        return view('admin.suplier.edit',compact('data','tahun_kelahiran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules      =   [ 
            'nama' => 'required|string',
            'kota_id' => 'required|exists:kotas,id',
            'tahun_kelahiran'  => 'required|alpha_num',
            'email' => 'required|email'
        ];
        
        $messages   =   [
            'required'  => 'Field :attribute harus diisi.',
            'string'    => 'Field :attribute harus berupa karakter.',
            'email'     => 'Field :attribute harus berupa e-mail',
            'tahun_kelahiran'      => 'Field :attribute harus berupa angka',
        ];

        $this->validate($request, $rules, $messages);
        
        DB::beginTransaction();

        $umur = date('Y') - $request->tahun_kelahiran;

        $data = Suplier::with('kota')->findOrFail($id);
        $data->umur = $umur;
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->kota_id = $request->kota_id;

        if($data->update()){
            DB::commit();

            Session::flash("flash_notification",[
                "level"=>"success",
                "message"=>$request->get('nama') . " successfully updated."
            ]);
        }else{
            DB::rollBack();

            Session::flash("flash_notification",[
                "level"=>"warning",
                "message"=>"Data failed to be updated."
            ]);
        }
        return redirect()->route('supliers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        $data = Suplier::findOrFail($id);

        if($data->delete()){
            DB::commit();

            Session::flash("flash_notification",[
                "level"=>"success",
                "message"=>"Data successfully deleted."
            ]);
        }else{
            DB::rollBack();

            Session::flash("flash_notification",[
                "level"=>"warning",
                "message"=>"Data failed to be deleted."
            ]);
        }
        return redirect()->route('supliers.index');
    }
}
