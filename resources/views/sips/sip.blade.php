@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Pantau SIP - Tenaga Medis</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('sip.sendEmailMassal') }}" class="btn btn-sm btn-outline-success d-flex align-items-center px-3" style="margin-bottom: 0px;line-height: 1; white-space: nowrap;">
                <i class="fas fa-envelope me-2 fs-6"></i> Kirim Email
            </a>
            <a href="{{ route('sip.sendRekapTelegram') }}" class="btn btn-sm btn-outline-info d-flex align-items-center px-3" style="margin-bottom: 0px;line-height: 1; white-space: nowrap;">
                <i class="fab fa-telegram me-2 fs-6"></i> Kirim Telegram
            </a>
            <a href="{{ route('sip.sendRekapEmail') }}" class="btn btn-sm btn-success d-flex align-items-center px-3"  style="margin-bottom: 0px;line-height: 1; white-space: nowrap;">
                <i class="fas fa-envelope-open-text me-2 fs-6"></i> Kirim Rekap ke Admin
            </a>
            <a class="btn btn-sm btn-outline-primary d-flex align-items-center px-3" data-bs-toggle="modal" data-bs-target="#schedulerModal" style="margin-bottom: 0px;line-height: 1; white-space: nowrap;">
                <i class="fas fa-stopwatch fs-6"></i>
            </a>
            <form method="GET" action="{{ route('employees.sip') }}" class="d-flex align-items-center gap-1" style="max-width: 350px; width: 100%;">
                <input type="text" name="search" class="form-control form-control-sm py-2" style="height: 40px;" placeholder="Cari nama, NIP, SIP, atau email..." value="{{ request('search') }}">
                <button class="btn btn-sm btn-outline-primary d-flex align-items-center px-2" type="submit" style="height: 40px;    margin-bottom: 0px;">
                    <i class="fas fa-search fs-6"></i> Cari
                </button>
            </form>
        </div>
    </div>
    @php
        $config = \App\Models\SchedulerSetting::first() ?? (object) [
            'day_of_week' => 'sun',
            'hour' => 9,
            'minute' => 0
        ];
    @endphp

    <!-- Scheduler Modal -->
    <div class="modal fade" id="schedulerModal" tabindex="-1" aria-labelledby="schedulerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('scheduler.update') }}" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="schedulerModalLabel">⏰ Atur Jadwal Scheduler</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
            <label class="form-label">Hari</label>
            <select class="form-select" name="day_of_week" required>
                @foreach (['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'] as $day)
                <option value="{{ $day }}" {{ $config->day_of_week == $day ? 'selected' : '' }}>
                    {{ ucfirst($day) }}
                </option>
                @endforeach
            </select>
            </div>
            <div class="mb-3">
            <label class="form-label">Jam (0-23)</label>
            <select class="form-select" name="hour" required>
                @for ($h = 0; $h < 24; $h++)
                <option value="{{ $h }}" {{ $config->hour == $h ? 'selected' : '' }}>
                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                </option>
                @endfor
            </select>
            </div>
            <div class="mb-3">
            <label class="form-label">Menit (0-59)</label>
            <select class="form-select" name="minute" required>
                @for ($m = 0; $m < 60; $m += 5)
                <option value="{{ $m }}" {{ $config->minute == $m ? 'selected' : '' }}>
                    {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                </option>
                @endfor
            </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">💾 Simpan Jadwal</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
        </form>
    </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="background-image: #ffffff;"></button>
    </div>
    @endif
    
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
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Sisa Hari</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $index => $employee)
                        <tr>
                            <td><p class="text-xs font-weight-bold mb-0 text-center">{{ $index + 1 }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">{{ $employee->nip }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">{{ $employee->nama }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">{{ $employee->no_sip ?? '-' }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">
                                {{ $employee->tanggal_terbit ? \Carbon\Carbon::parse($employee->tanggal_terbit)->format('d-m-Y') : '-' }}
                            </p></td>
                            <td><p class="text-xs font-weight-bold mb-0">
                                {{ $employee->tanggal_kadaluwarsa ? \Carbon\Carbon::parse($employee->tanggal_kadaluwarsa)->format('d-m-Y') : '-' }}
                            </p></td>
                            <td><p class="text-xs font-weight-bold mb-0">
                                @php
                                $sisaHari = \Carbon\Carbon::parse($employee->tanggal_kadaluwarsa)->diffInDays(now(), false);
                                @endphp
                                @if ($sisaHari > 0)
                                <span class="text-danger">{{ floor(abs($sisaHari)) }} hari yang lalu</span>
                                @elseif ($sisaHari === 0)
                                <span class="text-warning">Hari ini</span>
                                @else
                                <span class="text-success">Sisa {{ floor(abs($sisaHari)) }} hari</span>
                                @endif</p></td>
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
