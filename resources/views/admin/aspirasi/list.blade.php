@extends('admin.layout')

@section('title','Aspirasi List')

@section('content')
    <h1>Aspirasi</h1>

    <table class="table">
        <thead>
            <tr><th>ID</th><th>Judul</th><th>Siswa</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($aspirasis as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td>{{ $a->judul ?? '-' }}</td>
                    <td>{{ optional($a->siswa)->nama ?? '-' }}</td>
                    <td>{{ $a->status ?? '-' }}</td>
                    <td><a href="{{ route('admin.aspirasi.edit', $a->id) }}">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No aspirasi</td></tr>
            @endforelse
        </tbody>
    </table>

@endsection
