<?php

class User {

    public $user;

    public function __construct($con, $user) {
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE user_nickname='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }

    public function getUserId() {
        return $this->user['user_id'];
    }

    public function getUserNickname() {
        return $this->user['user_nickname'];
    }

    public function getUserEmail() {
        return $this->user['user_email'];
    }

    public function getUserPassword() {
        return $this->user['user_password'];
    }

    public function getUserStatus() {
        return $this->user['user_account_status'];
    }

    public function getUserRole() {
        return $this->user['user_role'];
    }

    public function getUserSession() {
        return $this->user['user_session'];
    }
}

?>
