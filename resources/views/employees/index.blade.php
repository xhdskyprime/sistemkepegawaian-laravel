@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data Pegawai</h4>
        <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Pegawai
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">NIP</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Nama</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Pangkat</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Jabatan</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Tanggal Lahir</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Jenis Kelamin</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $index => $employee)
                        <tr>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $employee->nip }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $employee->name }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $employee->rank }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $employee->position }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y') }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $employee->gender }}</p>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-link text-info btn-sm mb-0" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger btn-sm mb-0" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($employees->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center text-secondary text-xs font-weight-bold">Data pegawai tidak ditemukan.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{-- Pagination jika ada --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
