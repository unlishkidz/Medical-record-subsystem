-- ============================================
-- Patient Medical Record Management System
-- Database Schema
-- ============================================

CREATE DATABASE IF NOT EXISTS patient_records_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE patient_records_db;

-- Patients Table
CREATE TABLE IF NOT EXISTS patients (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    patient_id  VARCHAR(20) NOT NULL UNIQUE,
    full_name   VARCHAR(100) NOT NULL,
    age         INT NOT NULL CHECK (age > 0 AND age < 150),
    gender      ENUM('Male','Female','Other') NOT NULL,
    blood_type  ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-','Unknown') DEFAULT 'Unknown',
    contact     VARCHAR(20) NOT NULL,
    address     TEXT NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Medical Records Table
CREATE TABLE IF NOT EXISTS medical_records (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    record_id   VARCHAR(20) NOT NULL UNIQUE,
    patient_id  INT NOT NULL,
    visit_date  DATE NOT NULL,
    diagnosis   VARCHAR(255) NOT NULL,
    treatment   TEXT NOT NULL,
    doctor      VARCHAR(100) NOT NULL,
    notes       TEXT,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Sample Data
INSERT INTO patients (patient_id, full_name, age, gender, blood_type, contact, address) VALUES
('P-2024-001', 'Maria Santos',       34, 'Female', 'O+',      '09171234567', 'Molo, Iloilo City'),
('P-2024-002', 'Juan dela Cruz',     52, 'Male',   'A+',      '09281234567', 'Jaro, Iloilo City'),
('P-2024-003', 'Ana Reyes',          28, 'Female', 'B+',      '09391234567', 'La Paz, Iloilo City'),
('P-2024-004', 'Carlos Villanueva',  45, 'Male',   'AB-',     '09461234567', 'Mandurriao, Iloilo City'),
('P-2024-005', 'Liza Banlor',        61, 'Female', 'O-',      '09551234567', 'City Proper, Iloilo City');

INSERT INTO medical_records (record_id, patient_id, visit_date, diagnosis, treatment, doctor, notes) VALUES
('R-2024-001', 1, '2024-03-15', 'Hypertension Stage 1',   'Amlodipine 5mg once daily',         'Dr. Reyes',      'Monitor BP weekly. Reduce salt intake.'),
('R-2024-002', 1, '2024-06-20', 'Hypertension Follow-up', 'Continue Amlodipine, add Losartan',  'Dr. Reyes',      'BP improving. Next visit in 3 months.'),
('R-2024-003', 2, '2024-04-10', 'Type 2 Diabetes',        'Metformin 500mg twice daily',        'Dr. Colmo',      'HbA1c: 7.8. Diet and exercise advised.'),
('R-2024-004', 3, '2024-05-22', 'Acute Pharyngitis',      'Amoxicillin 500mg 3x daily x7 days', 'Dr. Degala',     'Complete antibiotic course. Rest and fluids.'),
('R-2024-005', 4, '2024-07-05', 'Lumbar Strain',          'Ibuprofen 400mg as needed + PT',     'Dr. Villanueva', 'Physical therapy 2x/week for 4 weeks.'),
('R-2024-006', 5, '2024-08-12', 'Osteoarthritis',         'Celecoxib 200mg once daily',         'Dr. Reyes',      'Low-impact exercise. Avoid stairs. Follow-up monthly.');
