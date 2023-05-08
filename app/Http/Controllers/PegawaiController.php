<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use File;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //variabel pencarian     
        $search = \Request::get('search');     
        $p = Pegawai::paginate(); //mangatur tampil perhalaman              
        //menjalankan query builder          
        $pegawai = \DB::table('pegawai')                 
                ->join('mst_jabatan','pegawai.mst_jabatan_id','=','mst_jabatan.id')                 
                ->select('pegawai.id','pegawai.nama','pegawai.alamat','mst_jabatan.nama_jabatan')                  
                ->where('pegawai.id','LIKE','%'.$search.'%')           
                ->orwhere('pegawai.nama','LIKE','%'.$search.'%')           
                ->orWhere('pegawai.alamat','LIKE', '%'.$search.'%')            
                ->paginate($p->perPage());                   
                //memanggil view dan menyertakan hasil query          
                return view('pegawai.index', compact('pegawai'))             
                    ->with('i', (request()->input('page', 1) - 1) * $p->perPage()); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatan=\DB::table('mst_jabatan')->pluck('nama_jabatan','id');                
        $pegawai = new Pegawai();       
        return view('pegawai.create', compact('pegawai','jabatan')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //cek validasi masukan           
        request()->validate(Pegawai::$rules);                     
        //mulai transaksi  
        \DB::beginTransaction();         
        try{           
            //menjalankan query builder untuk menyimpan ke tabel pegawai                 
            $file = $request->file('file_foto');           
            $ext = $file->getClientOriginalExtension();                   
            $fileFoto = $request->id.".".$ext;       
            //menyimpan ke folder /file           
            $request->file('file_foto')->move("foto/", $fileFoto);                      
            \DB::table('pegawai')
                ->insert(['id'=>$request->id, 'nama'=>$request->nama, 'alamat'=>$request->alamat,    
                'tanggal_lahir'=>$request->tanggal_lahir,  'jenis_kel'=>$request->jenis_kel,           
                'agama'=>$request->agama, 'telepon'=>$request->telepon, 'email'=>$request->email,           
                'file_foto'=>$fileFoto,  'mst_jabatan_id'=>$request->mst_jabatan_id,           
                'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s'),]);                                  
            //jika tidak ada kesalahan commit/simpan            
            \DB::commit();        
            // mengembalikan tampilan ke view index (halaman sebelumnya)            
            return redirect()->route('pegawai.index')                
                ->with('success', 'Pegawai telah berhasil disimpan.'); 
 
        } catch (\Throwable $e) {               
            //jika terjadi kesalahan batalkan semua               
            \DB::rollback();              
            return redirect()->route('pegawai.index')                  
                ->with('success', 'Penyimpanan dibatalkan semua, ada kesalahan...');          
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pegawai = Pegawai::find($id);         
        //menampikan ke view show         
        return view('pegawai.show', compact('pegawai')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai = Pegawai::find($id);         
        $jabatan=\DB::table('mst_jabatan')->pluck('nama_jabatan','id');         
        //menampikan 1 rekaman ke view edit         
        return view('pegawai.edit', compact('pegawai','jabatan')); 
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
        request()->validate(Pegawai::$rules);          
        //mulai transaksi         
        \DB::beginTransaction();         
        try{         
            $pegawai = \App\Models\Pegawai::find($id); 
 
            if ($request->hasFile('file_foto'))         
            {             
                $image_path = "foto/".$pegawai->file_foto;          
                if (File::exists($image_path))             
                {              
                    File::delete($image_path);            
                }                    
                    $file = $request->file('file_foto');           
                    $ext = $file->getClientOriginalExtension();          
                        $fileFoto = $id.".".$ext;           
                    $destinationPath = 'foto/';           
                    $file->move($destinationPath, $fileFoto);         
            } else {             
                $fileFoto = $pegawai->file_foto;         
            }                     
            \DB::table('pegawai')->where('id',$id)
                ->update([ 'nama'=>$request->nama, 'alamat'=>$request->alamat,           
                'jenis_kel'=>$request->jenis_kel, 'tanggal_lahir'=>$request->tanggal_lahir,            
                'agama'=>$request->agama, 'telepon'=>$request->telepon, 'email'=>$request->email,           
                'file_foto'=> $fileFoto, 'mst_jabatan_id'=>$request->mst_jabatan_id, 
                'updated_at'=>date('Y-m-d H:i:s'),]);                        
            \DB::commit();         
            //mengembalikan tampilan ke view index (halaman sebelumnya)             
            return redirect()->route('pegawai.index')               
                ->with('success', 'Pegawai berhasil diubah');         
        } catch (\Throwable $e) {             
            //jika terjadi kesalahan batalkan semua              
            \DB::rollback();             
            return redirect()->route('pegawai.index')                 
                ->with('success', 'Pegawai batal diubah, ada kesalahan');         
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //mulai transaksi          
        \DB::beginTransaction();          
        try{             
            //menghapus 1 rekaman tabel pegawai             
            $pegawai = Pegawai::find($id)->delete();              
            \DB::commit();       
            // mengembalikan tampilan ke view index (halaman sebelumnya)             
            return redirect()->route('pegawai.index')                      
                ->with('success', 'Pegawai berhasil dihapus');          
        } catch (\Throwable $e) { 
            //jika terjadi kesalahan batalkan semua             
            \DB::rollback();            
            return redirect()->route('pegawai.index')                   
                ->with('success', 'Pegawai ada kesalahan hapus batal... ');          
        }    
    }
}
