@extends('adminlte::page') 
@section('title', 'Master Tabel Pegawai') 
 
@section('content_header')    
    <nav aria-label="breadcrumb">    
        <ol class="breadcrumb">       
            <li class="breadcrumb-item"><a href="/home">Home</a></li>     
            <li class="breadcrumb-item active" aria-current="page">Master Tabel Pegawai</li>    
        </ol>    
    </nav> 
@stop 
 
@section('content')     
    <div class="container-fluid">         
        <div class="row">             
            <div class="col-sm-12">                 
                <div class="card">                     
                    <div class="card-header">                         
                        <div style="display: flex; justify-content: spacebetween;align-items: center;"> 
 
                            <span id="card_title">                                 
                                <h3>Master Tabel Pegawai</h3> 
                            </span> 
 
                                <div class="float-right">                                  
                                    @include('pegawai.search', ['url'=>'pegawai','link'=> 'pegawai'])                                    
                                </div>                         
                        </div>                     
                    </div>                     
                    @if ($message = Session::get('success'))                         
                        <div class="alert alert-success">                             
                            <p>{{ $message }}</p>                         
                        </div>                     
                    @endif 

                    <div class="card-body">                         
                        <div class="table-responsive">                             
                            <table class="table table-striped table-hover">                                 
                                <thead class="thead">                                     
                                    <tr>                                         
                                        <th>No</th>                                         
                                        <th>NIP</th>                                         
                                        <th>Nama</th>                                         
                                        <th>Alamat</th>                                         
                                        <th>Jabatan</th>                                         
                                        <th></th>                                     
                                    </tr>                                 
                                </thead>                                 
                                <tbody>                                     
                                    @foreach ($pegawai as $peg)                                         
                                        <tr>                                             
                                            <td>{{ ++$i }}</td>                                             
                                            <td>{{ $peg->id }}</td>                                             
                                            <td>{{ $peg->nama }}</td>                                             
                                            <td>{{ $peg->alamat }}</td>                                             
                                            <td>{{ $peg->nama_jabatan }}</td>                                             
                                            <td>                                                 
                                                <form action="{{ route( 'pegawai.destroy',$peg->id) }}" method="POST">                                                     
                                                    <a class="btn btn-sm btnprimary " 
                                                    href="{{ route('pegawai.show',$peg->id) }}">
                                                    <i class="fa fa-fw faeye"></i> Lihat</a>                                                     
                                                    <a class="btn btn-sm btnsuccess" 
                                                    href="{{ route('pegawai.edit',$peg->id) }}">
                                                    <i class="fa fa-fw faedit"></i> Ubah</a>                                                     
                                                    @csrf                                                     
                                                    @method('DELETE')                                                     
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-fw fa-trash"></i> Hapus
                                                    </button>                                                 
                                                </form>                                             
                                            </td>                                         
                                        </tr>                                     
                                    @endforeach                                 
                                </tbody>                             
                            </table>                         
                        </div> 
                    </div>                 
                </div>                 
                    {!! $pegawai->links('pagination::bootstrap-4') !!}             
            </div>         
        </div>     
    </div> 
@endsection 
 
 