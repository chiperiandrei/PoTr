<?php

require_once('libraries/Model.php');

class SettingsModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updateInfo($new_firstname1, $new_lastname1, $new_email1, $new_password1, $new_username1)
    {
        $current_user = Session::get('username');
        $SQL1 = 'select * from users where username="' . $current_user . '"';

        $stmt1 = $this->db->prepare($SQL1);
        $stmt1->execute();
        $currentInfo = $stmt1->fetch();


        $new_email = ($new_email1 != null) ? $new_email1 : $currentInfo['EMAIL'];

        $new_lastname = ($new_lastname1 != null) ? $new_lastname1 : $currentInfo['LAST_NAME'];

        $new_firstname = ($new_firstname1 != null) ? $new_firstname1 : $currentInfo['FIRST_NAME'];

        $new_username = ($new_username1 != null) ? $new_username1 : $currentInfo['USERNAME'];

        $new_password = ($new_password1 != null) ? md5($new_password1) : $currentInfo['PASSWORD'];

        $SQL = 'UPDATE users SET FIRST_NAME="' . $new_firstname . '",LAST_NAME="' . $new_lastname . '",EMAIL="' . $new_email . '",USERNAME="' . $new_username . '",PASSWORD="' . $new_password . '" WHERE username="' . $current_user . '"';

        $count = $this->db->exec($SQL);

        if ($count == 1) {

            Session::set('username', $new_username);
            Session::set('first_name', $new_firstname);
            Session::set('last_name', $new_lastname);
            Session::set('email', $new_email);
            rename('storage/users/' . $current_user, 'storage/users/' . $new_username);
            return true;
        } else return false;

    }

    public function verifyUsername($username)
    {
        $SQL = 'SELECT * FROM USERS WHERE USERNAME="' . $username . '"';

        $statement = $this->db->prepare($SQL);

        $statement->execute();

        if ($statement->rowCount() == 0)
            return true;
        else {
            Session::set('update-info-username-already-exists', 'este usernameeul');
            return false;
        }

    }

    public function verifyEmail($email)
    {
        $SQL = 'SELECT * FROM USERS WHERE EMAIL="' . $email . '"';

        $statement = $this->db->prepare($SQL);

        $statement->execute();

        if ($statement->rowCount() == 0)
            return true;
        else {
            Session::set('update-info-email-already-exists', 'este emailuiilul');
            return false;
        }

    }

    /**
     * @param $new_path
     * @param $user_id
     * @return bool
     */
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

    /**
     * @param $user_id
     * @return bool
     */
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

}