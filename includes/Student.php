<?php
class Student
{
    private $conn;
    private $table = 'students';

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function addStudent($name, $email, $major)
    {
        $sql = "INSERT INTO " . $this->table . " (name, email, major) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sss', $name, $email, $major);
        return $stmt->execute();
    }

    public function getAllStudents()
    {
        $sql = "SELECT id, name, email, major FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getStudentById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateStudent($id, $name, $email, $major)
    {
        $stmt = $this->conn->prepare("UPDATE students SET name = ?, email = ?, major = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $major, $id);
        return $stmt->execute();
    }

    public function deleteStudent($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
