<?php
// ============================================
// API: Patients
// ============================================
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$conn   = getConnection();

switch ($method) {

    // ── GET: List all patients OR single patient ──────────────────────────
    case 'GET':
        if (isset($_GET['id'])) {
            $id   = (int) $_GET['id'];
            $stmt = $conn->prepare(
                "SELECT p.*,
                        COUNT(r.id) AS total_records,
                        MAX(r.visit_date) AS last_visit
                 FROM patients p
                 LEFT JOIN medical_records r ON r.patient_id = p.id
                 WHERE p.id = ?
                 GROUP BY p.id"
            );
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $patient = $stmt->get_result()->fetch_assoc();
            if (!$patient) jsonResponse(false, 'Patient not found.');
            jsonResponse(true, 'Patient fetched.', ['patient' => $patient]);
        }

        // Stats for dashboard
        if (isset($_GET['stats'])) {
            $stats = [];
            $stats['total_patients']  = $conn->query("SELECT COUNT(*) c FROM patients")->fetch_assoc()['c'];
            $stats['total_records']   = $conn->query("SELECT COUNT(*) c FROM medical_records")->fetch_assoc()['c'];
            $stats['visits_today']    = $conn->query("SELECT COUNT(*) c FROM medical_records WHERE visit_date = CURDATE()")->fetch_assoc()['c'];
            $stats['recent_patients'] = $conn->query(
                "SELECT p.patient_id, p.full_name, p.age, p.gender, MAX(r.visit_date) AS last_visit,
                        COUNT(r.id) AS records
                 FROM patients p
                 LEFT JOIN medical_records r ON r.patient_id = p.id
                 GROUP BY p.id ORDER BY p.created_at DESC LIMIT 5"
            )->fetch_all(MYSQLI_ASSOC);
            $stats['gender_dist']     = $conn->query(
                "SELECT gender, COUNT(*) AS count FROM patients GROUP BY gender"
            )->fetch_all(MYSQLI_ASSOC);
            jsonResponse(true, 'Stats fetched.', ['stats' => $stats]);
        }

        // Full list with search
        $search = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';
        $result = $conn->query(
            "SELECT p.*, COUNT(r.id) AS total_records, MAX(r.visit_date) AS last_visit
             FROM patients p
             LEFT JOIN medical_records r ON r.patient_id = p.id
             WHERE p.full_name LIKE '$search' OR p.patient_id LIKE '$search'
             GROUP BY p.id
             ORDER BY p.created_at DESC"
        );
        jsonResponse(true, 'Patients fetched.', ['patients' => $result->fetch_all(MYSQLI_ASSOC)]);
        break;

    // ── POST: Add new patient ─────────────────────────────────────────────
    case 'POST':
        $input = file_get_contents('php://input');
        error_log('POST Input: ' . $input); // Debug log
        
        $data = json_decode($input, true);
        
        if (!$data) {
            jsonResponse(false, 'Invalid JSON data');
        }

        error_log('Decoded data: ' . json_encode($data)); // Debug log

        $required = ['full_name', 'age', 'gender', 'contact', 'address'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                jsonResponse(false, "Field '$field' is required.");
            }
        }

        // Auto-generate patient ID
        $row   = $conn->query("SELECT MAX(id) AS max_id FROM patients")->fetch_assoc();
        $nextId = ($row['max_id'] ?? 0) + 1;
        $pid   = 'P-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Check duplicate
        $check = $conn->prepare("SELECT id FROM patients WHERE patient_id = ?");
        $check->bind_param('s', $pid);
        $check->execute();
        if ($check->get_result()->num_rows > 0) jsonResponse(false, 'Patient ID already exists.');

        $stmt = $conn->prepare(
            "INSERT INTO patients (patient_id, full_name, age, gender, blood_type, contact, address)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        
        if (!$stmt) {
            jsonResponse(false, 'Prepare failed: ' . $conn->error);
        }
        
        $name    = $data['full_name'];
        $age     = (int) $data['age'];
        $gender  = $data['gender'];
        $blood   = $data['blood_type'] ?? 'Unknown';
        $contact = $data['contact'];
        $address = $data['address'];
        
        error_log("Binding: pid=$pid, name=$name, age=$age, gender=$gender, blood=$blood, contact=$contact, address=$address"); // Debug log
        
        $stmt->bind_param('ssissss', $pid, $name, $age, $gender, $blood, $contact, $address);

        if ($stmt->execute()) {
            jsonResponse(true, 'Patient added successfully.', ['patient_id' => $pid]);
        } else {
            jsonResponse(false, 'Failed to add patient: ' . $stmt->error);
        }
        $stmt->close();
        break;

    // ── PUT: Update patient ───────────────────────────────────────────────
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['id'])) jsonResponse(false, 'Patient ID required.');

        $id      = (int) $data['id'];
        $name    = $data['full_name']  ?? '';
        $age     = (int)($data['age'] ?? 0);
        $gender  = $data['gender']     ?? '';
        $blood   = $data['blood_type'] ?? 'Unknown';
        $contact = $data['contact']    ?? '';
        $address = $data['address']    ?? '';

        $stmt = $conn->prepare(
            "UPDATE patients SET full_name=?, age=?, gender=?, blood_type=?, contact=?, address=? WHERE id=?"
        );
        $stmt->bind_param('siisssi', $name, $age, $gender, $blood, $contact, $address, $id);

        if ($stmt->execute()) jsonResponse(true, 'Patient updated successfully.');
        jsonResponse(false, 'Failed to update patient.');
        break;

    // ── DELETE: Remove patient ────────────────────────────────────────────
    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);
        if (!$id) jsonResponse(false, 'Invalid patient ID.');

        $stmt = $conn->prepare("DELETE FROM patients WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) jsonResponse(true, 'Patient deleted successfully.');
        jsonResponse(false, 'Failed to delete patient.');
        break;

    default:
        jsonResponse(false, 'Method not allowed.');
}

$conn->close();
