<?php

require_once("Models/PostModel.php");

class PostController
{
    public function __construct()
    {

        $this->model = new PostModel();
    }

    public function addPoem($poem)
    {

        if ($this->model->addPoemIntoDb($poem)) {
            $array['data'] = "Poem added succesfully";
            header('Content-Type: application/json');
            echo json_encode($array);
        } else {
            $array['data'] = "Error during adding the poem ";
            header('Content-Type: application/json');
            echo json_encode($array);
        }
    }
}