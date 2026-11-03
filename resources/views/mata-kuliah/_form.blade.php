<div class="mb-3">
    <label class="form-label">Program Studi</label>
    <select name="program_studi_id" class="form-select @error('program_studi_id') is-invalid @enderror">
        <option value="">-- Pilih Program Studi --</option>
        @foreach ($programStudi as $prodi)
            <option value="{{ $prodi->id }}"
                @selected(old('program_studi_id', $mataKuliah->program_studi_id) == $prodi->id)>
                {{ $prodi->nama }}
            </option>
        @endforeach
    </select>
    @error('program_studi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kode Mata Kuliah</label>
    <input type="text" name="kode_mk" value="{{ old('kode_mk', $mataKuliah->kode_mk) }}"
           class="form-control @error('kode_mk') is-invalid @enderror">
    @error('kode_mk') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nama Mata Kuliah</label>
    <input type="text" name="nama_mk" value="{{ old('nama_mk', $mataKuliah->nama_mk) }}"
           class="form-control @error('nama_mk') is-invalid @enderror">
    @error('nama_mk') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">SKS</label>
    <input type="number" name="sks" value="{{ old('sks', $mataKuliah->sks) }}"
           class="form-control @error('sks') is-invalid @enderror">
    @error('sks') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="status_aktif" value="1" id="status_aktif" class="form-check-input"
           @checked(old('status_aktif', $mataKuliah->status_aktif))>
    <label for="status_aktif" class="form-check-label">Mata kuliah aktif / dibuka</label>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Dibuka</label>
    <input type="date" name="tanggal_dibuka"
           value="{{ old('tanggal_dibuka', $mataKuliah->tanggal_dibuka?->format('Y-m-d')) }}"
           class="form-control @error('tanggal_dibuka') is-invalid @enderror">
    @error('tanggal_dibuka') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
