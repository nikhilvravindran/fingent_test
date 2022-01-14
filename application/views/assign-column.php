
<form action="<?php echo base_url(); ?>index/assignColumn" method="post" enctype="multipart/form-data" name="import" id="import">
    <table id="dynamicTable">
            <tr>
                <td>
                    <label class="field" data-label="name">Employee name</label>

                    <select name="column" class="column">
                        <option value="">Select</option>
                        <?php
                        for ($i = 0; $i < count($columns); $i++) {
                            ?>
                             <option value="<?php echo $i; ?>">col <?php echo $i+1; ?></option>
                        <?php
                            }
                            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="field" data-label="code">Employee Code</label>

                    <select name="column" class="column">
                        <option value="">Select</option>
                        <?php
                        for ($i = 0; $i < count($columns); $i++) {
                            ?>
                             <option value="<?php echo $i; ?>">col <?php echo $i+1; ?></option>
                        <?php
                            }
                            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="field" data-label="department">Department</label>

                    <select name="column" class="column">
                        <option value="">Select</option>
                        <?php
                        for ($i = 0; $i < count($columns); $i++) {
                            ?>
                             <option value="<?php echo $i; ?>">col <?php echo $i+1; ?></option>
                        <?php
                            }
                            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="field" data-label="dob">Date of birth</label>

                    <select name="column" class="column">
                        <option value="">Select</option>
                        <?php
                        for ($i = 0; $i < count($columns); $i++) {
                            ?>
                             <option value="<?php echo $i; ?>">col <?php echo $i+1; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="field" data-label="doj">Date of joining</label>

                    <select name="column" class="column">
                        <option value="">Select</option>
                        <?php
                        for ($i = 0; $i < count($columns); $i++) {
                            ?>
                             <option value="<?php echo $i; ?>">col <?php echo $i+1; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </td>
            </tr>

            </table>

        <div class="col-lg-offset-3 col-lg-9">
            <input type="hidden" id="columnJson" name="columnJson">
            <input type="hidden" id="empfile" name="empfile" value="<?php echo $csvfilepath; ?>">
            <span class="error">All fields are required</span>
            <button type="submit" name="submit" class="btn btn-info btnSubmit">Save</button>
        </div>


</form>


<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){
    $('.error').hide();
    $('.btnSubmit').click(function () {
        var formData = [];
        $('#dynamicTable tr').each(function (index, tr) {
            var formField = $(this).find('.field').attr('data-label');
            var column = $(this).find('.column').val();
            if(column){
                formData.push({formField:formField,column: column});
                $('.error').hide();
            }
            else{
                $('.error').show();
            }
        });
        console.log(formData);
        $('#columnJson').val(JSON.stringify(formData, true));
    });


});
</script>


<style>
.error{
   color:red;
}
</style>