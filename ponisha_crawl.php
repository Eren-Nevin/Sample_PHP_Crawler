<?php
namespace Ponisha_Crawl;


function get_page(int $page): string
{
    /* $res_file_name = "curl_response.json"; */
    /* $res_json_file = fopen($res_file_name, 'w+'); */

    $ch = curl_init();
    /* curl_setopt($ch, CURLOPT_FILE, $res_json_file); */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "");
    curl_setopt($ch, CURLOPT_COOKIEJAR, "-");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-requested-with: XMLHttpRequest'));
    // TODO: Add Other Browser Headers

    curl_setopt($ch, CURLOPT_URL, "https://ponisha.ir/search/projects/page/$page");

    $raw_res = curl_exec($ch);

    /* fseek($res_json_file, 0); */

    /* $res = fread($res_json_file, filesize($res_file_name)); */

    // This removes header info which are in start of the file.
    $cleaned_res = preg_replace('/^[^{]+/', '', $raw_res);

    return $cleaned_res;
}

class Project {
    public $id;
    public $title;
    public $description;
    public $amount_max;
    public $amount_min;
    public $bids_close_date;
    public $bids_number;

    public function __construct($id, $title, $description, $amount_min, $amount_max, $bids_close_date, $bids_number)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->bids_number = $bids_number;

        $this->set_amounts($amount_min, $amount_max);
        $this->set_bids_close_date($bids_close_date);
        
    }

    public function set_amounts($min, $max){
        $this->amount_min = $min / 10000000;
        $this->amount_max = $max / 10000000;
    }

    public function get_amount_range(){
        return "$this->amount_min -> $this->amount_max";
    }

    public function set_bids_close_date($date_string){
        $this->bids_close_date = explode(' ', $date_string)[0];
    }

    public function get_url(){
        return "https://ponisha.ir/project/{$this->id}";
    }
}
