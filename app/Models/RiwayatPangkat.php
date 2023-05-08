<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pegawai;

class RiwayatPangkat extends Model
{
    protected $table = 'riwayat_pangkat';   
    protected $primaryKey = 'id';   
    protected $fillable = ['pegawai_id','mst_pangkat_id','no_sk_pangkat','gaji_pokok','status']; 
 
 
    //relasi ke tabel Pegawai   
    public function getPegawai()   
    { 
        return $this->belongsTo('\App\Models\Pegawai','pegawai_id');        
    } 
 
    //relasi ke MstPangkat   
    public function getPangkat()  
    {     
        return $this->belongsTo('\App\Models\MstPangkat','mst_pangkat_id');      
    }      
    static function listStatus()   
    {     
        return array(0=>'Tidak berlaku',1=>'Berlaku');   
    } 
       
    //membaca pangkat terahir yang diberi status=1    
    static function pGolTerahir($id)   
    {     
        $pang = selft::where('status',1)->where('pegawai_id',$id)                                      
                                        ->orderby('created_at', 'desc')->first();     
        return $pang;   
    }
}
