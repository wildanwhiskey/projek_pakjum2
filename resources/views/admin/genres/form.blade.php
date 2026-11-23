@extends('templates.index')

@section('content')
@php $isEdit = isset($genreItem); @endphp
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('admin.genres.index') }}">Kelola Genre</a></li>
      <li class="active">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
    </ol>
  </div>

  <div style="max-width: 500px;">
    <h3>{{ $isEdit ? 'Edit Genre' : 'Tambah Genre' }}</h3>

    @if ($errors->any())
      <div style="color: red;">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ $isEdit ? route('admin.genres.update', $genreItem->id) : route('admin.genres.store') }}" method="post">
      @csrf
      @if ($isEdit)
        @method('PUT')
      @endif
      <p>
        <input type="text" name="name" class="form-control" placeholder="Nama genre"
               value="{{ old('name', $genreItem->name ?? '') }}" required>
      </p>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.genres.index') }}" class="btn btn-default">Batal</a>
    </form>
  </div>
</div>
@endsection