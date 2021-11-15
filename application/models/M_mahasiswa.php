<?php

use PhpParser\Node\Stmt\Catch_;

defined('BASEPATH') or exit('No direct script access allowed');


class M_Mahasiswa extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_data($nip = null, $limit = 5, $offset = 0)
    {
        if ($nip == null) {
            return $this->db->get('mahasiswa', $limit, $offset)->result();
        } else {
            return $this->db->get_where('mahasiswa', ['nip' => $nip])->result();
        }
    }

    public function count()
    {
        return $this->db->get('mahasiswa')->num_rows();
    }
}