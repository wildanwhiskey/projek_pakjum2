@extends('templates.index')

@section('content')
@php $isEdit = isset($film); @endphp
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('admin.films.index') }}">Kelola Film</a></li>
      <li class="active">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
    </ol>
  </div>

  <div style="max-width: 600px;">
    <h3>{{ $isEdit ? 'Edit Film' : 'Tambah Film' }}</h3>

    @if ($errors->any())
      <div style="color: red;">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ $isEdit ? route('admin.films.update', $film->id) : route('admin.films.store') }}"
          method="post" enctype="multipart/form-data">
      @csrf
      @if ($isEdit)
        @method('PUT')
      @endif

      <p>
        <label>Judul</label>
        <input type="text" name="title" class="form-control"
               value="{{ old('title', $film->title ?? '') }}" required>
      </p>
      <p>
        <label>Tahun</label>
        <input type="number" name="year" class="form-control"
               value="{{ old('year', $film->year ?? now()->year) }}" required>
      </p>
      <p>
        <label>Genre</label>
        <select name="genre_id" class="form-control" required>
          <option value="">-- Pilih genre --</option>
          @foreach ($genreOptions as $opt)
            <option value="{{ $opt->id }}"
              {{ old('genre_id', $film->genre_id ?? '') == $opt->id ? 'selected' : '' }}>
              {{ $opt->name }}
            </option>
          @endforeach
        </select>
      </p>
      <p>
        <label>Sinopsis</label>
        <textarea name="sinopsis" class="form-control" rows="5" required>{{ old('sinopsis', $film->sinopsis ?? '') }}</textarea>
      </p>
      <p>
        <label>Poster {{ $isEdit ? '(kosongkan jika tidak diganti)' : '' }}</label>
        @if ($isEdit)
          <br><img src="{{ asset($film->poster) }}" alt="" style="height: 120px; margin-bottom: 8px;"><br>
        @endif
        <input type="file" name="poster" accept="image/*" {{ $isEdit ? '' : 'required' }}>
      </p>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.films.index') }}" class="btn btn-default">Batal</a>
    </form>
  </div>
</div>
@endsection