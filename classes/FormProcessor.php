<?php


class FormProcessor
{
    protected array $user_data;

    function __construct($user_data)
    {
        $this->user_data = $user_data;
    }

    public function FormElementCleanUp()
    {
        /*
         * Set empty string elements that expect integers in database to NULL, and set checkboxes to integer 1.
         */
        $counter = 0;
        while ($counter < count($this->user_data['row'])) {
            foreach ($this->user_data['row'][$counter] as $k => $v) {
                if ($this->user_data['row'][$counter][$k] == '') {
                    $this->user_data['row'][$counter][$k] = NULL;
                    continue;
                }
                if ($this->user_data['row'][$counter][$k] == 'on') {
                    $this->user_data['row'][$counter][$k] = 1;
                }
            }
            $counter++;
        }
    }

    /**
     * @param $marked
     */
    public function WQMarkedElementCleanUp($marked)
    {
        $counter = 0;
        while ($counter < count($this->user_data['row'])) {
            $this->user_data['row'][$counter]['marked'] = NULL;
            $counter++;
        }

        foreach ($marked as $key) {
            $this->user_data['row'][$key]['marked'] = 1;
        }
    }

    public function ProcessBirdNames($db_object)
    {
        $counter = 0;
        while ($counter < count($this->user_data['row'])) {
            $check_name = $db_object->CheckBirdName($this->user_data['row'][$counter]['species']);

            if ($check_name) {
                $this->user_data['row'][$counter]['species'] = $check_name;
            } else {
                $_SESSION['error_message'] = 'Bird species " <strong>' . $this->user_data['row'][$counter]['species'] . '</strong> " not found in the database';
                header('Location: bird_count.php');
                exit;
            }
            $counter++;
        }
    }

    /**
     * @param $db_object
     * @param $batch_table
     * @param $db_table
     * @param $allow_duplicates
     */
    public function ProcessForm($db_object, $batch_table, $db_table, $allow_duplicates)
    {
        // Verify user privileges
        $user_privileges = $db_object->GetPrivilegeLevel();
        if ($user_privileges > 2) {
            $_SESSION['error_message'] = 'User does <strong>NOT</strong> have database writing permissions';
            return;
        }

        // Process batch
        $batch_data = array();
        foreach ($this->user_data as $k => $v) {
            if ($k == 'row') {
                break;
            }
            $batch_data[$k] = $v;
        }
        $batch_data['user'] = $_SESSION['USER_ID'];

        $check_batch = $db_object->CheckIfBatchExists($batch_data, $batch_table);

        if ($check_batch && $allow_duplicates) {
            $last_batch_id = (int)$check_batch;
        } elseif ($check_batch && !$allow_duplicates) {
            $_SESSION['error_message'] = 'Duplicate of batch <strong>&gt; ' . $check_batch . ' &lt;</strong>';
            return;
        } else {
            $db_object->InsertIntoDatabase($batch_data, $batch_table);
            $last_batch_id = $db_object->GetLastInsertID();
        }
        $_SESSION['bid'] = $last_batch_id;

        $row_count = count($this->user_data['row']);
        $_SESSION['success_message'] = 'Total records inserted into database => <strong>' . $row_count . '</strong>';
        $counter = 0;
        while ($counter < $row_count) {
            $db_object->InsertIntoDatabase($this->user_data['row'][$counter], $db_table, $last_batch_id);
            $counter++;
        }
    }

    public function ProcessRows($db_object, $db_table, $last_batch_id) {
        $row_count = count($this->user_data['row']);
        $_SESSION['success_message'] = 'Total records inserted into database => <strong>' . $row_count . '</strong>';
        $counter = 0;
        while ($counter < $row_count) {
            $db_object->InsertIntoDatabase($this->user_data['row'][$counter], $db_table, $last_batch_id);
            $counter++;
        }
        $_SESSION['bid'] = $_SESSION['TEMP']['boat_patrol_id'];
        unset($_SESSION['TEMP']);
    }
}