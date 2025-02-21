<?php
require_once '../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getUserProfile($user_id)
    {
        return $this->userModel->getUserById($user_id);
    }
}
