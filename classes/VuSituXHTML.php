<?php


class VuSituXHTML
{
    private array $files_array;
    private string $uploaddir;
    private string $uploadfile;

    function __construct($files_array)
    {
        $this->files_array = $files_array;
        $this->uploaddir = __DIR__ . '/../uploads/';
        $this->uploadfile = $this->uploaddir . basename($this->files_array['userfile']['name']);

        move_uploaded_file($this->files_array['userfile']['tmp_name'], $this->uploadfile);

    }

    public function ParseXHTML() {
        $dom = new DomDocument();
        $dom->loadHTMLFile($this->uploadfile, LIBXML_NOERROR);

        $finder = new DomXPath($dom);
        $classnames = ['data', 'data-marked'];
        $trList = $finder->query("//tr[contains(concat(' ', normalize-space(@class), ' '), ' $classnames[0] ') or contains(concat(' ', normalize-space(@class), ' '), ' $classnames[1] ')]");

        $keys = array('time', 'rdocon', 'rdosat', 'temp', 'cond', 'sal', 'depth', 'ph', 'marked');
        $wq_data = array();
        $wq_data['site'] = $_POST['site'];

        $date = $trList->item(0)->childNodes->item(0)->textContent;
        $needle = strpos($date, ' ');
        $wq_data['date'] = substr($date, 0, $needle);

        $tr_length = false;
        if ($trList->item(0)->childNodes->length > count($keys)) {
            $tr_length = true;
        }

        foreach ($trList as $tr) {
            if ($tr_length) {
                $tr->removeChild($tr->childNodes->item(count($keys) - 1));
                $tr->removeChild($tr->childNodes->item(count($keys) - 1));
            }

            $row = [];
            $counter = 0;
            foreach ($tr->getElementsByTagName("td") as $td) {
                $string = trim($td->textContent);
                if ($counter == 0) {
                    $row[$keys[$counter]] = substr($string, $needle);
                    $counter++;
                    continue;
                }
                $row[$keys[$counter]] = $string;
                $counter++;
            }
            $wq_data['row'][] = $row;
        }
        unlink($this->uploadfile);
        return $wq_data;
    }
}