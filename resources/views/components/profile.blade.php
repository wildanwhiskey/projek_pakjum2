@extends('templates.index')

@section('content')
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li class="active">Profile</li>
    </ol>
  </div>

  <div class="all-comments-info" style="max-width: 600px; margin: 20px auto;">
    <h3>Profile Saya</h3>

    @if (session('success'))
      <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
      <div style="color: red;">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <div class="agile-info-wthree-box">
      <form action="{{ route('profile.update') }}" method="post">
        @csrf
        @method('PUT')
        <input type="text" name="name" placeholder="Nama" value="{{ old('name', $user->name) }}" required>
        <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required>
        <input type="number" name="umur" placeholder="Umur" value="{{ old('umur', $user->profile->umur) }}" required>
        <input type="text" name="alamat" placeholder="Alamat" value="{{ old('alamat', $user->profile->alamat) }}" required>
        <textarea name="bio" placeholder="Bio" required>{{ old('bio', $user->profile->bio) }}</textarea>
        <input type="submit" value="SIMPAN">
        <div class="clearfix"> </div>
      </form>
    </div>
  </div>
</div>
@endsection