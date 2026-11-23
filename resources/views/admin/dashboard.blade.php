@extends('templates.index')

@section('content')
<div class="container">
  <br>
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li class="active">Admin</li>
    </ol>
  </div>

  <h3 style="margin-bottom: 25px;">Dashboard Admin</h3>

  <div class="row">
    <div class="col-sm-4" style="margin-bottom: 20px;">
      <a href="{{ route('admin.users.index') }}" class="thumbnail" style="padding: 20px; color: #333; text-decoration: none;">
        <h4>Data User</h4>
        <p style="font-size: 28px; margin-bottom: 5px;">{{ $counts['users'] }}</p>
        <span class="text-muted">Kelola data user</span>
      </a>
    </div>
    <div class="col-sm-4" style="margin-bottom: 20px;">
      <a href="{{ route('admin.genres.index') }}" class="thumbnail" style="padding: 20px; color: #333; text-decoration: none;">
        <h4>Genre</h4>
        <p style="font-size: 28px; margin-bottom: 5px;">{{ $counts['genres'] }}</p>
        <span class="text-muted">Kelola genre film</span>
      </a>
    </div>
    <div class="col-sm-4" style="margin-bottom: 20px;">
      <a href="{{ route('admin.films.index') }}" class="thumbnail" style="padding: 20px; color: #333; text-decoration: none;">
        <h4>Film</h4>
        <p style="font-size: 28px; margin-bottom: 5px;">{{ $counts['films'] }}</p>
        <span class="text-muted">Kelola daftar film</span>
      </a>
    </div>
    <div class="col-sm-4" style="margin-bottom: 20px;">
      <a href="{{ route('admin.casts.index') }}" class="thumbnail" style="padding: 20px; color: #333; text-decoration: none;">
        <h4>Cast</h4>
        <p style="font-size: 28px; margin-bottom: 5px;">{{ $counts['casts'] }}</p>
        <span class="text-muted">Kelola data cast</span>
      </a>
    </div>
    <div class="col-sm-4" style="margin-bottom: 20px;">
      <a href="{{ route('admin.perans.index') }}" class="thumbnail" style="padding: 20px; color: #333; text-decoration: none;">
        <h4>Peran</h4>
        <p style="font-size: 28px; margin-bottom: 5px;">{{ $counts['perans'] }}</p>
        <span class="text-muted">Kelola peran film</span>
      </a>
    </div>
  </div>
</div>
@endsection
