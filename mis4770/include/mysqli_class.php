<?php

/*********************************************************************
 * /*## Portal class extends mysqli */
class mysqli_class extends mysqli
{
    public function __construct()
    {

        //OR SUPPLY OTHER CONNECTION INFO
        $DBHost = '43.231.234.179';
        $DBUser = 'group3';
        $DBPass = '8pNaRE38DaZjoUky8aWuhGQiZU';

        //SELECT THE DB
        $databaseName = 'group3';

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        @parent::__construct($DBHost, $DBUser, $DBPass, $databaseName);
        // check if connect errno is set

        //IF THE CONNECTION DOES NOT WORK - REDIRECT TO OUR "DB DOWN" PAGE, BUT PASS THE URL TO THE APPLICATION
        if (mysqli_connect_error()) {
            trigger_error(mysqli_connect_error(), E_USER_WARNING);
            echo mysqli_connect_error();
            exit;
        }
    }


    /*** LIST ******************************************************************
     * /*## List all data */
    public function student_list()
    {
        $results = array();
        $query = "
			SELECT 
				*	
			FROM 
				students		
			ORDER BY student_lname";

        if ($stmt = parent::prepare($query)) {
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            while ($stmt->fetch()) {
                $x = array();
                foreach ($row as $key => $val) {
                    $x[$key] = $val;
                }
                $results[] = $x;
            }
            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }
        return $results;
    }

    /*** INFO ******************************************************************
     * /*## Gets info for a row */
    public function student_info($id)
    {

        $results = array();
        $query = "
			SELECT 
				*	
			FROM 
				students
			WHERE
				student_id = ?";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            $stmt->fetch();
            $x = array();
            foreach ($row as $key => $val) {
                $results[$key] = $val;
            }
            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

        return $results;

    }

    public function transaction_info($customer_id)
    {

        $results = array();
        $query = "SELECT
    transactions.transaction_time,
    transactions.transaction_amount,
    transactions.transactions_id,
    transactions.customer_id
FROM
    transactions,
    customers,
    users
WHERE transactions.customer_id = customers.customer_id
AND 
customers.user_id = users.user_id
AND

customers.user_id = ?;";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("i", $customer_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            $stmt->fetch();
            $x = array();
            foreach ($row as $key => $val) {
                $results[$key] = $val;
            }
            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

        return $results;

    }

    public function bank_transfer_out($amount_transfer, $customer_id)
    {

        $results = array();
        $query = "UPDATE bank_accounts
INNER JOIN customers ON bank_accounts.customer_id = customers.customer_id
INNER JOIN users ON customers.user_id = users.user_id
SET bank_accounts.checking_balance = bank_accounts.checking_balance - ?
WHERE customers.user_id = ?;";
        if ($stmt = $this->prepare($query)) {
            $stmt->bind_param("ii", $amount_transfer, $customer_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $stmt->close();
        } else {
            trigger_error($this->error, E_USER_WARNING);
        }
    }

    public function bank_transfer_in($amount_transfer, $customer_id)
    {

        $results = array();
        $query = "UPDATE bank_accounts
INNER JOIN customers ON bank_accounts.customer_id = customers.customer_id
INNER JOIN users ON customers.user_id = users.user_id
SET bank_accounts.checking_balance = bank_accounts.checking_balance + ?
WHERE customers.user_id = ?;";
        if ($stmt = $this->prepare($query)) {
            $stmt->bind_param("ii", $amount_transfer, $customer_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $stmt->close();
        } else {
            trigger_error($this->error, E_USER_WARNING);
        }
    }

    public function loan_application($loan_amount, $customer_id)
    {

        $results = array();
        $query = "UPDATE bank_accounts
INNER JOIN customers ON bank_accounts.customer_id = customers.customer_id
INNER JOIN users ON customers.user_id = users.user_id
SET bank_accounts.loan_balance = bank_accounts.loan_balance + ?
WHERE customers.user_id = ?;";
        if ($stmt = $this->prepare($query)) {
            $stmt->bind_param("ii", $loan_amount, $customer_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $stmt->close();
        } else {
            trigger_error($this->error, E_USER_WARNING);
        }
    }

    public function bank_account_info($customer_id)
    {

        $results = array();
        $query = "SELECT
    bank_accounts.savings_balance,
    bank_accounts.checking_balance,
    bank_accounts.loan_balance,
    bank_accounts.customer_id
FROM
    bank_accounts,
    customers,
    users
WHERE bank_accounts.customer_id = customers.customer_id
AND 
customers.user_id = users.user_id
AND

customers.user_id = ?;
    
";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("i", $customer_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            $stmt->fetch();
            $x = array();
            foreach ($row as $key => $val) {
                $results[$key] = $val;
            }
            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

        return $results;

    }

    //ADD new students
    public function student_insert($student_fname, $student_lname, $student_email, $student_phone, $student_dob)
    {
        $query = "
			INSERT INTO students 
				(student_fname,
				student_lname,
				student_email,
				student_phone,
				student_dob)	
			VALUES
				(?,?,?,?,?)";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("sssss", $student_fname, $student_lname, $student_email, $student_phone, $student_dob);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $last_id = $this->insert_id;

            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

        return $last_id;

    }

    //EDIT students

    /*** EDIT  ******************************************************************
     * /*## Updates row */
    public function student_edit($student_id, $student_fname, $student_lname, $student_email, $student_phone, $student_dob)
    {

        $query = "
			UPDATE students SET 
				student_fname = ?,
				student_lname = ?,
				student_phone = ?,
				student_email = ?,
				student_dob = ?	
			WHERE
				student_id=?";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("sssssi", $student_fname, $student_lname, $student_phone, $student_email, $student_dob, $student_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }

            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

    }

    /*** REMOVE  ******************************************************************
     * /*## removes row */
    public function student_delete($id)
    {

        $query = "
			DELETE FROM 
				table_name 
			WHERE
				id = ?";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }

            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

    }

    /**** LOGIN ******************************************************************
     * /*## Checks login credentials */
    public function login($email, $password)
    {

        $query = "SELECT * FROM users WHERE email = ?";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("s", $email);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            $stmt->fetch();
            $x = array();
            foreach ($row as $key => $val) {
                $x[$key] = $val;
            }
            $stmt->close();

            if ($x['email'] == $email && password_verify($password, $x['user_password'])) {
                $this->logins_insert($x['user_id']);
                return array(1, $x);
            } else {
                return array(0, $x);
            }

        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }
    }

    /*** LOG LOGINS ******************************************************************
     * /*## Logs user logins  */
    public
    function logins_insert($user_id)
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        $refer = $_SERVER['HTTP_REFERER'];
        $query = "
			INSERT INTO logins 
				(user_id,
				login_ip,
				login_browser)	
			VALUES
				(?,?,?)";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("iss", $user_id, $ip, $agent);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $last_id = $this->insert_id;

            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }
        return $last_id;
    }

    //ADD actions logging
    public
    function actions_insert($action, $user_id)
    {
        $page = $_SERVER['REQUEST_URI'];
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        $refer = $_SERVER['HTTP_REFERER'];
        $query = "
			INSERT INTO actions 
				(user_id,
				action_desc,
				action_page,
				action_ip,
				action_browser,
				action_refer)	
			VALUES
				(?,?,?,?,?,?)";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("ssssss", $user_id,
                $action, $page, $ip, $agent, $refer);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $last_id = $this->insert_id;

            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

        return $last_id;
    }

//////////////
//USERS
/////////////

    /*** INFO ******************************************************************
     * /*## Gets info for a row */
    public
    function user_info($user_id)
    {

        $results = array();
        $query = "
			SELECT
				*
			FROM
				users
			WHERE
				user_id = ?";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("i", $user_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            $stmt->fetch();
            $x = array();
            foreach ($row as $key => $val) {
                $results[$key] = $val;
            }
            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }
        return $results;
    }


    /*** USER LIST ******************************************************************
     * /*## List all data */
    public
    function user_list()
    {
        $results = array();
        $query = "
			SELECT
				*
			FROM
				users,
				user_levels
			WHERE users.user_level_id = user_levels.user_level_id
			ORDER BY user_id";
        //echo $query;
        if ($stmt = parent::prepare($query)) {
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            while ($stmt->fetch()) {
                $x = array();
                foreach ($row as $key => $val) {
                    $x[$key] = $val;
                }
                $results[] = $x;
            }
            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }
        return $results;
    }

    public
    function transaction_list()
    {
        $results = array();
        $query = "
			SELECT
				*
			FROM
				transactions,
				user_levels
			WHERE users.user_level_id = user_levels.user_level_id
			ORDER BY user_id";
        //echo $query;
        if ($stmt = parent::prepare($query)) {
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            while ($stmt->fetch()) {
                $x = array();
                foreach ($row as $key => $val) {
                    $x[$key] = $val;
                }
                $results[] = $x;
            }
            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }
        return $results;
    }


    /*** USER ADD  ******************************************************************
     * /*## adds row  data */
    public function insert_user_and_customer($email, $user_name, $user_password, $user_level_id, $first_name, $last_name, $primary_address, $phone_number)
    {
        $pass_hash = password_hash($user_password, PASSWORD_DEFAULT);

        // Insert into 'users' table
        $queryInsertUser = "INSERT INTO users (email, user_name, user_password, user_level_id) VALUES (?, ?, ?, ?)";
        if ($stmtUser = parent::prepare($queryInsertUser)) {
            $stmtUser->bind_param("sssi", $email, $user_name, $pass_hash, $user_level_id);
            if ($stmtUser->execute()) {
                $user_id = $stmtUser->insert_id;
                $stmtUser->close();
                // Insert into 'customers' table using the obtained 'user_id'
                $queryInsertCustomer = "INSERT INTO customers (user_id, first_name, last_name, primary_address, phone_number) VALUES (?, ?, ?, ?, ?)";
                if ($stmtCustomer = parent::prepare($queryInsertCustomer)) {
                    $stmtCustomer->bind_param("issss", $user_id, $first_name, $last_name, $primary_address, $phone_number);
                    if ($stmtCustomer->execute()) {
                        $customer_id = $stmtCustomer->insert_id;
                        $stmtCustomer->close();

                        $queryInsertBankInfo = "INSERT INTO bank_accounts (customer_id, checking_balance, savings_balance, loan_balance) VALUES (?, 0, 0, 0)";
                        if ($stmtBank = parent::prepare($queryInsertBankInfo)) {
                            $stmtBank->bind_param("i", $customer_id);
                            if ($stmtBank->execute()) {
                                $stmtBank->close();

                                return array("user_id" => $user_id, "customer_id" => $customer_id);
                            } else {
                                $stmtCustomer->close();
                                trigger_error($this->error, E_USER_WARNING);
                            }
                        } else {
                            trigger_error($this->error, E_USER_WARNING);
                        }
                    } else {
                        $stmtUser->close();
                        trigger_error($this->error, E_USER_WARNING);
                    }
                } else {
                    trigger_error($this->error, E_USER_WARNING);
                }


            }
        }

        return array("user_id" => 0, "customer_id" => 0); // Return default values if insertion fails

    }


    /*** USER EDIT  ******************************************************************
     * /*## Updates row */
    public
    function user_edit($user_id, $email, $name, $password, $level)
    {
        if ($password) {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $pass_hash = $this->user_info($user_id)['user_password'];
        }
        $query = "
			UPDATE users SET
				email = ?,
				user_name = ?,
				user_password = ?,
				user_level_id = ?
			WHERE
				user_id = ?";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("sssii", $email, $name, $pass_hash, $level, $user_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }

            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

    }

    /*** USER REMOVE  ******************************************************************
     * /*## removes row */
    public
    function user_remove($user_id)
    {

        $query = "
			DELETE FROM
				users
			WHERE
				user_id = ?";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("i", $user_id);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }

            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }
    }

    /*** USER LEVEL LIST ******************************************************************
     * /*## List all data */
    public
    function user_level_list()
    {
        $results = array();
        $query = "
			SELECT
				*
			FROM
				user_levels
			ORDER BY user_level_id";

        if ($stmt = parent::prepare($query)) {
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            while ($stmt->fetch()) {
                $x = array();
                foreach ($row as $key => $val) {
                    $x[$key] = $val;
                }
                $results[] = $x;
            }
            $stmt->close();

        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

        return $results;
    }


    /*** LIST ******************************************************************
     * /*## List all data */
    public function cookie_list()
    {
        $results = array();
        $query = "
			SELECT 
				*	
			FROM 
				cookies		
			ORDER BY cookie_name";

        if ($stmt = parent::prepare($query)) {
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $parameters[] = &$row[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            while ($stmt->fetch()) {
                $x = array();
                foreach ($row as $key => $val) {
                    $x[$key] = $val;
                }
                $results[] = $x;
            }
            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }
        return $results;
    }

    //ADD new students
    public function cookie_insert($cookie_name, $cookie_price, $cookie_available)
    {
        $query = "
			INSERT INTO cookies 
				(cookie_name,
				 cookie_price,
				 cookie_available)	
			VALUES
				(?,?,?)";
        if ($stmt = parent::prepare($query)) {
            $stmt->bind_param("sss", $cookie_name, $cookie_price, $cookie_available);
            if (!$stmt->execute()) {
                trigger_error($this->error, E_USER_WARNING);
            }
            $last_id = $this->insert_id;

            $stmt->close();
        }//END PREPARE
        else {
            trigger_error($this->error, E_USER_WARNING);
        }

        return $last_id;

    }


}//END CLASS
