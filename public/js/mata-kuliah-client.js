const API = '/api/v1';
const BUTUH_LOGIN = true; // diubah menjadi true pada Bagian 4.3
const FIELD = ['program_studi_id', 'kode_mk', 'nama_mk', 'sks', 'status_aktif', 'tanggal_dibuka'];
const $ = (id) => document.getElementById(id);
let halaman = 1;

const esc = (t) => String(t ?? '').replace(/[&<>"']/g, (c) =>
  ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

class ApiError extends Error {
  constructor(status, message, errors = {}) {
    super(message);
    this.status = status; // 0 = gagal jaringan
    this.errors = errors; // diisi pada respons 422
  }
}

const pesan = (teks, jenis = 'success') => {
  $('alert-area').innerHTML = `<div class="alert alert-${jenis}">${esc(teks)}</div>`;
};

/* ---- Sesi dan tampilan ---- */
const token = () => localStorage.getItem('token');
const bolehTulis = () => !BUTUH_LOGIN || Boolean(token());

function tampilAuth() {
  $('form-login').classList.toggle('d-none', !BUTUH_LOGIN || Boolean(token()));
  $('info-user').classList.toggle('d-none', !BUTUH_LOGIN || !token());
  $('btn-tambah').classList.toggle('d-none', !bolehTulis());
  $('nama-user').textContent = localStorage.getItem('nama') ?? '';
  if (!bolehTulis()) $('kartu-form').classList.add('d-none');
}

/* ---- Satu pintu untuk semua request ---- */
async function apiRequest(path, { method = 'GET', body = null, auth = false } = {}) {
  const headers = { Accept: 'application/json' };
  if (body) headers['Content-Type'] = 'application/json';
  if (auth && token()) headers.Authorization = `Bearer ${token()}`;

  let res;
  try {
    res = await fetch(API + path, { method, headers, body: body ? JSON.stringify(body) : undefined });
  } catch {
    // fetch hanya reject bila jaringan gagal (server mati, offline)
    throw new ApiError(0, 'Tidak dapat terhubung ke server.');
  }
  if (res.status === 204) return null; // sukses tanpa isi (DELETE)

  const data = await res.json().catch(() => null);
  if (!res.ok) {
    if (res.status === 401 && auth) { localStorage.clear(); tampilAuth(); }
    throw new ApiError(res.status, data?.message ?? `HTTP ${res.status}`, data?.errors ?? {});
  }
  return data;
}

function tanganiError(err) {
  FIELD.forEach((f) => { $(`err-${f}`).textContent = ''; });
  if (err.status === 422) {
    Object.entries(err.errors).forEach(([f, m]) => { if ($(`err-${f}`)) $(`err-${f}`).textContent = m.join(' '); });
    pesan('Data belum valid. Periksa isian formulir.', 'warning');
  } else if (err.status === 401) {
    pesan('Sesi tidak valid. Silakan login kembali.', 'warning');
  } else if (err.status === 404) {
    pesan('Data tidak ditemukan.', 'warning');
    muatMataKuliah(halaman);
  } else {
    pesan(err.message, 'danger'); // status 0 (jaringan) dan 5xx
  }
}

/* ---- Membaca data ---- */
async function muatProdi() {
  try {
    const { data } = await apiRequest('/program-studi');
    const opsi = data.map((p) => `<option value="${p.id}">${esc(p.nama)}</option>`).join('');
    $('filter-prodi').insertAdjacentHTML('beforeend', opsi);
    $('mk-program_studi_id').insertAdjacentHTML('beforeend', opsi);
  } catch (err) { tanganiError(err); }
}

async function muatMataKuliah(page = 1) {
  const q = new URLSearchParams({ page });
  if ($('filter-cari').value.trim()) q.set('cari', $('filter-cari').value.trim());
  if ($('filter-prodi').value) q.set('prodi', $('filter-prodi').value);
  try {
    const json = await apiRequest(`/mata-kuliah?${q}`);
    halaman = json.meta.current_page;
    const aksi = (id) => (bolehTulis()
      ? `<button class="btn btn-sm btn-warning" data-aksi="ubah" data-id="${id}">Ubah</button>
         <button class="btn btn-sm btn-danger" data-aksi="hapus" data-id="${id}">Hapus</button>` : '-');
    $('tbody-mk').innerHTML = json.data.map((mk, i) => `
      <tr><td>${(json.meta.from ?? 1) + i}</td><td>${esc(mk.kode_mk)}</td><td>${esc(mk.nama_mk)}</td>
      <td>${mk.sks}</td><td>${esc(mk.program_studi?.nama ?? '-')}</td>
      <td>${mk.status_aktif ? 'Aktif' : 'Nonaktif'}</td><td>${aksi(mk.id)}</td></tr>`).join('')
      || '<tr><td colspan="7">Belum ada data.</td></tr>';
    $('info-halaman').textContent = `Halaman ${json.meta.current_page} dari ${json.meta.last_page}`;
    $('btn-prev').disabled = json.links.prev === null;
    $('btn-next').disabled = json.links.next === null;
  } catch (err) {
    $('tbody-mk').innerHTML = `<tr><td colspan="7" class="text-danger">${esc(err.message)}</td></tr>`;
  }
}

/* ---- Menulis data: letakkan di atas blok "Inisialisasi" ---- */
function isiForm(mk = {}) {
  FIELD.forEach((f) => { $(`err-${f}`).textContent = ''; });
  $('mk-id').value = mk.id ?? '';
  $('mk-program_studi_id').value = mk.program_studi?.id ?? '';
  $('mk-kode_mk').value = mk.kode_mk ?? '';
  $('mk-nama_mk').value = mk.nama_mk ?? '';
  $('mk-sks').value = mk.sks ?? '';
  $('mk-status_aktif').checked = mk.status_aktif ?? false;
  $('mk-tanggal_dibuka').value = mk.tanggal_dibuka ?? '';
  $('kartu-form').classList.remove('d-none');
}

async function simpan(e) {
  e.preventDefault();
  const id = $('mk-id').value;
  const body = {
    program_studi_id: $('mk-program_studi_id').value || null,
    kode_mk: $('mk-kode_mk').value.trim(),
    nama_mk: $('mk-nama_mk').value.trim(),
    sks: $('mk-sks').value === '' ? null : Number($('mk-sks').value),
    status_aktif: $('mk-status_aktif').checked,
    tanggal_dibuka: $('mk-tanggal_dibuka').value || null,
  };
  try {
    await apiRequest(id ? `/mata-kuliah/${id}` : '/mata-kuliah', { method: id ? 'PUT' : 'POST', body, auth: true });
    pesan(id ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.');
    $('kartu-form').classList.add('d-none');
    await muatMataKuliah(id ? halaman : 1);
  } catch (err) { tanganiError(err); }
}

async function hapus(id) {
  if (!confirm('Hapus data ini?')) return;
  try {
    await apiRequest(`/mata-kuliah/${id}`, { method: 'DELETE', auth: true });
    pesan('Data berhasil dihapus.');
    await muatMataKuliah(halaman);
  } catch (err) { tanganiError(err); }
}

async function bukaFormUbah(id) {
  try {
    isiForm((await apiRequest(`/mata-kuliah/${id}`)).data); // GET show
  } catch (err) { tanganiError(err); }
}

/* ---- Autentikasi: letakkan di atas blok "Inisialisasi" ---- */
async function login() {
  $('err-login').textContent = '';
  try {
    const d = await apiRequest('/login', {
      method: 'POST',
      body: { email: $('login-email').value, password: $('login-password').value },
    });
    localStorage.setItem('token', d.token); // simpan Bearer Token
    localStorage.setItem('nama', d.user.name);
    $('login-password').value = '';
    tampilAuth();
    await muatMataKuliah(halaman);
  } catch (err) {
    $('err-login').textContent = Object.values(err.errors ?? {}).flat().join(' ') || err.message;
  }
}

async function logout() {
  try { await apiRequest('/logout', { method: 'POST', auth: true }); } catch { /* token tetap dibuang */ }
  localStorage.clear();
  tampilAuth();
  await muatMataKuliah(halaman);
}

/* ---- Inisialisasi (versi final, menggantikan blok sebelumnya) ---- */
document.addEventListener('DOMContentLoaded', async () => {
  $('btn-login').onclick = login;
  $('btn-logout').onclick = logout;
  $('btn-tambah').onclick = () => isiForm();
  $('btn-batal').onclick = () => $('kartu-form').classList.add('d-none');
  $('form-mk').onsubmit = simpan;
  $('form-filter').onsubmit = (e) => { e.preventDefault(); muatMataKuliah(1); };
  $('btn-prev').onclick = () => muatMataKuliah(halaman - 1);
  $('btn-next').onclick = () => muatMataKuliah(halaman + 1);
  $('tbody-mk').onclick = (e) => {
    const b = e.target.closest('button[data-aksi]');
    if (!b) return;
    if (b.dataset.aksi === 'hapus') hapus(b.dataset.id);
    else bukaFormUbah(b.dataset.id);
  };
  tampilAuth();
  await muatProdi();
  await muatMataKuliah(1);
});
