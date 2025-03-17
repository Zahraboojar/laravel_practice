@extends('admin.master')

@section('contant_header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $title }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                {{ $breadcrumb }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection

@section('contant_main')
<section class="content">
      <div class="container-fluid">
        {{ $slot }}
      </div><!-- /.container-fluid -->
    </section>
@endsection