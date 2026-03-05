// ============================================
// Patient Record System — JavaScript
// ============================================

const API = {
  patients: 'api/patients.php',
  records:  'api/records.php'
};

// ─── State ────────────────────────────────────
let state = {
  patients:        [],
  currentPatient:  null,
  editingPatient:  null,
  editingRecord:   null,
  searchQuery:     '',
  confirmCallback: null
};

// ─── DOM Helpers ──────────────────────────────
const $  = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

// ─── Init ─────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  loadDashboard();
  bindNav();
  bindSearch();
  bindForms();
});

// ─── Navigation ───────────────────────────────
function bindNav() {
  $$('.nav-item[data-section]').forEach(btn => {
    btn.addEventListener('click', () => navigateTo(btn.dataset.section));
  });
}

function navigateTo(section) {
  $$('.nav-item').forEach(b => b.classList.remove('active'));
  $$(`.nav-item[data-section="${section}"]`).forEach(b => b.classList.add('active'));
  $$('.section').forEach(s => s.classList.remove('active'));
  const el = $(`#section-${section}`);
  if (el) el.classList.add('active');

  // Update topbar title
  const titles = {
    dashboard: ['Dashboard', 'Overview of patient management system'],
    patients:  ['Patients', 'Manage patient records'],
    records:   ['Medical Records', 'View all medical entries'],
  };
  const [title, sub] = titles[section] || ['', ''];
  $('#topbar-title').textContent = title;
  $('#topbar-sub').textContent   = sub;

  if (section === 'dashboard') loadDashboard();
  if (section === 'patients')  loadPatients();
  if (section === 'records')   showSection('patients-list');
}

function showSection(view) {
  $$('.detail-panel, .section-view').forEach(el => el.classList.remove('active'));
  const el = $(`#${view}`);
  if (el) el.classList.add('active');
}

// ─── Toast ────────────────────────────────────
function toast(msg, type = 'success') {
  const icons = { success: '✓', error: '✕', warning: '⚠' };
  const div = document.createElement('div');
  div.className = `toast ${type}`;
  div.innerHTML = `<span>${icons[type]}</span> ${msg}`;
  $('#toast-container').appendChild(div);
  setTimeout(() => div.remove(), 3500);
}

// ─── Confirm Dialog ───────────────────────────
function confirm(msg, cb) {
  $('#confirm-msg').textContent = msg;
  state.confirmCallback = cb;
  $('#confirm-overlay').classList.add('open');
}

document.addEventListener('click', e => {
  if (e.target.id === 'confirm-yes') {
    $('#confirm-overlay').classList.remove('open');
    if (state.confirmCallback) state.confirmCallback();
  }
  if (e.target.id === 'confirm-no' || e.target.id === 'confirm-overlay') {
    $('#confirm-overlay').classList.remove('open');
  }
});

// ─── Search ───────────────────────────────────
function bindSearch() {
  $('#search-input').addEventListener('input', e => {
    state.searchQuery = e.target.value;
    loadPatients(state.searchQuery);
  });
  $('#patient-search').addEventListener('input', e => {
    loadPatients(e.target.value);
  });
}

// ─── API Fetch Helper ─────────────────────────
async function api(url, method = 'GET', body = null) {
  const opts = { method, headers: { 'Content-Type': 'application/json' } };
  if (body) opts.body = JSON.stringify(body);
  
  console.log(`[API ${method}] ${url}`, body); // Debug log
  
  try {
    const res = await fetch(url, opts);
    const data = await res.json();
    console.log(`[API Response]`, data); // Debug log
    return data;
  } catch (error) {
    console.error(`[API Error]`, error);
    throw error;
  }
}

// ─── Dashboard ────────────────────────────────
async function loadDashboard() {
  const res = await api(`${API.patients}?stats=1`);
  if (!res.success) return;
  const s = res.stats;

  $('#stat-total').textContent   = s.total_patients;
  $('#stat-records').textContent = s.total_records;
  $('#stat-today').textContent   = s.visits_today;

  // Recent patients
  const tbody = $('#recent-patients-body');
  if (!s.recent_patients.length) {
    tbody.innerHTML = `<tr><td colspan="5" class="empty-state-td" style="text-align:center;padding:32px;color:var(--text-muted)">No patients yet</td></tr>`;
    return;
  }
  tbody.innerHTML = s.recent_patients.map(p => `
    <tr>
      <td>
        <div style="display:flex;align-items:center;gap:10px">
          <div class="recent-avatar">${initials(p.full_name)}</div>
          <div>
            <div style="font-weight:600">${esc(p.full_name)}</div>
            <div style="font-size:0.75rem;color:var(--text-muted)">${esc(p.patient_id)}</div>
          </div>
        </div>
      </td>
      <td>${p.age}</td>
      <td><span class="badge badge-${p.gender.toLowerCase()}">${p.gender}</span></td>
      <td>${p.records}</td>
      <td>${p.last_visit ? formatDate(p.last_visit) : '<span style="color:var(--text-muted)">—</span>'}</td>
    </tr>
  `).join('');

  // Gender distribution
  drawGenderChart(s.gender_dist);
}

function drawGenderChart(dist) {
  const canvas = $('#gender-canvas');
  if (!canvas) return;
  const ctx    = canvas.getContext('2d');
  const total  = dist.reduce((a, b) => a + parseInt(b.count), 0);
  if (!total) return;

  const colors = { Male: '#2563eb', Female: '#be185d', Other: '#f59e0b' };
  const size   = canvas.width;
  const cx = size / 2, cy = size / 2, r = size / 2 - 8;
  let angle = -Math.PI / 2;

  ctx.clearRect(0, 0, size, size);

  dist.forEach(d => {
    const slice = (parseInt(d.count) / total) * 2 * Math.PI;
    ctx.beginPath();
    ctx.moveTo(cx, cy);
    ctx.arc(cx, cy, r, angle, angle + slice);
    ctx.closePath();
    ctx.fillStyle = colors[d.gender] || '#aaa';
    ctx.fill();
    angle += slice;
  });

  // Donut hole
  ctx.beginPath();
  ctx.arc(cx, cy, r * 0.55, 0, 2 * Math.PI);
  ctx.fillStyle = '#fff';
  ctx.fill();

  // Center text
  ctx.fillStyle = '#1a2332';
  ctx.font = 'bold 18px DM Sans';
  ctx.textAlign = 'center';
  ctx.textBaseline = 'middle';
  ctx.fillText(total, cx, cy - 5);
  ctx.font = '11px DM Sans';
  ctx.fillStyle = '#6b7a99';
  ctx.fillText('patients', cx, cy + 12);

  // Legend
  const legend = $('#gender-legend');
  const colors2 = { Male: '#2563eb', Female: '#be185d', Other: '#f59e0b' };
  legend.innerHTML = dist.map(d => `
    <div class="legend-item">
      <span class="legend-dot" style="background:${colors2[d.gender] || '#aaa'}"></span>
      <span>${d.gender}: <strong>${d.count}</strong></span>
    </div>
  `).join('');
}

// ─── Patients ─────────────────────────────────
async function loadPatients(search = '') {
  const tbody = $('#patients-tbody');
  tbody.innerHTML = `<tr class="loading-row"><td colspan="8"><span class="spinner"></span>Loading...</td></tr>`;

  const res = await api(`${API.patients}?search=${encodeURIComponent(search)}`);
  if (!res.success) { toast(res.message, 'error'); return; }

  state.patients = res.patients;
  renderPatientsTable(res.patients);
  updatePatientBadge(res.patients.length);
}

function renderPatientsTable(patients) {
  const tbody = $('#patients-tbody');
  if (!patients.length) {
    tbody.innerHTML = `
      <tr><td colspan="8">
        <div class="empty-state">
          <div class="empty-icon">🏥</div>
          <h3>No patients found</h3>
          <p>Add your first patient to get started</p>
        </div>
      </td></tr>`;
    return;
  }

  tbody.innerHTML = patients.map(p => `
    <tr data-id="${p.id}">
      <td>
        <div style="display:flex;align-items:center;gap:10px">
          <div class="recent-avatar">${initials(p.full_name)}</div>
          <div>
            <div style="font-weight:600">${esc(p.full_name)}</div>
            <div style="font-size:0.72rem;color:var(--text-muted)">${esc(p.patient_id)}</div>
          </div>
        </div>
      </td>
      <td>${p.age}</td>
      <td><span class="badge badge-${p.gender.toLowerCase()}">${p.gender}</span></td>
      <td>${esc(p.blood_type)}</td>
      <td>${esc(p.contact)}</td>
      <td>${p.total_records ?? 0}</td>
      <td>${p.last_visit ? formatDate(p.last_visit) : '<span style="color:var(--text-muted)">—</span>'}</td>
      <td>
        <div style="display:flex;gap:6px">
          <button class="btn btn-ghost btn-sm btn-icon" title="View Records" onclick="viewPatient(${p.id})">📋</button>
          <button class="btn btn-ghost btn-sm btn-icon" title="Edit Patient" onclick="editPatient(${p.id})">✏️</button>
          <button class="btn btn-danger btn-sm btn-icon" title="Delete Patient" onclick="deletePatient(${p.id}, '${esc(p.full_name)}')">🗑️</button>
        </div>
      </td>
    </tr>
  `).join('');
}

function updatePatientBadge(n) {
  const el = $('#nav-badge-patients');
  if (el) el.textContent = n;
}

// ─── Add / Edit Patient Modal ─────────────────
function openAddPatient() {
  state.editingPatient = null;
  $('#patient-modal-title').textContent = 'Add New Patient';
  $('#patient-form').reset();
  $('#patient-modal').classList.add('open');
}

function editPatient(id) {
  const p = state.patients.find(x => x.id == id);
  if (!p) return;
  state.editingPatient = p;
  $('#patient-modal-title').textContent = 'Edit Patient';

  const f = $('#patient-form');
  f.full_name.value   = p.full_name;
  f.age.value         = p.age;
  f.gender.value      = p.gender;
  f.blood_type.value  = p.blood_type;
  f.contact.value     = p.contact;
  f.address.value     = p.address;
  $('#patient-modal').classList.add('open');
}

function closePatientModal() {
  $('#patient-modal').classList.remove('open');
}

async function submitPatientForm() {
  const btn = $('#patient-submit-btn');
  const form = $('#patient-form');
  
  if (btn.disabled) return; // Prevent double submission
  btn.disabled = true;
  btn.textContent = 'Saving...';
  
  try {
    const fd  = new FormData(form);
    const body = Object.fromEntries(fd.entries());
    
    console.log('Form data:', body); // Debug log
    
    // Validate required fields
    if (!body.full_name || !body.age || !body.gender || !body.contact || !body.address) {
      toast('Please fill in all required fields', 'error');
      btn.disabled = false;
      btn.textContent = 'Save Patient';
      return;
    }

    let res;
    if (state.editingPatient) {
      res = await api(API.patients, 'PUT', { id: state.editingPatient.id, ...body });
    } else {
      res = await api(API.patients, 'POST', body);
    }

    if (res.success) {
      toast(res.message);
      closePatientModal();
      loadPatients(state.searchQuery);
      loadDashboard();
    } else {
      toast(res.message, 'error');
      btn.disabled = false;
      btn.textContent = 'Save Patient';
    }
  } catch (e) {
    console.error('Submit error:', e);
    toast('Error: ' + e.message, 'error');
    btn.disabled = false;
    btn.textContent = 'Save Patient';
  }
}

async function submitRecordForm() {
  const btn = $('#record-submit-btn');
  const form = $('#record-form');
  
  if (btn.disabled) return; // Prevent double submission
  btn.disabled = true;
  btn.textContent = 'Saving...';
  
  try {
    const fd   = new FormData(form);
    const body = Object.fromEntries(fd.entries());
    body.patient_id = state.currentPatient.id;

    let res;
    if (state.editingRecord) {
      res = await api(API.records, 'PUT', { id: state.editingRecord.id, ...body });
    } else {
      res = await api(API.records, 'POST', body);
    }

    if (res.success) {
      toast(res.message);
      closeRecordModal();
      loadPatientRecords(state.currentPatient.id);
      loadDashboard();
    } else {
      toast(res.message, 'error');
      btn.disabled = false;
      btn.textContent = 'Save Record';
    }
  } catch (e) {
    toast('Error: ' + e.message, 'error');
    btn.disabled = false;
    btn.textContent = 'Save Record';
  }
}

function bindForms() {
  // Form submission is now handled directly by submitPatientForm() and submitRecordForm()
  // This function can be kept for future form-related bindings if needed
}

function deletePatient(id, name) {
  confirm(`Delete patient "${name}"? All medical records will also be removed.`, async () => {
    const res = await api(API.patients, 'DELETE', { id });
    if (res.success) {
      toast(res.message);
      loadPatients(state.searchQuery);
      loadDashboard();
    } else {
      toast(res.message, 'error');
    }
  });
}

// ─── Patient Detail / Records ─────────────────
async function viewPatient(id) {
  const res = await api(`${API.patients}?id=${id}`);
  if (!res.success) { toast(res.message, 'error'); return; }

  state.currentPatient = res.patient;
  const p = res.patient;

  $('#detail-name').textContent     = p.full_name;
  $('#detail-pid').textContent      = `${p.patient_id} · ${p.gender} · ${p.age} yrs · Blood Type: ${p.blood_type}`;
  $('#detail-avatar').textContent   = initials(p.full_name);
  $('#detail-records').textContent  = p.total_records ?? 0;
  $('#detail-lastvisit').textContent = p.last_visit ? formatDate(p.last_visit) : '—';
  $('#detail-contact').textContent  = p.contact;
  $('#detail-address').textContent  = p.address;

  navigateTo('patients');
  // Switch to detail view within patients section
  $$('#section-patients .section-view').forEach(v => v.classList.remove('active'));
  $('#patients-detail').classList.add('active');

  loadPatientRecords(id);
}

function backToPatients() {
  $$('#section-patients .section-view').forEach(v => v.classList.remove('active'));
  $('#patients-list').classList.add('active');
  loadPatients(state.searchQuery);
}

async function loadPatientRecords(patientId) {
  const tbody = $('#records-tbody');
  tbody.innerHTML = `<tr class="loading-row"><td colspan="6"><span class="spinner"></span>Loading records...</td></tr>`;

  const res = await api(`${API.records}?patient_id=${patientId}`);
  if (!res.success) { toast(res.message, 'error'); return; }

  if (!res.records.length) {
    tbody.innerHTML = `
      <tr><td colspan="6">
        <div class="empty-state">
          <div class="empty-icon">📋</div>
          <h3>No medical records</h3>
          <p>Add the first medical record for this patient</p>
        </div>
      </td></tr>`;
    return;
  }

  tbody.innerHTML = res.records.map(r => `
    <tr>
      <td>
        <div style="font-weight:600;font-size:0.78rem;color:var(--text-muted)">${esc(r.record_id)}</div>
        <div style="font-size:0.82rem">${formatDate(r.visit_date)}</div>
      </td>
      <td style="font-weight:500">${esc(r.diagnosis)}</td>
      <td style="font-size:0.85rem">${esc(r.treatment)}</td>
      <td>${esc(r.doctor)}</td>
      <td style="font-size:0.82rem;color:var(--text-muted)">${r.notes ? esc(r.notes) : '—'}</td>
      <td>
        <div style="display:flex;gap:6px">
          <button class="btn btn-ghost btn-sm btn-icon" title="Edit" onclick="editRecord(${JSON.stringify(r).split('"').join('&quot;')})">✏️</button>
          <button class="btn btn-danger btn-sm btn-icon" title="Delete" onclick="deleteRecord(${r.id}, '${esc(r.record_id)}')">🗑️</button>
        </div>
      </td>
    </tr>
  `).join('');
}

// ─── Add / Edit Record Modal ──────────────────
function openAddRecord() {
  if (!state.currentPatient) return;
  state.editingRecord = null;
  $('#record-modal-title').textContent = `Add Medical Record — ${state.currentPatient.full_name}`;
  $('#record-form').reset();
  $('#record-visit-date').value = new Date().toISOString().split('T')[0];
  $('#record-modal').classList.add('open');
}

function editRecord(r) {
  state.editingRecord = r;
  $('#record-modal-title').textContent = `Edit Record — ${esc(r.record_id)}`;
  const f = $('#record-form');
  f.visit_date.value = r.visit_date;
  f.diagnosis.value  = r.diagnosis;
  f.treatment.value  = r.treatment;
  f.doctor.value     = r.doctor;
  f.notes.value      = r.notes ?? '';
  $('#record-modal').classList.add('open');
}

function closeRecordModal() {
  $('#record-modal').classList.remove('open');
}

function deleteRecord(id, rid) {
  confirm(`Delete record "${rid}"?`, async () => {
    const res = await api(API.records, 'DELETE', { id });
    if (res.success) {
      toast(res.message);
      loadPatientRecords(state.currentPatient.id);
      loadDashboard();
    } else {
      toast(res.message, 'error');
    }
  });
}

// ─── Utilities ────────────────────────────────
function initials(name) {
  return name.split(' ').slice(0, 2).map(n => n[0]).join('').toUpperCase();
}
function esc(str) {
  if (str === null || str === undefined) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}
function formatDate(d) {
  if (!d) return '—';
  return new Date(d + 'T00:00:00').toLocaleDateString('en-PH', { year: 'numeric', month: 'short', day: 'numeric' });
}

// Close modals on overlay click
document.addEventListener('click', e => {
  if (e.target.id === 'patient-modal') closePatientModal();
  if (e.target.id === 'record-modal')  closeRecordModal();
});
