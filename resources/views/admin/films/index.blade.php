@extends('templates.index')

@section('content')
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li class="active">Kelola Film</li>
    </ol>
  </div>

  <h3>Kelola Film</h3>
  <p><a href="{{ route('admin.films.create') }}" class="btn btn-primary">+ Tambah Film</a></p>

  <form action="{{ route('admin.films.index') }}" method="get" class="form-inline" style="margin-bottom: 15px;">
    <div class="form-group">
      <input type="text" name="search" class="form-control" placeholder="Cari judul film" value="{{ request('search') }}">
    </div>
    <button type="submit" class="btn btn-default">Cari</button>
    @if (request()->filled('search'))
      <a href="{{ route('admin.films.index') }}" class="btn btn-link">Reset</a>
    @endif
  </form>

  @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
  @endif

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Poster</th>
          <th>Judul</th>
          <th>Tahun</th>
          <th>Genre</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($filmList as $item)
          <tr>
            <td>{{ $filmList->firstItem() + $loop->index }}</td>
            <td><img src="{{ asset($item->poster) }}" alt="" style="height: 70px;"></td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->year }}</td>
            <td>{{ $item->genre->name ?? '-' }}</td>
            <td>
              <a href="{{ route('admin.films.edit', $item->id) }}" class="btn btn-warning btn-xs">Edit</a>
              <form action="{{ route('admin.films.destroy', $item->id) }}" method="post" style="display:inline;"
                    onsubmit="return confirm('Hapus film {{ e($item->title) }}? Komentar dan peran film ini ikut terhapus.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6">Belum ada film.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $filmList->links() }}
</div>
@endsection