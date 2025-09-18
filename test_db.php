<?php
require_once __DIR__ . '/include/Dbconfig.php';

try {
    $dbConnection = new DbConnection();
    $conn = $dbConnection->getConnection();
    
    echo "Database connection successful!\n";
    
    // Check if tables exist
    $tables = ['hslhs_kids_email', 'hslhs_kids_phone', 'hslhs_kids_registration_meta'];
    
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
        } else if ($table === 'hslhs_kids_registration_meta') {
            echo "Creating table hslhs_kids_registration_meta...\n";
            $conn->exec("CREATE TABLE IF NOT EXISTS hslhs_kids_registration_meta (
                id INT AUTO_INCREMENT PRIMARY KEY,
                reg_table ENUM('email','phone') NOT NULL,
                reg_id INT NOT NULL,
                reg_month CHAR(3) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_reg (reg_table, reg_id),
                INDEX idx_month (reg_month)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
            echo "Created.\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 