<?php
// ============================================
// API: Medical Records
// ============================================
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$conn   = getConnection();

switch ($method) {

    // ── GET: Records for a patient ────────────────────────────────────────
    case 'GET':
        $patient_id = (int)($_GET['patient_id'] ?? 0);
        if (!$patient_id) jsonResponse(false, 'patient_id is required.');

        $result = $conn->prepare(
            "SELECT r.*, p.full_name, p.patient_id AS pid
             FROM medical_records r
             JOIN patients p ON p.id = r.patient_id
             WHERE r.patient_id = ?
             ORDER BY r.visit_date DESC"
        );
        $result->bind_param('i', $patient_id);
        $result->execute();
        jsonResponse(true, 'Records fetched.', ['records' => $result->get_result()->fetch_all(MYSQLI_ASSOC)]);
        break;

    // ── POST: Add medical record ──────────────────────────────────────────
    case 'POST':
        // Get JSON data from request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            jsonResponse(false, 'Invalid JSON data received');
        }
        
        // Validate required fields
        $required_fields = ['patient_id', 'visit_date', 'diagnosis', 'treatment', 'doctor'];
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                jsonResponse(false, "Field '$field' is required");
            }
        }
        
        // Generate unique record ID
        $result = $conn->query("SELECT COUNT(*) as count FROM medical_records");
        $count = $result->fetch_assoc()['count'] + 1;
        $record_id = 'R-' . date('Y') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        
        // Prepare data for insertion
        $patient_id = (int)$data['patient_id'];
        $visit_date = $data['visit_date'];
        $diagnosis = trim($data['diagnosis']);
        $treatment = trim($data['treatment']);
        $doctor = trim($data['doctor']);
        $notes = isset($data['notes']) ? trim($data['notes']) : '';
        
        // Insert record
        $stmt = $conn->prepare(
            "INSERT INTO medical_records (record_id, patient_id, visit_date, diagnosis, treatment, doctor, notes) 
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        
        if (!$stmt) {
            jsonResponse(false, 'Database error: ' . $conn->error);
        }
        
        $stmt->bind_param('sisssss', $record_id, $patient_id, $visit_date, $diagnosis, $treatment, $doctor, $notes);
        
        if ($stmt->execute()) {
            jsonResponse(true, 'Medical record added successfully', [
                'record_id' => $record_id,
                'id' => $conn->insert_id
            ]);
        } else {
            jsonResponse(false, 'Failed to add record: ' . $stmt->error);
        }
        
        $stmt->close();
        break;
        break;

    // ── PUT: Update medical record ────────────────────────────────────────
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['id'])) jsonResponse(false, 'Record ID required.');

        $id         = (int) $data['id'];
        $visit_date = $data['visit_date'] ?? '';
        $diagnosis  = $data['diagnosis']  ?? '';
        $treatment  = $data['treatment']  ?? '';
        $doctor     = $data['doctor']     ?? '';
        $notes      = $data['notes']      ?? '';

        $stmt = $conn->prepare(
            "UPDATE medical_records SET visit_date=?, diagnosis=?, treatment=?, doctor=?, notes=? WHERE id=?"
        );
        $stmt->bind_param('sssssi', $visit_date, $diagnosis, $treatment, $doctor, $notes, $id);
        if ($stmt->execute()) jsonResponse(true, 'Record updated successfully.');
        jsonResponse(false, 'Failed to update record.');
        break;

    // ── DELETE: Remove medical record ─────────────────────────────────────
    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $id   = (int)($data['id'] ?? 0);
        if (!$id) jsonResponse(false, 'Invalid record ID.');

        $stmt = $conn->prepare("DELETE FROM medical_records WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) jsonResponse(true, 'Record deleted successfully.');
        jsonResponse(false, 'Failed to delete record.');
        break;

    default:
        jsonResponse(false, 'Method not allowed.');
}

$conn->close();
