<?php

namespace App\Http\Controllers;

// memanggil model
use App\Models\MstJabatan;
use Illuminate\Http\Request;

/**************************************  
 * Class MstJabatanController  
 * @package App\Http\Controllers  
 **************************************/
class MstJabatanController extends Controller
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
        $p = MstJabatan::paginate(); //mangatur tampil perhalaman                  
        
        //menjalankan query builder         
        $mstJabatan = \DB::table('mst_jabatan')                     
                    ->where('nama_jabatan','LIKE','%'.$search.'%')                     
                    ->paginate($p->perPage());                  
                    
        //memanggil view dan menyertakan hasil quey          
        return view('mst-jabatan.index', compact('mstJabatan'))                
                ->with('i', (request()->input('page', 1) - 1) *                 
                $p->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mstJabatan = new MstJabatan();         
        return view('mst-jabatan.create', compact('mstJabatan')); 
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
        request()->validate(MstJabatan::$rules);         
        // echo  $request->nama_jabatan.$request->tunjangan;          
            //mulai transaksi           
            \DB::beginTransaction();         
        try{ 
 
            //menyimpan ke tabel mst_jabatan              
            $jabatan= new MstJabatan();           
            $jabatan->nama_jabatan=$request->nama_jabatan;           
            $jabatan->tunjangan   =$request->tunjangan;           
            $jabatan->save();      
 
            //jika tidak ada kesalahan commit/simpan            
            \DB::commit();          
        // mengembalikan tampilan ke view index (halaman sebelumnya)            
            return redirect()->route('mst-jabatan.index')                
                ->with('success', 'MstJabatan telah berhasil disimpan.'); 
 
        } catch (\Throwable $e) {               
            //jika terjadi kesalahan batalkan semua               
            \DB::rollback();              
            return redirect()->route('mst-jabatan.index')                  
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
        $mstJabatan = MstJabatan::find($id);         
        //menampikan ke view show         
        return view('mst-jabatan.show', compact('mstJabatan')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mstJabatan = MstJabatan::find($id);         
        //menampikan 1 rekaman ke view edit         
        return view('mst-jabatan.edit', compact('mstJabatan')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  MstJabatan $mstJabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate(MstJabatan::$rules);          
            //mulai transaksi         
            \DB::beginTransaction();         
        try{                        
            $jabatan= MstJabatan::find($id);           
            $jabatan->nama_jabatan=$request->nama_jabatan;           
            $jabatan->tunjangan   =$request->tunjangan;           
            $jabatan->save();      
 
            \DB::commit();         
        //mengembalikan tampilan ke view index (halaman sebelumnya)             
            return redirect()->route('mst-jabatan.index')               
                ->with('success', 'MstJabatan berhasil diubah');         
        } catch (\Throwable $e) {             
            //jika terjadi kesalahan batalkan semua              
            \DB::rollback();             
            return redirect()->route('mst-jabatan.index')                 
                ->with('success', 'MstJabatan batal diubah, ada kesalahan');         
        }     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
         //mulai transaksi          
            \DB::beginTransaction();        
        try{             
        //menghapus 1 rekaman tabel mst_jabatan             
            $mstJabatan = MstJabatan::find($id)->delete();              
            \DB::commit();           
        // mengembalikan tampilan ke view index (halaman sebelumnya)             
        return redirect()->route('mst-jabatan.index')                      
            ->with('success', 'MstJabatan berhasil dihapus');          
        } catch (\Throwable $e) {             
        //jika terjadi kesalahan batalkan semua             
            \DB::rollback();            
            return redirect()->route('mst-jabatan.index')                   
                ->with('success',   
                    'MstJabatan ada kesalahan hapus batal... ');          
        } 
    }
}
