<form action="<?php echo base_url(); ?>index/importEmployee" method="post" enctype="multipart/form-data" name="import" id="import">
    <table>
            <tr>
                <td> Choose your file: </td>
                <td>
                    <input type="file" class="form-control" name="empfile" id="empfile"/>
                    <span class="error"><?php echo form_error('empfile'); ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-lg-offset-3 col-lg-9">
                        <button type="submit" name="submit" class="btn btn-info">Save</button>
                    </div>
                </td>
            </tr>
    </table>
</form>

<?php
if ($this->session->flashdata('error')) {
    $errorlog=$this->session->flashdata('error')['errorlog'];
    foreach ($errorlog as $error) {
        ?>
      <span class="error"><?php echo $error; ?></span><br>
  <?php
  }
}
?>

<style>
.error{
   color:red;
}
</style>