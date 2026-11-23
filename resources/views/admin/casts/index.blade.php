@extends('templates.index')

@section('content')
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li class="active">Kelola Cast</li>
    </ol>
  </div>

  <h3>Kelola Cast</h3>
  <p><a href="{{ route('admin.casts.create') }}" class="btn btn-primary">+ Tambah Cast</a></p>

  <form action="{{ route('admin.casts.index') }}" method="get" class="form-inline" style="margin-bottom: 15px;">
    <div class="form-group">
      <input type="text" name="search" class="form-control" placeholder="Cari nama cast" value="{{ request('search') }}">
    </div>
    <button type="submit" class="btn btn-default">Cari</button>
    @if (request()->filled('search'))
      <a href="{{ route('admin.casts.index') }}" class="btn btn-link">Reset</a>
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
          <th>Nama</th>
          <th>Umur</th>
          <th>Bio</th>
          <th>Jumlah Peran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($castList as $item)
          <tr>
            <td>{{ $castList->firstItem() + $loop->index }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->age }}</td>
            <td>{{ \Illuminate\Support\Str::limit($item->bio, 60) }}</td>
            <td>{{ $item->perans_count }}</td>
            <td>
              <a href="{{ route('admin.casts.edit', $item->id) }}" class="btn btn-warning btn-xs">Edit</a>
              <form action="{{ route('admin.casts.destroy', $item->id) }}" method="post" style="display:inline;"
                    onsubmit="return confirm('Hapus cast {{ e($item->name) }}? Peran cast ini ikut terhapus.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6">Belum ada cast.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $castList->links() }}
</div>
@endsection