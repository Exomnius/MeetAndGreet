<?php

/**
 * @author FIRSTNAME LASTNAME   <EMAIL>
 */

/**
 * Model with all of the user functions.
 */
class User_model extends CI_Model {

    /**
     * Validates the username and password. Returns true if succeeded, false if failed.
     * 
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public function validate_credentials($username, $password) {

        $result = $this->db->select('*')->from('tbl_users')->where(array('username' => $username, 'password' => $this->encrypt_password($password)))->get();

//        if ($result->num_rows() == 1)
        return $result->row();
//        else {
//            echo $password;
//            echo '<br/>'. $this->encrypt_password($password).'<br/>';
//            $this->db->select('*')->from('tbl_pass_recovery')->join('tbl_users', 'tbl_users.userid=tbl_pass_recovery.userid')->where('username', $username)->where('expdate <', date('Y-m-d H:i:s', time()))->where('pass', $this->encrypt_password($password));
//            $result = $this->db->get();
//            var_dump($result);
//            if ($result->num_rows() == 1) {
//                echo 'zeik';
//                $user=$result->row();
//                $this->reset_pw($user->userid, $password);
//                $this->db->where('userid', $user->userid)->or_where('expdate >', date('Y-m-d H:i:s', time()))->delete('tbl_pass_recovery');
//                $result = $this->db->select('*')->from('tbl_users')->where(array('username' => $username, 'password' => $this->encrypt_password($password)))->get();
//                return $result->row();
//            }
//
//            return false;
//    }
    }

    /**
     * Provides double hashing algorithm and salt for optimal security
     * 
     * @param type $password
     * @return type
     */
    public function encrypt_password($password) {
        $salt = sha1(md5($password));
        $encryptedPassword = md5($password . $salt);

        return $encryptedPassword;
    }

    /**
     * Adds a user to the tbl_users_non_activated.
     * 
     * @param type $username
     * @param type $firstname
     * @param type $lastname
     * @param type $email
     * @param type $password
     * @param type $studnr
     * @param type $address
     * @param type $city
     * @param type $dob
     * @param type $gender
     * @param type $activation_code
     * @return boolean
     */
    public function register_user($username, $firstname, $lastname, $email, $password, $address, $city, $dob, $gender) {
        $pass = $this->encrypt_password($password);
        $data = array('username' => $username, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'password' => $pass, 'address' => $address, 'city' => $city, 'dob' => $dob, 'gender' => $gender);
        $this->db->insert('tbl_users', $data);
        return 1;
    }

    /**
     * Returns all of users.
     * 
     * @param type $limit
     * @param type $offset
     * @return boolean
     */
    public function get_users($limit, $offset) {
        $result = $this->db->select('*')->from('tbl_users')->join('tbl_user_groups', 'user_group = group_id')->limit($limit, $offset)->get();

        if ($result->num_rows() > 0)
            return $result->result_array();
        else
            return false;
    }

    /**
     * Returns a single user.
     * 
     * @param type $userId
     * @return boolean
     */
    public function get_user($userId) {
        // $query = $this->db->select('*')->from('tbl_users')->join('tbl_user_groups', 'user_group = group_id')->where('userId', $userId)->get();
        $query = $this->db->select('*')->from('tbl_users')->where('userId', $userId)->get();

        if ($query->num_rows() == 1)
            return $query->row_array();
        else
            return false;
    }

    /**
     * Updates a user.
     * 
     * @param type $userId
     * @param type $username
     * @param type $firstname
     * @param type $lastname
     * @param type $email
     * @param type $user_group
     * @param type $studnr
     * @param type $address
     * @param type $city
     * @param type $dob
     * @param type $gender
     * @param null $profilepic
     * @param null $about
     * @param type $check
     * @return boolean
     */
    public function save_user($userId, $username, $firstname, $lastname, $email, $user_group, $studnr, $address, $city, $dob, $gender, $profilepic, $about, $check = 0) {
        $data = array('username' => $username
            , 'firstname' => $lastname
            , 'lastname' => $firstname
            , 'email' => $email
            , 'user_group' => $user_group
            , 'studnr' => $studnr
            , 'address' => $address
            , 'city' => $city
            , 'dob' => $dob
            , 'gender' => $gender
            , 'profile_pic' => $profilepic
            , 'about' => $about);

        if ($this->db->update('tbl_users', $data, array('userId' => $userId)))
            return true;

        $this->db->select('*')->from('tbl_users')->where('userId', $userId);
        $result = $this->db->get();

        if ($result->num_rows() != 1)
            return false; // something broke

        $row = $result->row();

        if ($row->userId == $userId && $row->username == $username && $row->firstname == $firstname &&
                $row->lastname == $lastname && $row->email == $email && $row->user_group == $user_group &&
                $row->studnr == $studnr && $row->address == $address && $row->city == $city &&
                $row->dob == $dob && $row->gender == $gender && $row->profile_pic == $profilepic && $row->about == $about)
            return true; //row has not been updated due to no changes in the record
        else {
            if ($check <= 3)
                $this->save_user($userId, $username, $firstname, $lastname, $email, $user_group, $studnr, $address, $city, $dob, $gender, $profilepic = null, $about = null, $check + 1);
            else {
                return false;
            }
        }
    }

    /**
     * Deletes a user.
     * 
     * @param type $userId
     * @return boolean
     */
    public function delete_user($userId) {
        $sql = 'CALL sp_delete_user(?)';
        $parameters = array($userId);
        $query = $this->db->query($sql, $parameters);

        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    /**
     * Check if a value is unique.
     * 
     * @param type $table
     * @param type $field
     * @param type $value
     * @return boolean
     */
    public function check_edit_unique($table, $field, $value) {
        $query = $this->db->select()->from($table)->where($field, $value)->limit(1)->get();

        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    /**
     * Adds a user.
     * 
     * @param type $username
     * @param type $firstname
     * @param type $lastname
     * @param type $email
     * @param type $password
     * @param type $studnr
     * @param type $address
     * @param type $city
     * @param type $dob
     * @param type $gender
     * @return boolean
     */
    public function add_user($username, $firstname, $lastname, $email, $password, $studnr, $address, $city, $dob, $gender) {
        $this->db->insert('tbl_users', array('username' => $username, 'firstname' => $firstname, 'lastname' => $lastname
            , 'email' => $email, 'password' => $this->encrypt_password($password), 'user_group' => 1, 'studnr' => $studnr, 'address' => $address
            , 'city' => $city, 'dob' => $dob, 'gender' => $gender));

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Changes the user password.
     * 
     * @param type $pass
     * @param type $username
     * @return boolean
     */
    public function change_user_pw($pass, $username) {
        $this->db->where('username', $username)->update('tbl_users', array('password' => $this->encrypt_password($pass)));
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the values of the user resetting his/her password.
     * 
     * @param type $email
     * @param type $username
     * @param type $studnr
     * @return boolean
     */
    public function get_user_reset_pw($email, $username, $studnr) {
        $this->db->from('tbl_users')->select('userid, username, email')->where('email', $email)->where('username', $username)->where('studnr', $studnr);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $row = $query->row();
            return $row;
        } else
            return false;
    }

    /**
     * Returns the values of the user resetting his/her password.
     * 
     * @param type $user
     * @param type $pw
     * @return boolean
     */
    public function reset_pw($user, $pw) {
        $this->db->where('userid', $user);
        $this->db->update('tbl_users', array('password' => $this->encrypt_password($pw)));
        if ($this->db->affected_rows())
            return true;
        else
            return false;
    }

    /**
     * Returns the values of the user resetting his/her password.
     * 
     * @param type $user
     * @param type $pw
     * @return boolean
     */
    public function reset_pwt($user, $pw) {
        $hour = time() + (60 * 60);
        $date = date('Y-m-d H:i:s', $hour);
        $this->db->insert('tbl_pass_recovery', array('userid' => $user, 'pass' => $this->encrypt_password($pw), 'expDate' => $date));
        if ($this->db->affected_rows())
            return true;
        else
            return false;
    }

    public function delete_timed_pass_reset() {
        $this->db->where('expdate <', date('Y-m-d H:i:s', time()))->delete('tbl_pass_recovery');
    }

    public function getLevel($id) {
        $this->db->from('tbl_levels')->select('level, expRequired')->where('level', $id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else
            return false;
    }

    public function getLevelByXp($xp) {
        $sql = 'SELECT * FROM tbl_levels WHERE expRequired > ' . $xp . ' ORDER BY expRequired ASC LIMIT 1';
        $query = $this->db->query($sql);

        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else
            return false;
    }

    public function getXp($id) {
        $this->db->from('tbl_users')->select('exp')->where('userId', $id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else
            return false;
    }

    /**
     * Returns all of users.
     * 
     * @param type $limit
     * @param type $offset
     * @return boolean
     */
    public function getFriends($id) {
        $result = $this->db->select('*')->from('tbl_friends')->join('tbl_users', 'tbl_users.userId = tbl_friends.friendId')->where('tbl_friends.userId', $id)->get();

        if ($result->num_rows() > 0)
            return $result->result_array();
        else
            return false;
    }
    
    public function getUserByName($name){
        $result = $this->db->select('*')->from('tbl_users')->where("username LIKE '" . $name . "'")->get();

        if ($result->num_rows() > 0)
            return $result->row_array();
        else
            return false;
    }
    
    public function addFriend($userId, $friendId){
        $this->db->insert('tbl_friends', array('userId' => $userId, 'friendId' => $friendId));

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function checkIfFriend($userId, $friendId){
         $result = $this->db->from('tbl_friends')->select('*')->where(array('userId' => $userId, 'friendId' => $friendId))->get();

        if ($result->num_rows() > 0)
            return true;
        else
            return false;
    }

    public function updateLastLogin($userId, $latitude, $longitude){


        $data = array(
              'latitude' => $latitude
            , 'longitude' => $longitude
            , 'last_login' => date('Y-m-d H:i:s A'));


        $result = $this->db->update('tbl_users', $data, array('userId' => $userId));
        

    }
}
