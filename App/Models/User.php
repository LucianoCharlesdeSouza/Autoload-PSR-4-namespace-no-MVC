<?php

namespace App\Models;

use App\Core\Model;

class User extends Model {

    private $Table = "usuarios";
    private $Result = null;

    public function getResult() {
        return $this->Result;
    }

    public function selectAll() {
        $sql = $this->db->prepare("SELECT * FROM " . $this->Table);
        try {
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->Result = $sql->fetchAll(\PDO::FETCH_ASSOC);
                return true;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

}
