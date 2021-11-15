<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Mahasiswa extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_mahasiswa');
    }

    public function index_get()
    {
        $nip = $this->get('nip');
        var_dump($nip);
        if ($nip == null) {
            $p = $this->get('page');
            $p = (empty($p) ? 1 : $p);
            $total_data = $this->M_mahasiswa->count();
            $total_page = ceil($total_data / 1);
            $start = ($p - 1) * 1;

            $data = $this->M_mahasiswa->get_data(null, 1, $start);
            if ($data) {
                $datas = [
                    'status' => true,
                    'page' => $p,
                    'total_data' => $total_data,
                    'total_page' => $total_page,
                    'data' => $data
                ];
            } else {
                $datas = [
                    'status' => false,
                    'data' => 'Tidak ada Data'
                ];
            }
            $this->response($datas, RestController::HTTP_OK);
        } else {
            $data = $this->M_mahasiswa->get_data($nip);
            if ($data) {
                $this->response(['status' => true, 'data' => $data], RestController::HTTP_OK);
            } else {
                $this->response(['status' => false, 'data' => 'Data Not Found!'], RestController::HTTP_NOT_FOUND);
            }
        }
    }
}