
<table border="1" class="emptable">

<th>Employee Name</th>
<th>Employee Code</th>
<th>Department</th>
<th>Age</th>
<th>Experience</th>
<th>Action</th>

<?php
if (!empty($employeeDetails)) {

    foreach ($employeeDetails as $employee) {
        $date = date('Y');
        $dob = date('Y', strtotime($employee['dob']));
        $doj = date('Y', strtotime($employee['doj']));
        $age = $date - $dob;

        $datetime1 = new DateTime();
        $datetime2 = new DateTime($employee['doj']);
        $experience = $datetime1->diff($datetime2)->format('%y years %m months and %d days');
        ?>
      <tr>
         <td><?php echo $employee['employee_name']; ?></td>
         <td><?php echo $employee['employee_code']; ?></td>
         <td><?php echo $employee['department_name']; ?></td>
         <td><?php echo $age; ?></td>
         <td><?php echo $experience; ?></td>
         <td><a href="<?php echo base_url() . 'index/editEmployee/' . $employee['id']; ?>">Edit</a> <a href="javascript:void(0)" class="delete" id="<?php echo $employee['id']; ?>">Delete</a></td>
      </tr>
      <?php
}
    ?>
<?php
}
?>
</table>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script type="text/javascript">

   $(document).ready(function(){


      $('.emptable').on('click','.delete',function(){

         var id=$(this).attr('id');
         var self=this;
         if(confirm('Do you want to delete..?')){
            $.ajax({
               url:"<?php echo base_url(); ?>index/deleteEmployee/"+id,
               data:{id:id},
               type:'POST',
               success:function(msg){
                  if(msg){
                     alert('Successfully Deleted');
                     $(self).parent('td').closest('tr').remove();
                  }
                     
               }
            })
          }

      })

   })


</script>


