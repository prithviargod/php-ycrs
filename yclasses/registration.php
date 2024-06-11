<?php
if(isset($_GET['cid']) && $_GET['cid'] > 0){
    $qry = $conn->query("SELECT *, COALESCE((SELECT `name` from `category_list` where `class_list`.`category_id` = `category_list`.`id` and `status` = 1 and `delete_flag` = 0), 'Category has been removed') as category_name from `class_list` where id = '{$_GET['cid']}' and delete_flag = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $class[$k]=$v;
        }
    }else{
		echo "<script>alert('You dont have access for this page'); location.replace('./');</script>";
	}
}else{
	echo "<script>alert('You dont have access for this page'); location.replace('./');</script>";
}
?>

<div class="container mt-1">
    <div class="content py-5 px-3 bg-gradient-purple">
        <h3><b>Class Registration</b></h3>
    </div>
    <div class="row mt-lg-n4 mt-md-n4 justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mb-3">
            <div class="card rounded-0">
                <div class="card-body">
                    <?php if($_settings->chk_flashdata('success_public')): ?>
                        <div class="mb-3 alert alert-success rounded-0">
                            <?= $_settings->flashdata('success_public') ?>
                        </div>
                    <?php endif; ?>
                    <div class="text-center text-muted">
                        <small>Please fill-in the requried fields</small>
                    </div>
                    <hr>
                    <form id="registration-form">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="class_id" value="<?= isset($class['id']) ? $class['id'] : "" ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="" class="control-label text-muted font-weight-light">Class </label>
                                    <div class="pl-4 font-weight-bold"><?= isset($class['name']) ? $class['name'] : "" ?></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="" class="control-label text-muted font-weight-light">Class Instructor</label>
                                    <div class="pl-4 font-weight-bold"><?= isset($class['instructor']) ? $class['instructor'] : "" ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="fullname" class="control-label text-muted font-weight-light">Fullname <small class="text-danger">*</small></label>
                                    <input type="text" name="fullname" id="fullname" class="form-control form-control-sm rounded-0" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="email" class="control-label text-muted font-weight-light">Email</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="dob" class="control-label text-muted font-weight-light">Birthday <small class="text-danger">*</small></label>
                                    <input type="date" name="dob" id="dob" class="form-control form-control-sm rounded-0" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="sex" class="control-label text-muted font-weight-light">Sex <small class="text-danger">*</small></label>
                                    <select name="sex" id="sex" class="form-select form-select-sm rounded-0" required="required">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="contact" class="control-label text-muted font-weight-light">Contact # <small class="text-danger">*</small></label>
                                    <input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="address" class="control-label text-muted font-weight-light">Address <small class="text-muted"><i>(Location where to conduct the service?)</i></small> <small class="text-danger">*</small></label>
                                    <textarea style="resize:none" rows="2" name="address" id="address" class="form-control form-control-sm rounded-0" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                                <button class="btn btn-primary border-0 btn-block rounded-pill btn-lg bg-gradient-purple">Submit Registration</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#registration-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_registration",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
    })
</script>