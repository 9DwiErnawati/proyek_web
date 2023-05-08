<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*************************************************  
 * Nama kelas reprentasi tabel   
 * tabel mst_jabatan nama Class nya MstJabatan  
 * 
 * @property $id  
 * @property $nama_jabatan  
 * @property $tunjangan  
 * @property $created_at   
 * @property $updated_at
 * 
 * @property Pegawai[] $pegawais  
 * @package App  
 * @mixin \Illuminate\Database\Eloquent\Builder  
 *************************************************/ 

class MstJabatan extends Model
{
    // veriabel $tabel      
    protected $table = 'mst_jabatan';     
    protected $primaryKey = 'id';
    protected $guarded = ['id'];   

    static $rules = [     
    'nama_jabatan' => 'required',     
    'tunjangan' => 'required',     
    ];          
    protected $perPage = 20; 

    /*************************************************      
     * menetapkan nilai atribut/kolom/field.      
     * dari tabel mst_jabatan      
     * ke @varibel array 
         
    ************************************************/ 
        
    /**************************************************************      
     * Relasi antar object/model     
     * @return \Illuminate\Database\Eloquent\Relations\HasMany      
     **************************************************************/     
    /* public function jabatans()      
    {         
        return $this->hasMany('App\Models\Pegawai',                       
                        'mst_jabatan_id', 'id');      
    } */ 
}
