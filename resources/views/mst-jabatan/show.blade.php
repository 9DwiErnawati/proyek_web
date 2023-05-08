@extends('adminlte::page')  
@section('title', 'Master Tabel Jabatan') 

@section('content_header') 
    <nav aria-label="breadcrumb">   
        <ol class="breadcrumb">     
            <li class="breadcrumb-item"><a href="/home">Home</a></li>     
            <li class="breadcrumb-item"><a href="/mst-jabatan">Master Tabel Jabatan</a></li>     
            <li class="breadcrumb-item active" aria-current="page">Lihat Detail</li>   
        </ol> 
    </nav> 
@stop 
@section('content') 
    <section class="content container-fluid">   
        <div class="row">     
            <div class="col-md-12">       
                <div class="card">         
                    <div class="card-header">           
                        <div class="float-left">             
                            <span class="card-title">              
                                <h3>Lihat Detail Jabatan</h3>
                            </span>           
                        </div>           
                        <div class="float-right">             
                            <a class="btn btn-primary"               
                                href="{{ route('mst-jabatan.edit',$mstJabatan->id) }}">
                            Ubah</a>           
                        </div>         
                    </div>         
                <div class="card-body">           
                    <table class="table table-borderless">             
                        <tr>               
                            <td><strong>Nama Jabatan</strong></td>               
                            <td>{{ $mstJabatan->nama_jabatan }}</td>             
                        </tr>             
                        <tr>               
                            <td><strong>Tunjangan</strong></td>               
                            <td>{{ $mstJabatan->tunjangan }}</td>             
                        </tr>           
                    </table>         
                </div>       
                </div>     
            </div>   
        </div> 
</section> 
@endsection