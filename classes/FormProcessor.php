<?php


class FormProcessor
{
    protected array $user_data;

    function __construct($user_data) {
        $this->user_data = $user_data;
    }

    public function FormElementCleanUp() {
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
    public function WQMarkedElementCleanUp($marked) {
        $counter = 0;
        while ($counter < count($this->user_data['row'])) {
            $this->user_data['row'][$counter]['marked'] = NULL;
            $counter++;
        }

        foreach ($marked as $key) {
            $this->user_data['row'][$key]['marked'] = 1;
        }
    }

    /**
     * @param $db_object
     * @param $batch_table
     * @param $db_table
     * @param $allow_duplicates
     */
    public function ProcessForm($db_object, $batch_table, $db_table, $allow_duplicates) {
        // Process batch
        $batch_data = array();
        foreach ($this->user_data as $k => $v) {
            if ($k == 'row') {
                break;
            }
            $batch_data[$k] = $v;
        }

        $check_batch = $db_object->CheckIfBatchExists($batch_data, $batch_table);

        if ($check_batch && $allow_duplicates) {
            $last_batch_id = (int)$check_batch;
        }   elseif ($check_batch && !$allow_duplicates) {
            $_SESSION['error_message'] = 'Batch already exists';
            return;
        }   else {
            $db_object->InsertIntoDatabase($batch_data, $batch_table);
            $last_batch_id = $db_object->GetLastInsertID();
        }

        // Process rows
        $row_count = count($this->user_data['row']);
        $_SESSION['success_message'] = $row_count . ' records added to database';
        $counter = 0;
        while ($counter < $row_count ) {
            $db_object->InsertIntoDatabase($this->user_data['row'][$counter], $db_table, $last_batch_id);
            $counter++;
        }
    }

}