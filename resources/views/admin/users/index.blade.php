@extends('templates.index')

@section('content')
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li class="active">Data User</li>
    </ol>
  </div>

  <h3>Data User</h3>
  <br />

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Umur</th>
          <th>Alamat</th>
          <th>Terdaftar</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr>
            <td>{{ $users->firstItem() + $loop->index }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->name }}</td>
            <td>{{ $user->profile->umur ?? '-' }}</td>
            <td>{{ $user->profile->alamat ?? '-' }}</td>
            <td>{{ $user->created_at?->format('d M Y') }}</td>
          </tr>
        @empty
          <tr><td colspan="7">Belum ada user.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $users->links() }}
</div>
@endsection