<?php
require_once __DIR__ . '/include/Dbconfig.php';

try {
    $dbConnection = new DbConnection();
    $conn = $dbConnection->getConnection();
    
    echo "Database connection successful!\n";
    
    // Check if tables exist
    $tables = ['hslhs_kids_email', 'hslhs_kids_phone'];
    
    foreach ($tables as $table) {
        $stmt = $conn->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$table]);
        $exists = $stmt->rowCount() > 0;
        
        echo "Table '$table': " . ($exists ? "EXISTS" : "NOT FOUND") . "\n";
        
        if ($exists) {
            // Show table structure
            $stmt = $conn->prepare("DESCRIBE $table");
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "Columns in $table:\n";
            foreach ($columns as $column) {
                echo "  - {$column['Field']} ({$column['Type']})\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 