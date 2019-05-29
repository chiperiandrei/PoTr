<?php

require_once('libraries/Model.php');

class FavoritesModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function loadAvatar()
    {
        $SQL = 'SELECT PATH FROM user_images JOIN users ON ID_USER = ' . Session::get('user_id');

        $result = $this->db->query($SQL);

        if ($result) {
            $result = $result->fetch();
            return $result['PATH'];
        }

        return;
    }

    public function loadPoemsHeader()
    {
        $SQL = 'SELECT p.ID AS POEM_ID, p.ID_AUTHOR AS AUTHOR_ID, p.TITLE AS POEM_TITLE, a.NAME AS AUTHOR_NAME, 
                LOWER(p.LANGUAGE) AS LANGUAGE
                FROM poems p
                JOIN authors a ON p.ID_AUTHOR = a.ID
                JOIN favorites f ON p.ID = f.ID_POEM
                WHERE f.ID_USER="' . Session::get('user_id') . '"';

        $result = [];

        foreach ($this->db->query($SQL) as $row) {
            array_push($result, $row);
        }

        return $result;
    }

    public function loadPoemsBody()
    {
        $poems = $this->loadPoemsHeader();

        $result = [];

        foreach ($poems as $poem)
        {
            $SQL = 'SELECT TEXT AS POEM_CONTENT FROM strophes WHERE NTH = 1 AND ID_POEM = ' . $poem['POEM_ID'];
            $row = $this->db->query($SQL)->fetch();
            array_push( $result, $row['POEM_CONTENT']);
        }

        return $result;
    }

    public function insertFavorites($user_id, $poem_id) {
        $SQL = 'INSERT INTO favorites (ID_USER, ID_POEM) ' .
            'VALUES ('. $user_id .', '. $poem_id .')';
        $statement = $this->db->prepare($SQL);
        $statement->execute();
    }

    public function loadFavorites($user_id) {
        $SQL = 'SELECT ID_POEM FROM favorites WHERE ID_USER = ' . $user_id;
        $statement = $this->db->prepare($SQL);
        $statement->execute();

        $array = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        $i = 0;

        foreach ($array as $row) {
            $result[$i++] = $row['ID_POEM'];
        }

        return $result;
    }

    public function deleteFavorites($user_id, $poem_id) {
        $SQL = 'DELETE FROM favorites WHERE ID_USER = '. $user_id .' AND ID_POEM = '. $poem_id;

        $statement = $this->db->prepare($SQL);
        $statement->execute();
    }
}