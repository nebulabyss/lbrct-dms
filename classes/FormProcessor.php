<?php


class FormProcessor
{
    protected array $post_data;

    function __construct($post_data) {
        $this->post_data = $post_data;
    }

    public function FormElementCleanUp() {
        /*
         * Clean up elements that expect integers in database and set checkboxes to integer 1.
         */
        $counter = 0;
        while ($counter < count($this->post_data['row'])) {
            foreach ($this->post_data['row'][$counter] as $k => $v) {
                if ($this->post_data['row'][$counter][$k] == 'on') {
                    $this->post_data['row'][$counter][$k] = 1;
                    continue;
                }
                if ($this->post_data['row'][$counter][$k] == '') {
                    $this->post_data['row'][$counter][$k] = NULL;
                }
            }
            $counter++;
        }
    }

    public function processForm($db_object, $batch_table, $db_table) {
        // Process batch
        $batch_data = array();
        foreach ($this->post_data as $k => $v) {
            if ($k == 'row') {
                break;
            }
            $batch_data[$k] = $v;
        }
        $db_object->InsertIntoDatabase($batch_data, $batch_table);

        $last_batch_id = $db_object->GetLastInsertID();

        // Process form rows
        $counter = 0;
        while ($counter < count($this->post_data['row'])) {
            $db_object->InsertIntoDatabase($this->post_data['row'][$counter], $db_table, $last_batch_id);
            $counter++;
        }
    }

}