<!-- HISTORIAL -->
@extends('layouts.app')
@push('styles')
<!-- Bootstrap -->
<link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Font Awesome -->
<link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

<!-- NProgress -->
<link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">

<!-- iCheck -->
<link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

<!-- bootstrap-wysiwyg -->
<link href="{{ asset('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">

<!-- Select2 -->
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">

<!-- Switchery -->
<link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">

<!-- starrr -->
<link href="{{ asset('vendors/starrr/dist/starrr.css') }}" rel="stylesheet">

<!-- bootstrap-daterangepicker -->
<link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

<!-- Dropzone.js -->
<link href="{{ asset('vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">

<!-- Custom Theme Style -->
<link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
@endpush
@section('content')

          <div class="">
            <div class="page-title">

              <div class="title_right">
                
              </div>
            </div>

            <div class="clearfix"></div>
              
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                      <div>
                        <div class="x_title">
                          <h2>HISTORIAL</h2>
                          
                          <div class="clearfix"></div>
                        </div>
                        <ul class="list-unstyled top_profiles scroll-view">
    @forelse($estudiante->postulaciones as $postulacion)
        <li class="media event">
            <a class="pull-left border-aero profile_thumb">
                <i class="fa fa-check aero"></i>
            </a>

            <a href="#" class="btn btn-app pull-right border-green">
                <i class="fa fa-print"></i> Imprimir
            </a>

            <div class="media-body">
                <a class="title" href="#">
                    {{ $postulacion->titulo_proyecto }}
                </a>

                <p>
                    {{ $estudiante->carreraFacultad->carrera ?? 'Sin carrera registrada' }}
                </p>

                <p>
                    <small>
                        {{ \Carbon\Carbon::parse($postulacion->fecha)->format('Y') }}
                    </small>
                </p>
            </div>
        </li>
    @empty
        <li class="media event">
            <div class="media-body">
                <p>No tiene postulaciones registradas.</p>
            </div>
        </li>
    @endforelse
</ul>
                      </div>
                    </div>
                
              </div>

              
            </div>
          </div>



@endsection


@push('scripts')
@endpush