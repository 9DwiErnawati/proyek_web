<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPangkat;
use App\Models\Pegawai;

class RiwayatPangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //variabel pecarian     
        $search = \Request::get('search');     
        $p = Pegawai::paginate(); //mangatur tampil perhalaman              
        //menjalankan query builder        
        $pegawai = \DB::table('pegawai')           
            ->join('mst_jabatan','pegawai.mst_jabatan_id','=','mst_jabatan.id')           
            ->select('pegawai.id','pegawai.nama','pegawai.alamat',                   
                    'mst_jabatan.nama_jabatan')            
            ->where('pegawai.id','LIKE','%'.$search.'%')           
            ->orwhere('pegawai.nama','LIKE','%'.$search.'%')           
            ->orWhere('pegawai.alamat','LIKE', '%'.$search.'%')            
            ->paginate($p->perPage());                   
        //memanggil view dan menyertakan hasil quey          
        return view('riwayat-pangkat.index', compact('pegawai'))             
            ->with('i', (request()->input('page', 1) - 1) * $p->perPage()); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($peg_id)
    {
        //untuk mengisi pilihan gol/pangkat     
        $pangkat=\DB::table('mst_pangkat')->pluck(              
                 \DB::raw('CONCAT(pangkat_gol," ",nama_pangkat) as nama_pangkat'),'id');               
        $rw  = new RiwayatPangkat();               
        //membaca identitas pegawai      
        $peg = Pegawai::find($peg_id);      
        return view('riwayat-pangkat.create', compact('rw','pangkat','peg')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //simpan      
        $rwp = new RiwayatPangkat;      
        $rwp->pegawai_id     =$request->pegawai_id;      
        $rwp->mst_pangkat_id =$request->mst_pangkat_id;      
        $rwp->no_sk_pangkat  =$request->no_sk_pangkat;      
        $rwp->tanggal_tmt_pangkat=$request->tanggal_tmt_pangkat;      
        $rwp->gaji_pokok     =$request->gaji_pokok;      
        $rwp->status         =$request->status;      
        $rwp->save(); //simpan            
        //baca lagi setelah penambahan      
        $rw  = RiwayatPangkat::where('pegawai_id',$request->pegawai_id)->get();      
        $peg = Pegawai::find($request->pegawai_id);      
        //tampilkan kembalai ke index1         
        return view('riwayat-pangkat.index1', compact('rw','peg')); 
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
        //cari di tabel  riwayat_pangkat yang mau diedit          
        $rw = RiwayatPangkat::find($id);                  
        //baca pegawai_id tabel riwayat_pangkat          
        $peg_id = RiwayatPangkat::where('id',$id)->first();                  
        //baca identitas pegawai 
        $peg = Pegawai::find($peg_id->pegawai_id);                  
        //baca tabel mst_pangkat untuk pilihan dropdown list         
        $pangkat=\DB::table('mst_pangkat')->pluck(                 
                 \DB::raw('CONCAT(pangkat_gol," ",nama_pangkat) as nama_pangkat'),'id');                          
        //menampikan 1 rekaman ke view edit          
        return view('riwayat-pangkat.edit', compact('rw','peg','pangkat')); 
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
        //mencari dengan kunci id        
        $rwp = RiwayatPangkat::find($id); 
 
        $rwp->pegawai_id     =$request->pegawai_id;       
        $rwp->mst_pangkat_id =$request->mst_pangkat_id;       
        $rwp->no_sk_pangkat  =$request->no_sk_pangkat;       
        $rwp->tanggal_tmt_pangkat=$request->tanggal_tmt_pangkat;       
        $rwp->gaji_pokok     =$request->gaji_pokok;       
        $rwp->status         =$request->status;       
        $rwp->save(); //simpan              
        //baca lagi riwayat_pangkat setelah diubah       
        $rw  = RiwayatPangkat::where('pegawai_id',$request->pegawai_id)->get();       
        //baca identitas pegawai       
        $peg = Pegawai::find($request->pegawai_id);              
        //kembilkan tampilkan ke daftar riwayat pangkat           
        return view('riwayat-pangkat.index1', compact('rw','peg'));   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //baca pegawai_id       
        $peg_id = RiwayatPangkat::find($id)->pegawai_id;              
        //menghapus 1 rekaman tabel pegawai       
        $rwy = RiwayatPangkat::find($id)->delete();              
        // mengembalikan tampilan ke view index (halaman sebelumnya)       
        $rw  = RiwayatPangkat::where('pegawai_id',$peg_id)->get();       
        $peg = Pegawai::find($peg_id);              
        return view('riwayat-pangkat.index1', compact('rw','peg'));     
    }

    public function proses($id)     
    {         
        //baca kepangkatan perpegawai         
        $rw=RiwayatPangkat::where('pegawai_id',$id)->get();                  
        //baca identitas pegawai         
        $peg=Pegawai::find($id);                  
        //tampilkan riwayat pangkat pegawai tertentu         
        return view('riwayat-pangkat.index1', compact('rw','peg')); 
    } 

    public function cetak($id)     
    {         
        //baca kepangkatan perpegawai         
        $rw=RiwayatPangkat::where('pegawai_id',$id)->get();                  
        //baca identitas pegawai         
        $peg=Pegawai::find($id);                  
        //tampilkan riwayat pangkat pegawai tertentu         
        return view('riwayat-pangkat.cetak', compact('rw','peg'));     
    }
}
