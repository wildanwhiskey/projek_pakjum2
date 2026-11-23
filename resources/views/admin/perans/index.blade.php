@extends('templates.index')

@section('content')
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li class="active">Kelola Peran</li>
    </ol>
  </div>

  <h3>Kelola Peran</h3>
  <p><a href="{{ route('admin.perans.create') }}" class="btn btn-primary">+ Tambah Peran</a></p>

  <form action="{{ route('admin.perans.index') }}" method="get" class="form-inline" style="margin-bottom: 15px;">
    <div class="form-group">
      <input type="text" name="search" class="form-control" placeholder="Cari film, cast, atau peran" value="{{ request('search') }}">
    </div>
    <button type="submit" class="btn btn-default">Cari</button>
    @if (request()->filled('search'))
      <a href="{{ route('admin.perans.index') }}" class="btn btn-link">Reset</a>
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
          <th>Film</th>
          <th>Cast</th>
          <th>Peran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($peranList as $item)
          <tr>
            <td>{{ $peranList->firstItem() + $loop->index }}</td>
            <td>{{ $item->film->title ?? '-' }}</td>
            <td>{{ $item->cast->name ?? '-' }}</td>
            <td>{{ $item->actor }}</td>
            <td>
              <a href="{{ route('admin.perans.edit', $item->id) }}" class="btn btn-warning btn-xs">Edit</a>
              <form action="{{ route('admin.perans.destroy', $item->id) }}" method="post" style="display:inline;"
                    onsubmit="return confirm('Hapus peran ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5">Belum ada peran.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $peranList->links() }}
</div>
@endsection