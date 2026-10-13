<?php

include_once("db/conn.php");

class Registration
{
    public $conn;

    public function __construct()
    {
        $this->conn = $GLOBALS["conn"];
    }

    public function create($fullName, $schoolName, $interestNames, $isDormitory, $isFinalYear)
    {
        $sql = "INSERT INTO registrations(full_name, school_name, is_dormitory, is_final_year) VALUES (?, ?, ?, ?)";
        $statement = $this->conn->prepare($sql);
        if ($statement === false) {
            return false;
        }

        $statement->bind_param("ssii", $fullName, $schoolName, $isDormitory, $isFinalYear);
        $insertResult = $statement->execute();
        if ($insertResult === false) {
            $statement->close();
            return false;
        }
        $statement->close();

        $registrationId = $this->conn->insert_id;
        $interestInsert = $this->conn->prepare(
            "INSERT INTO registration_interests(registration_id, interest_name) VALUES (?, ?)"
        );

        if ($interestInsert === false) {
            return false;
        }

        foreach ($interestNames as $interestName) {
            $interestInsert->bind_param("is", $registrationId, $interestName);
            $executed = $interestInsert->execute();
            if ($executed === false) {
                $interestInsert->close();
                return false;
            }
        }
        $interestInsert->close();

        return true;
    }

    public function getAll()
    {
        $sql = "SELECT
                    r.id,
                    r.full_name,
                    r.school_name,
                    r.is_dormitory,
                    r.is_final_year,
                    r.created_at,
                    COALESCE(GROUP_CONCAT(ri.interest_name ORDER BY ri.id SEPARATOR ', '), '') AS interests
                FROM registrations r
                LEFT JOIN registration_interests ri ON ri.registration_id = r.id
                GROUP BY r.id, r.full_name, r.school_name, r.is_dormitory, r.is_final_year, r.created_at
                ORDER BY r.created_at DESC, r.id DESC";
        $result = $this->conn->query($sql);
        $registrations = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row["is_dormitory"] = (int) $row["is_dormitory"];
                $row["is_final_year"] = (int) $row["is_final_year"];
                $registrations[] = $row;
            }
        }
        return $registrations;
    }

    public function getStats()
    {
        $sql = "SELECT
                    ri.interest_name,
                    COUNT(*) AS total_applicants,
                    SUM(CASE WHEN r.is_final_year = 1 THEN 1 ELSE 0 END) AS final_year_applicants,
                    SUM(CASE WHEN r.is_dormitory = 1 THEN 1 ELSE 0 END) AS dormitory_applicants,
                    SUM(CASE WHEN r.is_dormitory = 1 AND r.is_final_year = 1 THEN 1 ELSE 0 END) AS dormitory_final_year_applicants
                FROM registration_interests ri
                INNER JOIN registrations r ON r.id = ri.registration_id
                GROUP BY ri.interest_name
                ORDER BY total_applicants DESC, ri.interest_name ASC";
        $result = $this->conn->query($sql);
        $stats = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $stats[] = $row;
            }
        }
        return $stats;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM registrations WHERE id = ?";
        $statement = $this->conn->prepare($sql);
        if ($statement === false) {
            return false;
        }
        $statement->bind_param("i", $id);
        $executed = $statement->execute();
        $affectedRows = $statement->affected_rows;
        $statement->close();

        if ($executed === true && $affectedRows > 0) {
            return true;
        }
        return false;
    }
}
