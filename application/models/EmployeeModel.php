<?php

class EmployeeModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getEmployees()
    {
        $this->db->select('e.*,d.department_name');
        $this->db->from('employee e');
        $this->db->join('department d', 'e.department_id=d.id');
        $this->db->order_by('e.id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function getEmployee($field, $value)
    {
        $this->db->where($field, $value);
        return $this->db->get('employee')->row();
    }
    public function getDepartment()
    {
        return $this->db->get('department')->result_array();
    }

    public function getDeptId($dept)
    {
        $this->db->select('id');
        $this->db->where('department_name', $dept);
        $result = $this->db->get('department')->row();
        if ($result) {
            return $result->id;
        }

    }

    public function getCsvColumns()
    {
        $fp = fopen($_FILES['empfile']['tmp_name'], 'r') or die("can't open file");
        $csv_line = fgetcsv($fp);
        return $csv_line;
    }
    
    public function uploadData($columnArr, $file)
    {
        $count = 0;
        $fp = fopen("$file", 'r') or die("can't open file");
        $errorLog = [];
        while (($csv_line = fgetcsv($fp)) !== false) {
            $count++;
           
            if ($count == 1) {
                continue;
            }
            for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                $insert_csv = array();
                $insert_csv['employee_name'] = $csv_line[$columnArr['name']];
                $insert_csv['employee_code'] = $csv_line[$columnArr['code']];
                $insert_csv['department'] = $csv_line[$columnArr['department']];
                $insert_csv['dob'] = $csv_line[$columnArr['dob']];
                $insert_csv['doj'] = $csv_line[$columnArr['doj']];
            }
            $i++;
            $employeeCodeExists = $this->getEmployee('employee_code', $insert_csv['employee_code']);
            $deptIdExists = $this->getDeptId($insert_csv['department']);

            if ($employeeCodeExists) {
                $errorLog[] = "Employee Code exists in row #$count";
            }
            if (!$deptIdExists) {
                $errorLog[] = "Department not exists in row #$count";
            }

            if(!strtotime( $insert_csv['dob'])){
                $errorLog[] = "Date format mismatch in row #$count";
            }

            if(!strtotime( $insert_csv['doj'])){
                $errorLog[] = "Date format mismatch in row #$count";
            }

            $insertData[] = array(
                'employee_name' => $insert_csv['employee_name'],
                'employee_code' => $insert_csv['employee_code'],
                'department_id' => $this->getDeptId($insert_csv['department']),
                'dob' => date("Y-m-d", strtotime($insert_csv['dob'])),
                'doj' => date("Y-m-d", strtotime($insert_csv['doj'])),
            );
        }
        if ($count > 20) {
            $errorLog[] = "More than 20 rows..!!";
        }
        if (!empty($errorLog)) {
            $data['errorlog'] = $errorLog;
            $data['error'] = "error";
        } else {
            $this->insertEmployee($insertData);
            $data['success'] = "success";
        }
        fclose($fp) or die("can't close file");
        return $data;
    }

    public function insertEmployee($insertData)
    {
        foreach ($insertData as $data) {
            $this->db->insert('employee', $data);
        }
        return true;
    }

    public function updateEmployee($id, $postData)
    {
        $this->db->where('id', $id);
        $this->db->update('employee', $postData);
        return true;
    }

    public function deleteEmployee($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('employee');
        echo true;

    }

}
