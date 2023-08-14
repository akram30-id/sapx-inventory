<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('repository_model');
    }

    private function jsonOutputSuccess($data = null, $statusCode = 200, $message = "Showing Result")
    {
        header("Content-type: application/json");
        echo json_encode([
            "status_code" => $statusCode,
            "message" => $message,
            "data" => $data,
        ]);
    }

    public function index()
    {
        try {
            $users = $this->repository_model->getAll("users")->result();

            return $this->jsonOutputSuccess($users);
        } catch (\Throwable $th) {
            return $this->jsonOutputSuccess(NULL, 500, strval($th));
        }
    }

    public function create()
    {
        try {
            $email = $this->input->post("email");
            $password = $this->input->post("password");

            $data = [
                "email" => $email,
                "password" => md5("!sapX_" . $password . "_!nventory"),
                "created_at" => date('d-M-Y H:i:s')
            ];

            $validation = [
                [
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|valid_email|max_length[24]|is_unique[users.email]'
                ],
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required|min_length[8]|max_length[16]',
                ],
            ];

            $this->form_validation->set_rules($validation);

            if ($this->form_validation->run() == FALSE) {
                return $this->jsonOutputSuccess(NULL, 406, validation_errors());
            }

            $save = $this->repository_model->insert("users", $data);

            if ($save) {
                return $this->jsonOutputSuccess([
                    "email" => $data["email"],
                ], 201, "Register Success");
            } else {
                return $this->jsonOutputSuccess(NULL, 500, "Internal Server Error");
            }

        } catch (\Throwable $th) {
            return $this->jsonOutputSuccess(NULL, 500, "Internal Server Error");
        }
    }
}
 