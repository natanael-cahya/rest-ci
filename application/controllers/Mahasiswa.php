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
    public function index_post()
    {
        $data = [
            'nip' => $this->post('nip'),
            'nim' => $this->post('nim'),
            'nama' => $this->post('nama'),
            'jurusan' => $this->post('jurusan')

        ];
        $save = $this->M_mahasiswa->add($data);
        if ($save['status']) {
            $this->response(['status' => true, 'msg' => $save['data'] . ' Data berhasil di tambah'], RestController::HTTP_CREATED);
        } else {
            $this->response(['status' => false, 'msg' => $save['msg']], RestController::HTTP_INTERNAL_ERROR);
        }
    }
    public function index_put()
    {
        $nipx = $this->put('nip');
        $data = [
            'nip' => $this->put('nip'),
            'nim' => $this->put('nim'),
            'nama' => $this->put('nama'),
            'jurusan' => $this->put('jurusan')

        ];

        $save = $this->M_mahasiswa->update($nipx, $data);
        if ($save['status']) {
            $this->response(['status' => true, 'msg' => $save['data'] . ' Data berhasil di Ubah'], RestController::HTTP_OK);
        } else {
            $this->response(['status' => false, 'msg' => $save['msg']], RestController::HTTP_INTERNAL_ERROR);
        }
    }
}