@extends('layouts.facility')

@section('header')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $league->title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

@endsection

@section('content')
    <!-- About Me Box -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Bilgiler</h3>
            <div class="dropdown float-right">
                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    İşlemler
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" style="color: #000;" href="#">Düzenle</a>
                    <a class="dropdown-item" style="color: #000;" href="#" data-toggle="modal" data-target="#destroy-event-modal" data-backdrop="static" data-keyboard="false">Sil</a>
                    @if($league->is_started)
                        <a class="dropdown-item" style="color: #000;" href="#">Turnuvayı Bitir</a>
                        <a class="dropdown-item" style="color: #000;" href="{{ route('facility.league.fixture', $league->id) }}">Fikstürü Görüntüle</a>
                    @else
                        <form id="start-league-form" method="post" action="{{ route('facility.league.start', $league->id) }}">
                            @csrf
                        </form>
                        <a class="dropdown-item" style="color: #000;" href="#" onclick="document.getElementById('start-league-form').submit();">Ligi Başlat</a>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <strong><i class="fas fa-book mr-1"></i> Turnuva Tarihi</strong>

            <p class="text-muted">
                {{ $league->start_date }}
            </p>

            <hr>

            <strong><i class="fas fa-map-marker-alt mr-1"></i> Tesis</strong>

            <p class="text-muted">
                {{ $league->facility->title }}
            </p>
            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Katılım Ücreti</strong>

            <p class="text-muted">{{ $league->cost }}</p>

            <hr>

            <strong><i class="far fa-file-alt mr-1"></i> Maksimum Takım Sayısı</strong>

            <p class="text-muted">{{ $league->max_team_count }}</p>

            <hr>

            <strong><i class="far fa-file-alt mr-1"></i> Bir Takımdaki Minimum Oyuncu Sayısı</strong>

            <p class="text-muted">{{ $league->min_player_count }}</p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Başvurular</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Takım</th>
                    <th>Başvuru Tarihi</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($league->applications as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ route('facility.team.show', $item->team->id) }}">{{ $item->team->title }}</a></td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection

@section('scripts')

@endsection