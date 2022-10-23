<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Mahasiswamodel', 'model');
    }

    public function index_get()
    {
        $data = $this->model->getMahasiswa();
        $this->set_response([
          'status' => TRUE,
          'code' => 200,
          'message' => 'Success',
          'data' => $data,  
        ], REST_Controller::HTTP_OK);
    }

    public function sendmail_post(){
        $to_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('noreply@mysteltainn.com','Raja Ongkir');
        $this->email->to($to_email);
        $this->email->subject('Pemberitahuan !');
        $this->email->message("
        <center>
            <div style='border: 5px solid #000000; border-radius: 32px;'>
                <h1 style='color:#F1C40F;'>Selamat datang di Keluarga Raja Ongkir !</h1>
                <img style='border-radius: 50%;' src='https://st4.depositphotos.com/10849820/26827/v/600/depositphotos_268276448-stock-illustration-globe-fast-logo-design-concept.jpg' style='width:20px; height:4px;'>
                <h2 style='font-weight: bold;'>Terima kasih telah mendaftar layanan Raja Ongkir</h2>
                <p> RajaOngkir memiliki data ongkos kirim yang terpadu.<b>Sehingga Anda cukup sekali saja menginputkan tujuan </b> pengiriman anda.</p>
                <p> Apabila Anda memang pernah melakukan pendaftaran sebagai <i> user </i> di layanan Raja Ongkir, silahkan klik tautan di bawah ini: </p>
                <button style='background-color: #40E0D0;
                border-radius:28px;
                border:1px solid #28B463 ;
                display:inline-block;
                cursor:pointer;
                color:#ffffff;
                font-family:Arial;
                font-size:15px;
                font-weight:bold;
                padding:14px 15px;
                text-decoration:none;
                text-shadow:0px 1px 0px #2f6627;'
                > Verifikasi akun </button>
                &nbsp;
                <p style='color: #0000FF;'> Email ini dikirimkan kepada Anda untuk keperluan verifikasi akun yang baru saja Anda daftarkan. </p>
            </div>
            </center>
        ");

        if($this->email->send()){
             $this->set_response([
                    'status' => TRUE,
                    'code' => 200,
                    'data'   => $data ,
                     'message'=> 'Email Informasi Berhasil Dikirimkan !',
                    ], REST_Controller::HTTP_OK);
        }else{
            $this->set_response([
                   'status' => FALSE,
                   'code' => 404,
                   'message' => 'Gagal Mengirimkan Email Informasi',
                    ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}