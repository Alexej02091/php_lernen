<?php
    include_once('db_zugriff.php');

    class UserModel {
        public int $id;
        public string $role;

        public function __construct(int $id, string $role) {
            $this->id = $id;
            $this->role = $role;
        }
    }

    //Datenbankzugriff für Demo (REPOSITORY)
    class UserRepository {

        public function getUserById(int $id): UserMode {
            if ($id === 1) return new UserModel(1, "admin");
            return new UserModel($id, "user");
        }
    }

    
?>