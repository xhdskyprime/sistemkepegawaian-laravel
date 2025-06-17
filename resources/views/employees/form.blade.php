<div class="row">
    <!-- Kolom Kiri -->
    <div class="col-md-6">
        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $employee->nip ?? '') }}"
                required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $employee->nama ?? '') }}"
                required>
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="text" name="tanggal_lahir" class="form-control datepicker"
                value="{{ isset($employee) ? \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d-m-Y') : old('tanggal_lahir') }}"
                required>
        </div>
        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
                <option value="">-- Pilih Jenis Kelamin--</option>
                <option value="Laki-laki"
                    {{ old('jenis_kelamin', $employee->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                    Laki-laki</option>
                <option value="Perempuan"
                    {{ old('jenis_kelamin', $employee->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                    Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            @php
                $pangkatList = [
                    'IVe' => 'Pembina Utama (IVe)',
                    'IVd' => 'Pembina Madya (IVd)',
                    'IVc' => 'Pembina Muda (IVc)',
                    'IVb' => 'Pembina Tingkat I (IVb)',
                    'IVa' => 'Pembina (IVa)',

                    'IIId' => 'Penata Tingkat I (IIId)',
                    'IIIc' => 'Penata (IIIc)',
                    'IIIb' => 'Penata Muda Tingkat I (IIIb)',
                    'IIIa' => 'Penata Muda (IIIa)',

                    'IId' => 'Pengatur Tingkat I (IId)',
                    'IIc' => 'Pengatur (IIc)',
                    'IIb' => 'Pengatur Muda Tingkat I (IIb)',
                    'IIa' => 'Pengatur Muda (IIa)',

                    'Id' => 'Juru Tingkat I (Id)',
                    'Ic' => 'Juru (Ic)',
                    'Ib' => 'Juru Muda Tingkat I (Ib)',
                    'Ia' => 'Juru Muda (Ia)',
                ];
            @endphp

            <div class="mb-3">
                <label for="pangkat">Pangkat</label>
                <select name="pangkat" class="form-select" required>
                    <option value="">-- Pilih Pangkat --</option>
                    @foreach ($pangkatList as $key => $label)
                        <option value="{{ $key }}"
                            {{ old('pangkat', isset($employee) ? $employee->pangkat : '') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label>Jabatan</label>
            @php
                $jabatanOptions = [
                    'Direktur',
                    'Wakil Direktur',
                    'Kepala Bagian',
                    'Kepala Bidang',
                    'Kepala Subbagian',
                    'Kepala Seksi',
                    'Staf / Fungsional',
                ];
            @endphp

            <div class="mb-3">
                <select name="jabatan" class="form-select" required>
                    <option value="" disabled
                        {{ old('jabatan', $employee->jabatan ?? '') == '' ? 'selected' : '' }}>-- Pilih Jabatan --
                    </option>
                    @foreach ($jabatanOptions as $jab)
                        <option value="{{ $jab }}"
                            {{ old('jabatan', $employee->jabatan ?? '') == $jab ? 'selected' : '' }}>
                            {{ $jab }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="col-md-6">
        <div class="mb-3">
            <label for="formasi" class="form-label">Formasi</label>
            <input type="text" name="formasi" class="form-control"
                value="{{ old('formasi', $employee->formasi ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="jenis_pegawai" class="form-label">Jenis Pegawai</label>
            <select name="jenis_pegawai" id="jenis_pegawai" class="form-select" required>
                <option value="">-- Pilih Jenis Pegawai --</option>
                <option value="Tenaga Medis"
                    {{ old('jenis_pegawai', $employee->jenis_pegawai ?? '') == 'Tenaga Medis' ? 'selected' : '' }}>
                    Tenaga Medis</option>
                <option value="Tenaga Non-Medis"
                    {{ old('jenis_pegawai', $employee->jenis_pegawai ?? '') == 'Tenaga Non-Medis' ? 'selected' : '' }}>
                    Tenaga Non-Medis</option>
            </select>
        </div>
        <div id="sip-section" style="display: none;">
            <div class="mb-3">
                <label for="no_sip" class="form-label">No SIP</label>
                <input type="text" name="no_sip" class="form-control"
                    value="{{ old('no_sip', $employee->no_sip ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                <input type="text" name="tanggal_terbit" class="form-control datepicker"
                    value="{{ isset($employee) ? \Carbon\Carbon::parse($employee->tanggal_terbit)->format('d-m-Y') : old('tanggal_terbit') }}">
            </div>
            <div class="mb-3">
                <label for="tanggal_kadaluwarsa" class="form-label">Tanggal Kedaluwarsa</label>
                <input type="text" name="tanggal_kadaluwarsa" class="form-control datepicker"
                    value="{{ isset($employee) ? \Carbon\Carbon::parse($employee->tanggal_kadaluwarsa)->format('d-m-Y') : old('tanggal_kadaluwarsa') }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $employee->email ?? '') }}">
            </div>
        </div>
    </div>

</div>
