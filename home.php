<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -  
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in 
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see http://codeigniter.com/user_guide/general/urls.html
   */

    function __construct()
    {
      parent::__construct();
      
      $this->load->helper(array('url','html','form','date','language'));
      $this->load->library(array('Upload','Ion_auth','form_validation','user_agent'));
      $this->load->model(array('Indoearthhackmodel'));
    }

    public function index()
    {
      $data['title'] = 'Indo Earth Hack';
      $data['listnews'] = $this->Indoearthhackmodel->gethome();
      $this->load->view('frontend/index', $data);
    }


    public function home()
    {
      $data['title'] = 'Indo Earth Hack';
      $data['listnews'] = $this->Indoearthhackmodel->gethome();
      $this->load->view('frontend/home', $data);
    }

    public function listproduct($data)
    {
      $data['title'] = 'Indo Earth Hack';
      $data['listnews'] = $this->Indoearthhackmodel->checkprocess($data);
      $this->load->view('frontend/home', $data);
    }

    public function selectpicture() //view to select picture
    {
      if($this->ion_auth->logged_in()){

        $data['title'] = 'Indo Earth Hack';
        $data['listnews'] = $this->Indoearthhackmodel->gethome();
        $this->load->view('frontend/selectpicture', $data);

      }else{

        redirect('auth/login', 'refresh');

      }
    }

    function submitpicture()  //analyse the picture of trash
  {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $config['upload_path'] = './assets/images/'; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type of file
        $config['max_size'] = '5000'; //maximum file

        $this->upload->initialize($config);

        if($_FILES['filelib']['name'])
        {
            
                $namafile = $_FILES['filelib']['name'];

                $data['checkproductrelated'] = $this->Indoearthhackmodel->checkproductrelated($namafile);

                if($data['checkproductrelated']){

                      $this->session->set_userdata("pesan", "<div class=\"alert alert-success\">
                                                      <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\"></a>
                                                      <strong>Product found!</strong>
                                                      </div>");

                      $this->load->view('frontend/listproduct', $data);


                    }else{

                      $this->session->set_userdata("pesan", "<div class=\"alert alert-danger\">
                                                      <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\"></a>
                                                      <strong>Failed. Try Again</strong>
                                                      </div>");

                      redirect("home/selectpicture", 'refresh');

                    }

        }else{

          $this->session->set_userdata("pesan", "<div class=\"alert alert-danger\">
                                                      <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\"></a>
                                                      <strong>Failed. No file found</strong>
                                                      </div>");

                      redirect("home/selectpicture", 'refresh');

                
        }

  }
  
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
