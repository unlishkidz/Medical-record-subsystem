<?php
/**
 * Simple Test Runner
 * Run tests without external dependencies
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('TESTS_DIR', __DIR__ . '/tests');
define('BASE_PATH', __DIR__);

$passed = 0;
$failed = 0;
$skipped = 0;

class TestRunner {
    public static $passed = 0;
    public static $failed = 0;
    public static $skipped = 0;
    public static $current_test = '';
    
    public static function assert($condition, $message = '') {
        if ($condition) {
            self::$passed++;
            echo "✓ PASS: " . self::$current_test . "\n";
        } else {
            self::$failed++;
            echo "✗ FAIL: " . self::$current_test . " - " . $message . "\n";
        }
    }
    
    public static function skip($message = '') {
        self::$skipped++;
        echo "⊘ SKIP: " . self::$current_test . " - " . $message . "\n";
    }
    
    public static function assertEquals($expected, $actual, $message = '') {
        if ($expected === $actual) {
            self::$passed++;
            echo "✓ PASS: " . self::$current_test . "\n";
        } else {
            self::$failed++;
            echo "✗ FAIL: " . self::$current_test . " - Expected " . var_export($expected, true) . " but got " . var_export($actual, true) . "\n";
        }
    }
}

// Load configuration
require_once BASE_PATH . '/config.php';

// Check PHP version
TestRunner::$current_test = 'PHP version compatibility';
$version = phpversion();
$required = '7.4';
if (version_compare($version, $required, '>=')) {
    TestRunner::assert(true, 'PHP ' . $version . ' (required: ' . $required . '+)');
} else {
    TestRunner::assert(false, 'PHP ' . $version . ' (required: ' . $required . '+)');
}

// Test 1: Check database connection
echo "\n=== UNIT TESTS ===\n";
echo "\n--- Database Connection Test ---\n";

TestRunner::$current_test = 'Database connection';
try {
    $conn = getConnection();
    if ($conn) {
        TestRunner::assert(true, 'Connection successful');
    } else {
        TestRunner::assert(false, 'Connection failed');
    }
    $conn->close();
} catch (Exception $e) {
    TestRunner::assert(false, $e->getMessage());
}

// Test 2: Check patients table exists
TestRunner::$current_test = 'Patients table exists';
try {
    $conn = getConnection();
    $result = $conn->query("SELECT 1 FROM patients LIMIT 1");
    TestRunner::assert($result !== false, 'Table exists');
    $conn->close();
} catch (Exception $e) {
    TestRunner::assert(false, $e->getMessage());
}

// Test 3: Check medical_records table exists
TestRunner::$current_test = 'Medical records table exists';
try {
    $conn = getConnection();
    $result = $conn->query("SELECT 1 FROM medical_records LIMIT 1");
    TestRunner::assert($result !== false, 'Table exists');
    $conn->close();
} catch (Exception $e) {
    TestRunner::assert(false, $e->getMessage());
}

// Test 4: Check sample data exists (optional - can be skipped)
TestRunner::$current_test = 'Sample patients exist (optional)';
try {
    $conn = getConnection();
    $result = $conn->query("SELECT COUNT(*) as count FROM patients");
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        TestRunner::assert(true, 'Sample data loaded: ' . $row['count'] . ' patients');
    } else {
        TestRunner::skip('No sample data loaded. Run: mysql < database.sql');
    }
    $conn->close();
} catch (Exception $e) {
    TestRunner::assert(false, $e->getMessage());
}

// Test 5: Test API endpoint access
echo "\n--- API Endpoint Tests ---\n";
TestRunner::$current_test = 'Patients API exists';
TestRunner::assert(file_exists(BASE_PATH . '/api/patients.php'), 'File exists');

TestRunner::$current_test = 'Records API exists';
TestRunner::assert(file_exists(BASE_PATH . '/api/records.php'), 'File exists');

// Test 6: Test config file
echo "\n--- Configuration Tests ---\n";
TestRunner::$current_test = 'Database host configured';
TestRunner::assert(defined('DB_HOST'), 'DB_HOST constant defined');

TestRunner::$current_test = 'Database name configured';
TestRunner::assert(defined('DB_NAME'), 'DB_NAME constant defined');

TestRunner::$current_test = 'Database user configured';
TestRunner::assert(defined('DB_USER'), 'DB_USER constant defined');

// Test 7: Frontend files
echo "\n--- Frontend Tests ---\n";
TestRunner::$current_test = 'Index page exists';
TestRunner::assert(file_exists(BASE_PATH . '/index.php'), 'File exists');

TestRunner::$current_test = 'App.js exists';
TestRunner::assert(file_exists(BASE_PATH . '/assets/js/app.js'), 'File exists');

TestRunner::$current_test = 'Style.css exists';
TestRunner::assert(file_exists(BASE_PATH . '/assets/css/style.css'), 'File exists');

// Summary
echo "\n=== TEST SUMMARY ===\n";
echo "Passed:  " . TestRunner::$passed . " ✓\n";
echo "Failed:  " . TestRunner::$failed . " ✗\n";
echo "Skipped: " . TestRunner::$skipped . " ⊘\n";
echo "Total:   " . (TestRunner::$passed + TestRunner::$failed + TestRunner::$skipped) . "\n";

if (TestRunner::$failed > 0) {
    exit(1);
} else {
    exit(0);
}
?>
