<?php
/**
 * Patient Validation Tests
 * Tests input validation for patient records
 */

// Simple validation test cases
class PatientValidationTests {
    
    public static function testValidPatientData() {
        $patientData = [
            'full_name' => 'John Doe',
            'age' => 34,
            'gender' => 'Male',
            'contact' => '09171234567',
            'address' => 'Manila, Philippines'
        ];
        
        return self::validatePatient($patientData);
    }
    
    public static function testInvalidAge() {
        $patientData = [
            'full_name' => 'John Doe',
            'age' => -5,  // Invalid age
            'gender' => 'Male',
            'contact' => '09171234567',
            'address' => 'Manila'
        ];
        
        return !self::validatePatient($patientData);
    }
    
    public static function testMissingRequiredField() {
        $patientData = [
            'full_name' => 'John Doe',
            // missing age
            'gender' => 'Male',
            'contact' => '09171234567',
            'address' => 'Manila'
        ];
        
        return !self::validatePatient($patientData);
    }
    
    public static function testEmailFormat() {
        $email = 'test@example.com';
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    private static function validatePatient($data) {
        if (empty($data['full_name']) || empty($data['age']) || empty($data['gender'])) {
            return false;
        }
        
        $age = (int)$data['age'];
        if ($age < 1 || $age > 150) {
            return false;
        }
        
        return true;
    }
}

// Run tests
$tests = [
    'Valid patient data' => PatientValidationTests::testValidPatientData(),
    'Invalid age' => PatientValidationTests::testInvalidAge(),
    'Missing required field' => PatientValidationTests::testMissingRequiredField(),
    'Email format validation' => PatientValidationTests::testEmailFormat(),
];

echo "Patient Validation Tests:\n";
echo "========================\n";
foreach ($tests as $name => $result) {
    echo ($result ? "✓" : "✗") . " " . $name . "\n";
}
?>
