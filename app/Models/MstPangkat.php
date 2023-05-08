<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/***********************  
 * Class MstPangkat  
 *
 * @property $id
 * @property $nama_pangkat
 * @property $pangkat_gol 
 * @property $created_at
 * @property $updated_at
 * 
 * @property RiwayatPangkat[] $riwayatPangkats
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 **********************/

class MstPangkat extends Model
{
    protected $table = 'mst_pangkat';     
    protected $primaryKey = 'id'; 
    protected $guarded = ['id'];
 
    static $rules = ['nama_pangkat' => 'required',                      
    'pangkat_gol' => 'required']; 
 
    protected $perPage = 10; 
 
    /**      
     * Attributes that should be mass-assignable.      
     * 
     * @var array      
     */     

    /**      
     * @return \Illuminate\Database\Eloquent\Relations\HasMany     
     */     
    /*public function riwayatPangkats()     
    {         
        return $this->hasMany('App\Models\RiwayatPangkat', 'mst_pangkat_id', 'id');     
    }*/ 
}
