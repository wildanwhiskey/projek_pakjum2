@extends('templates.index')

@section('content')
@php $isEdit = isset($castItem); @endphp
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('admin.casts.index') }}">Kelola Cast</a></li>
      <li class="active">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
    </ol>
  </div>

  <div style="max-width: 600px;">
    <h3>{{ $isEdit ? 'Edit Cast' : 'Tambah Cast' }}</h3>

    @if ($errors->any())
      <div style="color: red;">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ $isEdit ? route('admin.casts.update', $castItem->id) : route('admin.casts.store') }}" method="post">
      @csrf
      @if ($isEdit)
        @method('PUT')
      @endif

      <p>
        <label>Nama</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $castItem->name ?? '') }}" required>
      </p>
      <p>
        <label>Umur</label>
        <input type="number" name="age" class="form-control"
               value="{{ old('age', $castItem->age ?? '') }}" required>
      </p>
      <p>
        <label>Bio</label>
        <textarea name="bio" class="form-control" rows="4" required>{{ old('bio', $castItem->bio ?? '') }}</textarea>
      </p>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.casts.index') }}" class="btn btn-default">Batal</a>
    </form>
  </div>
</div>
@endsection