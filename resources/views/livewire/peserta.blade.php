<div>
    <section class="">
        <section class="section">
            <div class="section-header">
                <h1>Peserta</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Peserta</div>
                </div>
            </div>
        </section>

        <!-- Modal for Add/Edit -->
        <div wire:ignore.self class="modal fade" id="pesertaModal" tabindex="-1" aria-labelledby="pesertaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pesertaModalLabel">
                            {{ $is_edit_mode ? 'Edit Peserta' : 'Tambah Peserta' }}
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="{{ $is_edit_mode ? 'update' : 'store' }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_peserta" class="form-label">Nama Peserta</label>
                                <input type="text" class="form-control @error('nama_peserta') is-invalid @enderror"
                                    id="nama_peserta" wire:model.defer="nama_peserta">
                                @error('nama_peserta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="id_user" class="form-label">Pengguna</label>
                                <select class="form-control @error('id_user') is-invalid @enderror" id="id_user" wire:model.defer="id_user">
                                    <option value="">Pilih Pengguna</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('id_user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="mb-3">
                                <label for="id_unit_kerja" class="form-label">Unit Kerja</label>
                                <select class="form-control @error('id_unit_kerja') is-invalid @enderror" id="id_unit_kerja" wire:model.defer="id_unit_kerja">
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($unit_kerjas as $unit_kerja)
                                        <option value="{{ $unit_kerja->id_unit_kerja }}">{{ $unit_kerja->nama_unit_kerja }}</option>
                                    @endforeach
                                </select>
                                @error('id_unit_kerja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_mentor" class="form-label">Mentor</label>
                                <select class="form-control @error('id_mentor') is-invalid @enderror" id="id_mentor" wire:model.defer="id_mentor">
                                    <option value="">Pilih Mentor</option>
                                    @foreach ($mentors as $mentor)
                                        <option value="{{ $mentor->id_mentor }}">{{ $mentor->nama_mentor }}</option>
                                    @endforeach
                                </select>
                                @error('id_mentor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">{{ $is_edit_mode ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table section -->
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Daftar Peserta</h4>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pesertaModal" wire:click="resetForm">
                                Tambah Peserta
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="table-2">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%">No</th>
                                <th>Nama Peserta</th>
                                {{-- <th>Pengguna</th> --}}
                                <th>Unit Kerja</th>
                                <th>Mentor</th>
                                <th class="text-center" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesertas as $index => $peserta)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $peserta->nama_peserta }}</td>
                                    {{-- <td>{{ $peserta->user ? $peserta->user->name : '-' }}</td> --}}
                                    <td>{{ $peserta->unit_kerja ? $peserta->unit_kerja->nama_unit_kerja : '-' }}</td>
                                    <td>{{ $peserta->mentor ? $peserta->mentor->nama_mentor : '-' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-warning mr-2"
                                                wire:click="edit({{ $peserta->id_peserta }})" type="button"
                                                data-toggle="modal" data-target="#pesertaModal">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="confirmDelete({{ $peserta->id_peserta }})" type="button">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('livewire:init', () => {
            window.addEventListener('closeModal', event => {
                $('#pesertaModal').modal('hide');
                console.log('closeModal event received');
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.delete(id)
                }
            });
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('showAlert', (event) => {
                Swal.fire({
                    icon: event[0].type,
                    title: event[0].type === 'success' ? 'Berhasil!' : 'Error!',
                    text: event[0].message,
                    timer: event[0].type === 'success' ? 1500 : undefined,
                    showConfirmButton: event[0].type === 'error',
                    position: 'top-end',
                    toast: event[0].type === 'success',
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            });
        });
    </script>
</div>