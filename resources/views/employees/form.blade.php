<div class="row">
    <!-- Kolom Kiri -->
    <div class="col-md-6">
        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $employee->nip ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $employee->nama ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $employee->tanggal_lahir ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $employee->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $employee->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Pangkat</label>
            <input type="text" name="pangkat" class="form-control" value="{{ old('pangkat', $employee->pangkat ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $employee->jabatan ?? '') }}" required>
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="col-md-6">
        <div class="mb-3">
            <label for="jenis_pegawai" class="form-label">Jenis Pegawai</label>
            <select name="jenis_pegawai" id="jenis_pegawai" class="form-select" required>
                <option value="">-- Pilih Jenis Pegawai --</option>
                <option value="Tenaga Medis" {{ old('jenis_pegawai', $employee->jenis_pegawai ?? '') == 'Tenaga Medis' ? 'selected' : '' }}>Tenaga Medis</option>
                <option value="Tenaga Non-Medis" {{ old('jenis_pegawai', $employee->jenis_pegawai ?? '') == 'Tenaga Non-Medis' ? 'selected' : '' }}>Tenaga Non-Medis</option>
            </select>
        </div>
        <div id="sip-section" style="display: none;">
            <div class="mb-3">
                <label for="no_sip" class="form-label">No SIP</label>
                <input type="text" name="no_sip" class="form-control" value="{{ old('no_sip', $employee->no_sip ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                <input type="date" name="tanggal_terbit" class="form-control" value="{{ old('tanggal_terbit', $employee->tanggal_terbit ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="tanggal_kadaluwarsa" class="form-label">Tanggal Kadaluwarsa</label>
                <input type="date" name="tanggal_kadaluwarsa" class="form-control" value="{{ old('tanggal_kadaluwarsa', $employee->tanggal_kadaluwarsa ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email ?? '') }}">
            </div>
        </div>
    </div>
    
</div>
