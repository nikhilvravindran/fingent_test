<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('EmployeeModel', 'employeeModel');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->library('session');
    }

    public function index()
    {
        $data['employeeDetails'] = $this->employeeModel->getEmployees();
        $this->load->view('navigation');
        $this->load->view('employee-list', $data);
    }

    public function importEmployee()
    {
       
        $this->form_validation->set_rules('empfile', 'File', 'callback_csv_file_check');
        if ($this->form_validation->run() == false) {
            $this->load->view('navigation');
            $this->load->view('import');
        } else {
            $config_arr = array(
                'upload_path' => './uploads/',
                'allowed_types' => 'csv',
                'file_name' => 'empfile',
            );
            $this->load->library('upload', $config_arr);
            $this->upload->do_upload('empfile');
            $data['csvfilepath'] = $this->upload->data()['full_path'];
            $data['columns'] = $this->employeeModel->getCsvColumns();

            if(count($data['columns']) < 5){
                $errorLog[] = 'Minimun 5 columns required.';
                $data['errorlog'] = $errorLog;
                $this->session->set_flashdata('error',$data);
                redirect('index/importEmployee');
            }
            else {
                $this->assignColumn($data);
            }
            
        }
    }

    public function assignColumn($data=null)
    {
        $this->form_validation->set_rules('columnJson', 'columns', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('assign-column', $data);
        } else {
            $postData=json_decode($this->input->post('columnJson'),true);
            $columnArr=[];
            foreach($postData as $key => $post){
                $columnArr[$post['formField']]=$post['column'];
            }
            $file=$this->input->post('empfile');
            $data=$this->employeeModel->uploadData($columnArr,$file);
            if(!empty($data['errorlog'])){
                $this->session->set_flashdata('error',$data);
                redirect('index/importEmployee');
            }
            else {
                redirect('index');
            }
         }
    }

    public function csv_file_check($str)
    {
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (isset($_FILES['empfile']['name']) && $_FILES['empfile']['name'] != "") {
            $mime = get_mime_by_extension($_FILES['empfile']['name']);
            $fileAr = explode('.', $_FILES['empfile']['name']);
            $ext = end($fileAr);
            if (($ext == 'csv') && in_array($mime, $allowed_mime_types)) {
                return true;
            } else {
                $this->form_validation->set_message('csv_file_check', 'Please select only CSV file to upload.');
                return false;
            }
        } else {
            $this->form_validation->set_message('csv_file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }
    public function editEmployee($id)
    {
        $this->form_validation->set_rules('employee_name', 'Employee Name', 'required');
        $this->form_validation->set_rules('department_id', 'Department', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('doj', 'Date of Join', 'required');
        $data['department'] = $this->employeeModel->getDepartment();
        $data['employee'] = $this->employeeModel->getEmployee('id', $id);
        if ($this->form_validation->run() == false) {
            $this->load->view('navigation');
            $this->load->view('edit-employee', $data);
        } else {
            $postData = $this->input->post();
            $result = $this->employeeModel->updateEmployee($id, $postData);
            if ($result) {
                redirect('index');
            }
        }
    }
    public function deleteEmployee($id)
    {

        return $this->employeeModel->deleteEmployee($id);

    }
}
