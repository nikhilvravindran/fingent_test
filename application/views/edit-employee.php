<form action="<?php echo base_url().'index/editEmployee/'.$employee->id; ?>" method="post" enctype="multipart/form-data" name="import" id="import">
   <label>Employee Name</label>
   <input type="text" name="employee_name" id="name" value="<?php echo $employee->employee_name; ?>" ><br>
   <?php echo form_error('employee_name'); ?>

   <label>Employee Code</label>
   <input type="text" readonly name="employee_code" id="employee_code" value="<?php echo $employee->employee_code; ?>" ><br>
   <label>Department</label>
   <select name="department_id" id="department">
    <option value="">Select</option>
    <?php
if (!empty($department)) {
    foreach ($department as $dept) {
        ?>
            <option <?php if ($dept['id'] == $employee->department_id) {echo "selected";}?> value="<?php echo $dept['id']; ?>"><?php echo $dept['department_name']; ?></option>
            <?php
}
}

?>
   </select><br>
   <?php echo form_error('department_id'); ?>
   <label>Date of Birth</label>
   <input type="date"  name="dob" id="dob" value="<?php echo $employee->dob; ?>" ><br>
   <?php echo form_error('dob'); ?>

   <label>Date of join</label>
   <input type="date"  name="doj" id="doj" value="<?php echo $employee->doj; ?>" ><br>
   <?php echo form_error('doj'); ?>
   <input type="submit"  value="Save">
</form>

<style>
.error{
   color:red;
}
</style>