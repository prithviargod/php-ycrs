<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *  from `registration_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
                $$k = $v;
        }
        $class_qry = $conn->query("SELECT * FROM `class_list` where `id` = '{$class_id}'");
        if($class_qry->num_rows > 0){
            foreach($class_qry->fetch_assoc() as $k => $v){
                $class[$k] = $v;
            }
        }
    }
}
?>
<style>
    .course_logo{
        width:100%;
        height:100%;
        object-fit:cover;
        object-position:center center;
    }
</style>
<div class="content bg-gradient-purple py-5 px-4">
    <h3 class="font-weight-bolder">Registration Request Details</h3>
</div>
<div class="row mt-n5 justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
        <div class="card card-outline card-dark rounded-0 shadow">
            <div class="card-body">
                <div class="container-fluid" id="printout">
                    <fieldset>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Class</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($class['name']) ? $class['name'] : '' ?></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Class Instructor</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($class['instructor']) ? $class['instructor'] : '' ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Fullname</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($fullname) ? $fullname : '' ?></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Email</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($email) && !empty($email) ? $email : 'N/A' ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Birthday</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($dob) ? date("F d, Y" , strtotime($dob)) : '' ?></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Sex</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($sex) ? $sex : 'N/A' ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Contact #</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($contact) ? $contact : '' ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Address</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($address) ? (str_replace(["\n\r", "\n", "\r"], '<br>', trim(htmlspecialchars_decode($address)))) : '' ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Date Submitted</label>
                                <div class="pl-4 font-weight-bolder"><?= isset($date_created) ? date("F d, Y", strtotime($date_created)) : '' ?></div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="" class="control-label text-muted">Status</label>
                                <div class="pl-4 font-weight-bolder">
                                    <?php if(isset($status) && $status == 1): ?>
                                        <small class="badge badge-primary rounded-pill px-4">Confirmed</small>
                                    <?php else: ?>
                                        <small class="badge badge-light border rounded-pill px-4">Pending</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="card-footer py-1 text-center">
                <button id="delete_registration" class="btn btn-danger btn-flat bg-gradient-danger btn-sm" type="button"><i class="fa fa-trash"></i> Delete</button>
                <button id="update_status" class="btn btn-primary border-0 btn-flat bg-gradient-purple btn-sm" type="button"><i class="fa fa-pen"></i> Update Status</button>
                <button id="print" class="btn btn-success btn-flat bg-gradient-success btn-sm" type="button"><i class="fa fa-print"></i> Print</button>
                <a class="btn btn-light btn-flat bg-gradient-light border btn-sm" href="./?page=registrations"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
    <div>
        <div class="d-flex w-100 align-items-center">
            <div class="col-2 text-center">
                <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" class="rounded-circle border" style="width: 5em;height: 5em;object-fit:cover;object-position:center center">
            </div>
            <div class="col-8">
                <div style="line-height:1em">
                    <div class="text-center font-weight-bold"><large><?= $_settings->info('name') ?></large></div>
                    <div class="text-center font-weight-bold"><large>Registration Request Details</large></div>
                </div>
            </div>
        </div>
       
        <hr>
    </div>
</noscript>
<script>
     function print_t(){
        var h = $('head').clone()
        var p = $('#printout').clone()
        var ph = $($('noscript#print-header').html()).clone()
        h.find('title').text("Registration Request Details - Print View")
        var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
            nw.document.querySelector('head').innerHTML = h.html()
            nw.document.querySelector('body').innerHTML = ph[0].outerHTML
            nw.document.querySelector('body').innerHTML += p[0].outerHTML
            nw.document.close()
            start_loader()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 200);
            }, 300);
    }
    $(function(){
        $('#print').click(function(){
            print_t()
        })
        $('#delete_registration').click(function(){
			_conf("Are you sure to delete this registration permanently?","delete_registration",['<?= isset($id) ? $id : '' ?>'])
		})
        $('#update_status').click(function(){
			uni_modal("Update Registration Request Status","registrations/update_status.php?id=<?= isset($id) ? $id : '' ?>")
		})
    })
    function delete_registration($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_registration",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace("./?page=registrations");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>