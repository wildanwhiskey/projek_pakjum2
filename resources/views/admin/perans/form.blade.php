@extends('templates.index')

@section('content')
@php $isEdit = isset($peranItem); @endphp
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('admin.perans.index') }}">Kelola Peran</a></li>
      <li class="active">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
    </ol>
  </div>

  <div style="max-width: 600px;">
    <h3>{{ $isEdit ? 'Edit Peran' : 'Tambah Peran' }}</h3>

    @if ($errors->any())
      <div style="color: red;">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ $isEdit ? route('admin.perans.update', $peranItem->id) : route('admin.perans.store') }}" method="post">
      @csrf
      @if ($isEdit)
        @method('PUT')
      @endif

      <p>
        <label>Film</label>
        <select name="film_id" class="form-control" required>
          <option value="">-- Pilih film --</option>
          @foreach ($filmOptions as $opt)
            <option value="{{ $opt->id }}"
              {{ old('film_id', $peranItem->film_id ?? '') == $opt->id ? 'selected' : '' }}>
              {{ $opt->title }}
            </option>
          @endforeach
        </select>
      </p>
      <p>
        <label>Cast</label>
        <select name="cast_id" class="form-control" required>
          <option value="">-- Pilih cast --</option>
          @foreach ($castOptions as $opt)
            <option value="{{ $opt->id }}"
              {{ old('cast_id', $peranItem->cast_id ?? '') == $opt->id ? 'selected' : '' }}>
              {{ $opt->name }}
            </option>
          @endforeach
        </select>
      </p>
      <p>
        <label>Nama peran</label>
        <input type="text" name="actor" class="form-control" placeholder="Contoh: Tokoh utama, Sutradara"
               value="{{ old('actor', $peranItem->actor ?? '') }}" required>
      </p>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.perans.index') }}" class="btn btn-default">Batal</a>
    </form>
  </div>
</div>
@endsection