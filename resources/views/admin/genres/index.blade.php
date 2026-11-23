@extends('templates.index')

@section('content')
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li class="active">Kelola Genre</li>
    </ol>
  </div>

  <h3>Kelola Genre</h3>
  <p><a href="{{ route('admin.genres.create') }}" class="btn btn-primary">+ Tambah Genre</a></p>

  <form action="{{ route('admin.genres.index') }}" method="get" class="form-inline" style="margin-bottom: 15px;">
    <div class="form-group">
      <input type="text" name="search" class="form-control" placeholder="Cari nama genre" value="{{ request('search') }}">
    </div>
    <button type="submit" class="btn btn-default">Cari</button>
    @if (request()->filled('search'))
      <a href="{{ route('admin.genres.index') }}" class="btn btn-link">Reset</a>
    @endif
  </form>

  @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
  @endif
  @if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
  @endif

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Genre</th>
          <th>Jumlah Film</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($genreList as $item)
          <tr>
            <td>{{ $genreList->firstItem() + $loop->index }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->films_count }}</td>
            <td>
              <a href="{{ route('admin.genres.edit', $item->id) }}" class="btn btn-warning btn-xs">Edit</a>
              <form action="{{ route('admin.genres.destroy', $item->id) }}" method="post" style="display:inline;"
                    onsubmit="return confirm('Hapus genre {{ $item->name }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4">Belum ada genre.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $genreList->links() }}
</div>
@endsection