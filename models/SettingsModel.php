<?php

require_once('libraries/Model.php');

class SettingsModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private function verifyUser($user_id)
    {
        $SQL = 'SELECT * FROM user_images WHERE id_user="' . $user_id . '"';
        $result = $this->db->prepare($SQL);
        $result->execute();
        if ($result->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePhoto($new_path, $user_id)
    {
        if ($this->verifyUser($user_id)) {
            $SQL = 'UPDATE user_images SET PATH="' . $new_path . '" WHERE ID_USER="' . $user_id . '"';

            $statement = $this->db->prepare($SQL);

            if ($statement->execute())
                return true;
            else
                return false;
        } else {
            $SQL = 'INSERT INTO user_images(id_user,path) VALUES (:id,:path)';

            $result = $this->db->prepare($SQL);
            return $result->execute([
                ':id' => $user_id,
                ':path' => $new_path
            ]) ? true : false;
        }
    }

    public function deletePhoto($user_id)
    {
        $SQL = 'DELETE FROM user_images WHERE ID_USER = ' . $user_id;

        $statement = $this->db->prepare($SQL);

        $statement->execute();
    }

    public function verifyUsername($username)
    {
        $SQL = 'SELECT * FROM users WHERE username="' . $username . '" AND username <> "' . Session::get('username') . '"';

        $statement = $this->db->prepare($SQL);

        $statement->execute();

        if ($statement->rowCount() == 0)
            return false;
        else {
            return true;
        }
    }

    public function updateUsername($new_username)
    {
        $current_user = Session::get('username');
        $SQL1 = 'SELECT * FROM users WHERE USERNAME="' . $current_user . '"';

        $stmt1 = $this->db->prepare($SQL1);
        $stmt1->execute();
        $currentInfo = $stmt1->fetch();

        $this->new_username = ($new_username != null) ? $new_username : $currentInfo['USERNAME'];

        $SQL = 'UPDATE users SET USERNAME="' . $this->new_username . '" WHERE username="' . $current_user . '"';
        rename('storage/users/'.$currentInfo['USERNAME'],'storage/users/'.$new_username);
        Session::set('username',$this->new_username);
        Session::set('user_link', '/user/' . $this->new_username);
        $stmt = $this->db->prepare($SQL);
        $stmt->execute();
    }

    public function updateFirstName($new_firstname)
    {
        $current_user = Session::get('username');
        $SQL1 = 'SELECT * FROM users WHERE USERNAME="' . $current_user . '"';

        $stmt1 = $this->db->prepare($SQL1);
        $stmt1->execute();
        $currentInfo = $stmt1->fetch();

        $this->new_firstname = ($new_firstname != null) ? $new_firstname : $currentInfo['FIRST_NAME'];

        $SQL = 'UPDATE users SET FIRST_NAME="' . $this->new_firstname . '" WHERE username="' . $current_user . '"';
        Session::set('first_name', $this->new_firstname);

        $stmt = $this->db->prepare($SQL);
        $stmt->execute();
    }

    public function updateLastName($new_lastname)
    {
        $current_user = Session::get('username');
        $SQL1 = 'SELECT * FROM users WHERE USERNAME="' . $current_user . '"';

        $stmt1 = $this->db->prepare($SQL1);
        $stmt1->execute();
        $currentInfo = $stmt1->fetch();

        $this->new_lastname = ($new_lastname != null) ? $new_lastname : $currentInfo['LAST_NAME'];

        $SQL = 'UPDATE users SET LAST_NAME="' . $this->new_lastname . '" WHERE USERNAME="' . $current_user . '"';
        Session::set('last_name', $this->new_lastname);

        $stmt = $this->db->prepare($SQL);
        $stmt->execute();
    }

    public function verifyPassword($password)
    {
        $SQL = 'SELECT PASSWORD FROM users WHERE USERNAME = "' . Session::get('username') . '" AND ID = ' . Session::get('user_id');

        $statement = $this->db->prepare($SQL);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result['PASSWORD'] == strtoupper(md5($password))) {
            return true;
        }

        return false;
    }

    public function updatePassword($password) {
        $password = strtoupper(md5($password));

        $SQL = 'UPDATE users SET PASSWORD = "' . $password . '" WHERE USERNAME="' . Session::get('username') . '"';

        $stmt = $this->db->prepare($SQL);

        $stmt->execute();
    }

}