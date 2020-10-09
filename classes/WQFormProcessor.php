<?php


class WQFormProcessor
{
    protected array $session_data;

    function __construct($session_data) {
        $this->session_data = $session_data;

    }

    public function WQprocessForm($db_object, $batch_table, $db_table) {
        // Process batch
        $batch_data['date'] = $this->session_data['date'];

        $check_batch = $db_object->CheckIfBatchExists($this->session_data['date']);

        if ($check_batch) {
            $last_batch_id = (int)$check_batch;
        } else {
            $db_object->InsertIntoDatabase($batch_data, $batch_table);
            $last_batch_id = $db_object->GetLastInsertID();
        }
        // Process form rows
        $counter = 0;
        while ($counter < count($this->session_data['wq_data'])) {
            $db_object->InsertIntoDatabase($this->session_data['wq_data'][$counter], $db_table, $last_batch_id);
            $counter++;
        }
    }

}