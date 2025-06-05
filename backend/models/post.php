<?php
class Post {
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addEmployee($data){
        $sql = "INSERT INTO employees(employeeid, firstname, lastname) VALUES (?, ?, ?)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data->employeeid,
                $data->firstname,
                $data->lastname
            ]);
            return ["data" => [], "message" => "Successfully inserted."];
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function editEmployee($data){
        $sql = "UPDATE employees SET employeeid =?, firstname = ?, lastname = ? WHERE id = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data->employeeid,
                $data->firstname,
                $data->lastname,
                $data->id
            ]);
            return ["data" => [], "message" => "Successfully updated."];
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteEmployee($data){
        $sql = "DELETE FROM employees WHERE id = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$data->id]);
            return ["data" => [], "message" => "Successfully deleted."];
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function login($data) {
    $username = $data->username ?? '';
    $password = $data->password ?? '';

    $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Don't return the password hash back to frontend
            unset($user['password']);
            return ["success" => true, "user" => $user];
        } else {
            return ["success" => false, "message" => "Invalid password."];
        }
    } else {
        return ["success" => false, "message" => "User not found."];
    }
}


    public function registerAccount($data) {
    $username = $data->username ?? '';
    $password = $data->password ?? '';

    if (!$username || !$password) {
        return ["success" => false, "message" => "Missing username or password"];
    }

    // Check if user exists
    $check = $this->pdo->prepare("SELECT * FROM accounts WHERE username = ?");
    $check->execute([$username]);
    if ($check->fetch()) {
        return ["success" => false, "message" => "Username already taken"];
    }

    // Hash and insert
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->pdo->prepare("INSERT INTO accounts (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashed]);

    return ["success" => true, "message" => "Account created"];
}

public function addTimeIn($data) {
    $stmt = $this->pdo->prepare("INSERT INTO dtr (employeeid, timein) VALUES (?, NOW())");
    $stmt->execute([$data->employeeid]);
    return ["success" => true, "message" => "Time In recorded"];
}



public function addTimeOut($data) {
    $stmt = $this->pdo->prepare("UPDATE dtr SET timeout = NOW() WHERE employeeid = ? AND timeout IS NULL ORDER BY id DESC LIMIT 1");
    $stmt->execute([$data->employeeid]);
    if ($stmt->rowCount() > 0) {
        return ["success" => true, "message" => "Time Out recorded"];
    } else {
        return ["success" => false, "message" => "No matching Time In found"];
    }
}





}
?>
