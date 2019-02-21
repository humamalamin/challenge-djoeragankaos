<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder;
use App\Helper\Formating;

use App\Produk;
use DataTables;
use Session;
use Auth;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if($request->ajax()){
            $datas = Produk::with('suplier')->get();

            return Datatables::of($datas)
            ->addColumn('suplier', function($data){
                return $data->suplier->nama;
            })
            ->addColumn('status', function($data){
                if($data->status ==  1){
                    return 'Aktif';
                }else{
                    return 'Tidak Aktif';
                }
            })
            ->addColumn('harga',function($data){
                return Formating::rupiah($data->harga);
            })
            ->addColumn('image', function($data){
                return view('layouts._image',[
                    'url' => $data->image
                ]);
            })
            ->addColumn('action',function($data){
                return view('layouts._action',[
                    'model' =>$data,
                    'form_url' =>route('produks.destroy',$data->id),
                    'edit_url'=>route('produks.edit',$data->id),
                    'confirm_message'=>'Yakin mau menghapus '.$data->nama.' ?'
                ]);
            })
            ->rawColumns(['image','action'])
            ->make(true);
        }

        $html=$htmlBuilder
            ->addColumn(['data'=>'nama','name'=>'nama','title'=>'Nama'])
            ->addColumn(['data'=>'image','name'=>'image','title'=>'Image'])
            ->addColumn(['data'=>'suplier','name'=>'suplier','title'=>'Suplier'])
            ->addColumn(['data'=>'harga','name'=>'harga','title'=>'Harga Jual'])
            ->addColumn(['data'=>'status','name'=>'status','title'=>'Status'])
            ->addColumn(['data'=>'action','name'=>'action','title'=>'Action','orderable'=>false,'searchable'=>false]);

        return view('admin.produk.index')->with(compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.produk.create');
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
            'suplier_id'    => 'required|exists:supliers,id',
            'nama'          => 'required|string',
            'harga'         => 'required|alpha_num',
            'image'         => 'required|mimes:jpg,png,jpeg|max:1028',
        ];
        
        $messages   =   [
            'required'  => 'Field :attribute harus diisi.',
            'string'    => 'Field :attribute harus berupa karakter.',
            'exists'    => 'Field :attribute tidak ada di table group.',
            'mimes'     => 'Field :attribute tidak sesuai format.',
            'max'       => 'Field :attribute size maksimal 1MB',
        ];

        $this->validate($request, $rules, $messages);
        
        DB::beginTransaction();

        $status = 0;
        if(!empty($request->status)){
            $status = 1;
        }else{
            $status = 0;
        }

        $data = Produk::create(array_merge($request->all(),[
            "status"    => $status
        ]));

        $file   = $request->file('image');

        $extension  = $file->getClientOriginalExtension();
        $fileName   = md5(time()).'.'.$extension;
        $destination = public_path().DIRECTORY_SEPARATOR.'img/';
        $file->move($destination, $fileName);

        $data->image     = "/img/".$fileName;

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
        return redirect()->route('produks.index');
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
        $data = Produk::with('suplier')->findOrFail($id);

        return view('admin.produk.edit',compact('data'));
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
            'suplier_id'    => 'required|exists:supliers,id',
            'nama'          => 'required|string',
            'harga'         => 'required|alpha_num',
        ];
        
        $messages   =   [
            'required'  => 'Field :attribute harus diisi.',
            'string'    => 'Field :attribute harus berupa karakter.',
            'exists'    => 'Field :attribute tidak ada di table group.',
        ];

        $this->validate($request, $rules, $messages);
        
        DB::beginTransaction();

        $status = 0;
        if(!empty($request->status)){
            $status = 1;
        }else{
            $status = 0;
        }

        $data = Produk::findOrFail($id);
        $data->suplier_id = $request->suplier_id;
        $data->nama = $request->nama;
        $data->harga = $request->harga;
        $data->status = $status;

        if($request->hasFile('image')){
            $file   = $request->file('image');

            $extension  = $file->getClientOriginalExtension();
            $fileName   = md5(time()).'.'.$extension;
            $destination = public_path().DIRECTORY_SEPARATOR.'img/';

            if(File::exists($data->image)){
                File::delete($data->image);
            }

            $file->move($destination, $fileName);

            $data->image     = "/img/".$fileName;
        }

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
        return redirect()->route('produks.index');
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

        $data = Produk::findOrFail($id);

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
        return redirect()->route('produks.index');
    }
}
