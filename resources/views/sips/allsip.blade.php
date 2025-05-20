@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data SIP - Tenaga Medis</h4>
        <form method="GET" action="{{ route('employees.allsip') }}" class="d-flex align-items-center gap-2" style="max-width: 350px; width: 100%;">
            <input type="text" name="search" class="form-control form-control-sm py-2" style="height: 40px;" placeholder="Cari nama, NIP, SIP, atau email..." value="{{ request('search') }}">
            <button class="btn btn-sm btn-outline-primary d-flex align-items-center px-3" type="submit" style="height: 40px;    margin-bottom: 0px;">
                <i class="fas fa-search fs-6"></i> CARI
            </button>
        </form>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">

                @if(request('search'))
                    <p class="text-muted">Menampilkan hasil untuk: <strong>{{ request('search') }}</strong></p>
                @endif
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">NIP</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Nama</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">No SIP</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Tgl Terbit</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Tgl Kadaluwarsa</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $index => $employee)
                        <tr>
                            <td><p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">{{ $employee->nip }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">{{ $employee->nama }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">{{ $employee->no_sip ?? '-' }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">
                                {{ $employee->tanggal_terbit ? \Carbon\Carbon::parse($employee->tanggal_terbit)->format('d-m-Y') : '-' }}
                            </p></td>
                            <td><p class="text-xs font-weight-bold mb-0">
                                {{ $employee->tanggal_kadaluwarsa ? \Carbon\Carbon::parse($employee->tanggal_kadaluwarsa)->format('d-m-Y') : '-' }}
                            </p></td>
                            {{-- <td><p class="text-xs font-weight-bold mb-0">
                                @php
                                $sisaHari = \Carbon\Carbon::parse($employee->tanggal_kadaluwarsa)->diffInDays(now(), false);
                                @endphp
                                @if ($sisaHari > 0)
                                <span class="text-danger">{{ floor(abs($sisaHari)) }} hari yang lalu</span>
                                @elseif ($sisaHari === 0)
                                <span class="text-warning">Hari ini</span>
                                @else
                                <span class="text-success">Sisa {{ floor(abs($sisaHari)) }} hari</span>
                                @endif</p></td> --}}
                            <td><p class="text-xs font-weight-bold mb-0">{{ $employee->email ?? '-' }}</p></td>
                        </tr>
                        @endforeach

                        @if ($employees->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center text-secondary text-xs font-weight-bold">
                                Tidak ada data tenaga medis.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $employees->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
