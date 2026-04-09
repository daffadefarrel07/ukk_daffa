@extends('admin.layout')

@section('title','Edit Aspirasi')

@section('content')
    <h1>Edit Aspirasi</h1>
    <form method="POST" action="{{ route('admin.aspirasi.update', $asp->id ?? 0) }}" class="form">
        @csrf
        <label>Judul<input type="text" name="judul" value="{{ $asp->judul ?? '' }}"></label>
        <label>Status<select name="status">
            <option value="pending" {{ (isset($asp) && $asp->status==='pending')? 'selected':'' }}>Pending</option>
            <option value="in_progress" {{ (isset($asp) && $asp->status==='in_progress')? 'selected':'' }}>In Progress</option>
            <option value="done" {{ (isset($asp) && $asp->status==='done')? 'selected':'' }}>Done</option>
        </select></label>
        <button class="btn" type="submit">Update</button>
    </form>
@endsection
