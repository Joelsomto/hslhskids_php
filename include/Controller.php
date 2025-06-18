<?php
require_once('Crud.php');

class Controller
{
    private $crud;

    public function __construct()
    {
        $this->crud = new Crud();
    }

    public function registerUser($data)
    {
        $table = "users";
        $lastInsertedId = $this->crud->create($data, $table);
        return $lastInsertedId;
    }
    

    // public function isUserRegistered($email, $conn)
    // {
    //     try {
    //         $query = "SELECT COUNT(*) FROM users WHERE email = :email AND roles = 'u'";

    //         $stmt = $conn->prepare($query);
    //         $stmt->bindParam(':email', $email);
    //         $stmt->execute();

    //         $count = $stmt->fetchColumn();

    //         return $count > 0;
    //     } catch (PDOException $e) {
    //         // Handle database query errors here
    //         return false;
    //     }
    // }
   // In your Controller class
    public function checkExistingUser($email = null, $phone = null, $countryCode = null)
    {
        if ($email) {
            $sql = "SELECT id FROM hslhs_kids_email WHERE email = :email LIMIT 1";
            $params = [':email' => $email];
        } elseif ($phone && $countryCode) {
            $sql = "SELECT id FROM hslhs_kids_phone WHERE country_code = :country_code AND phone = :phone LIMIT 1";
            $params = [':country_code' => $countryCode, ':phone' => $phone];
        } else {
            return false;
        }

        $result = $this->crud->read($sql, $params);
        return !empty($result);
    }

    public function registerKids($data)
    {
        $usingEmail = isset($data['email']);
        
        if ($usingEmail) {
            $table = "hslhs_kids_email";
            unset($data['phone']);
            unset($data['country_code']);
        } else {
            $table = "hslhs_kids_phone";
            unset($data['email']);
            
            // Validate phone format
            if (!preg_match('/^\d{8,15}$/', $data['phone'])) {
                throw new Exception("Phone number must be 8-15 digits");
            }
        }
        
        $lastInsertedId = $this->crud->create($data, $table);
        return $lastInsertedId;
    }

    public function markMagazineDownloaded($id, $isEmailRegistration)
    {
        $table = $isEmailRegistration ? "hslhs_kids_email" : "hslhs_kids_phone";
        $sql = "UPDATE $table SET mag_download = 1 WHERE id = :id";
        return $this->crud->update($sql, [':id' => $id]);
    }


    
}