<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediRec — Patient Record Management System</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ═══════════════════════════════════════════
     SIDEBAR
════════════════════════════════════════════ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🏥</div>
    <h1>MediRec</h1>
    <span>Patient Record System</span>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-label">Main Menu</div>

    <button class="nav-item active" data-section="dashboard">
      <span class="nav-icon">📊</span>
      Dashboard
    </button>

    <button class="nav-item" data-section="patients">
      <span class="nav-icon">👤</span>
      Patients
      <span class="nav-badge" id="nav-badge-patients">0</span>
    </button>

    <div class="nav-label" style="margin-top:12px">System</div>

    <div class="nav-item" style="cursor:default;opacity:0.5">
      <span class="nav-icon">⚙️</span>
      Settings
    </div>
  </nav>

  <div class="sidebar-footer">
    <p>Practical Activity Assessment 1<br>BSCS 3-B · PHP + MySQL</p>
  </div>
</aside>

<!-- ═══════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════════ -->
<main class="main">

  <!-- Topbar -->
  <header class="topbar">
    <div class="topbar-left">
      <h2 id="topbar-title">Dashboard</h2>
      <p id="topbar-sub">Overview of patient management system</p>
    </div>
    <div class="topbar-right">
      <div class="topbar-search">
        <span>🔍</span>
        <input type="text" id="search-input" placeholder="Search patients…">
      </div>
    </div>
  </header>

  <div class="page-content">

    <!-- ─────────────────────────────────────────
         SECTION: DASHBOARD
    ────────────────────────────────────────── -->
    <div id="section-dashboard" class="section active">

      <!-- Stats -->
      <div class="stats-grid">
        <div class="stat-card" style="animation-delay:0.05s">
          <div class="stat-icon blue">👥</div>
          <div class="stat-info">
            <h3 id="stat-total">—</h3>
            <p>Total Patients</p>
          </div>
        </div>
        <div class="stat-card" style="animation-delay:0.1s">
          <div class="stat-icon teal">📋</div>
          <div class="stat-info">
            <h3 id="stat-records">—</h3>
            <p>Medical Records</p>
          </div>
        </div>
        <div class="stat-card" style="animation-delay:0.15s">
          <div class="stat-icon amber">📅</div>
          <div class="stat-info">
            <h3 id="stat-today">—</h3>
            <p>Visits Today</p>
          </div>
        </div>
      </div>

      <!-- Dashboard Grid -->
      <div class="dashboard-grid">
        <!-- Recent Patients Table -->
        <div class="card">
          <div class="card-header">
            <h3>Recent Patients</h3>
            <button class="btn btn-primary btn-sm" onclick="navigateTo('patients')">View All →</button>
          </div>
          <div style="overflow-x:auto">
            <table>
              <thead>
                <tr>
                  <th>Patient</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>Records</th>
                  <th>Last Visit</th>
                </tr>
              </thead>
              <tbody id="recent-patients-body">
                <tr class="loading-row"><td colspan="5"><span class="spinner"></span>Loading…</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Gender Chart -->
        <div class="card">
          <div class="card-header">
            <h3>Gender Distribution</h3>
          </div>
          <div class="card-body" style="display:flex;flex-direction:column;align-items:center;gap:20px">
            <canvas id="gender-canvas" width="160" height="160"></canvas>
            <div class="gender-legend" id="gender-legend"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- ─────────────────────────────────────────
         SECTION: PATIENTS
    ────────────────────────────────────────── -->
    <div id="section-patients" class="section">

      <!-- List View -->
      <div id="patients-list" class="section-view active">
        <div class="table-wrap">
          <div class="table-toolbar">
            <h3>All Patients</h3>
            <div class="table-toolbar-right">
              <div class="search-box">
                <span>🔍</span>
                <input type="text" id="patient-search" placeholder="Search name or ID…">
              </div>
              <button class="btn btn-primary" onclick="openAddPatient()">
                ＋ Add Patient
              </button>
            </div>
          </div>
          <table>
            <thead>
              <tr>
                <th>Patient</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Blood Type</th>
                <th>Contact</th>
                <th>Records</th>
                <th>Last Visit</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="patients-tbody">
              <tr class="loading-row"><td colspan="8"><span class="spinner"></span>Loading…</td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Detail View -->
      <div id="patients-detail" class="section-view">

        <!-- Patient Header -->
        <div class="patient-header-card">
          <div class="patient-avatar" id="detail-avatar">—</div>
          <div class="patient-header-info">
            <h2 id="detail-name">—</h2>
            <p id="detail-pid">—</p>
            <p id="detail-address" style="margin-top:6px;opacity:0.7;font-size:0.8rem">—</p>
          </div>
          <div class="patient-header-meta">
            <div>
              <span id="detail-records">0</span>
              <span>Records</span>
            </div>
            <div>
              <span id="detail-lastvisit">—</span>
              <span>Last Visit</span>
            </div>
            <div>
              <span id="detail-contact">—</span>
              <span>Contact</span>
            </div>
          </div>
        </div>

        <!-- Medical Records Table -->
        <div class="table-wrap">
          <div class="table-toolbar">
            <div style="display:flex;align-items:center;gap:12px">
              <button class="btn btn-ghost btn-sm" onclick="backToPatients()">← Back</button>
              <h3>Medical Records</h3>
            </div>
            <button class="btn btn-accent" onclick="openAddRecord()">
              ＋ Add Record
            </button>
          </div>
          <table>
            <thead>
              <tr>
                <th>Visit</th>
                <th>Diagnosis</th>
                <th>Treatment</th>
                <th>Doctor</th>
                <th>Notes</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="records-tbody">
              <tr class="loading-row"><td colspan="6"><span class="spinner"></span>Loading…</td></tr>
            </tbody>
          </table>
        </div>
      </div>

    </div><!-- /section-patients -->

  </div><!-- /page-content -->
</main>

<!-- ═══════════════════════════════════════════
     MODAL: ADD / EDIT PATIENT
════════════════════════════════════════════ -->
<div class="modal-overlay" id="patient-modal">
  <div class="modal">
    <div class="modal-header">
      <h3 id="patient-modal-title">Add New Patient</h3>
      <button class="modal-close" onclick="closePatientModal()">✕</button>
    </div>
    <div class="modal-body">
      <form id="patient-form" autocomplete="off">
        <div class="form-grid">
          <div class="form-group full">
            <label>Full Name *</label>
            <input type="text" name="full_name" placeholder="e.g. Maria Santos" required>
          </div>
          <div class="form-group">
            <label>Age *</label>
            <input type="number" name="age" min="1" max="149" placeholder="e.g. 34" required>
          </div>
          <div class="form-group">
            <label>Gender *</label>
            <select name="gender" required>
              <option value="">Select gender</option>
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Blood Type</label>
            <select name="blood_type">
              <option value="Unknown">Unknown</option>
              <option>A+</option><option>A-</option>
              <option>B+</option><option>B-</option>
              <option>AB+</option><option>AB-</option>
              <option>O+</option><option>O-</option>
            </select>
          </div>
          <div class="form-group">
            <label>Contact Number *</label>
            <input type="text" name="contact" placeholder="09XXXXXXXXX" required>
          </div>
          <div class="form-group full">
            <label>Address *</label>
            <input type="text" name="address" placeholder="e.g. Molo, Iloilo City" required>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closePatientModal()">Cancel</button>
      <button class="btn btn-primary" onclick="$('#patient-form').requestSubmit()">Save Patient</button>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════
     MODAL: ADD / EDIT MEDICAL RECORD
════════════════════════════════════════════ -->
<div class="modal-overlay" id="record-modal">
  <div class="modal">
    <div class="modal-header">
      <h3 id="record-modal-title">Add Medical Record</h3>
      <button class="modal-close" onclick="closeRecordModal()">✕</button>
    </div>
    <div class="modal-body">
      <form id="record-form" autocomplete="off">
        <div class="form-grid">
          <div class="form-group">
            <label>Visit Date *</label>
            <input type="date" name="visit_date" id="record-visit-date" required>
          </div>
          <div class="form-group">
            <label>Doctor *</label>
            <input type="text" name="doctor" placeholder="e.g. Dr. Reyes" required>
          </div>
          <div class="form-group full">
            <label>Diagnosis *</label>
            <input type="text" name="diagnosis" placeholder="e.g. Hypertension Stage 1" required>
          </div>
          <div class="form-group full">
            <label>Treatment *</label>
            <textarea name="treatment" placeholder="Medications, procedures, recommendations…" required></textarea>
          </div>
          <div class="form-group full">
            <label>Notes</label>
            <textarea name="notes" placeholder="Additional observations, follow-up instructions…"></textarea>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeRecordModal()">Cancel</button>
      <button class="btn btn-accent" onclick="$('#record-form').requestSubmit()">Save Record</button>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════
     CONFIRM DIALOG
════════════════════════════════════════════ -->
<div class="confirm-overlay" id="confirm-overlay">
  <div class="confirm-dialog">
    <div class="confirm-icon">⚠️</div>
    <h3>Confirm Action</h3>
    <p id="confirm-msg">Are you sure?</p>
    <div class="confirm-actions">
      <button class="btn btn-ghost" id="confirm-no">Cancel</button>
      <button class="btn btn-danger" id="confirm-yes">Yes, Delete</button>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════
     TOAST CONTAINER
════════════════════════════════════════════ -->
<div class="toast-container" id="toast-container"></div>

<script src="assets/js/app.js"></script>
</body>
</html>
