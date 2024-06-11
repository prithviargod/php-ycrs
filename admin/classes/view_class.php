<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *, COALESCE((SELECT `name` from `category_list` where `class_list`.`category_id` = `category_list`.`id` and `status` = 1 and `delete_flag` = 0), 'Category has been removed') as category_name from `class_list` where id = '{$_GET['id']}' and delete_flag = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
		echo '<script>alert("Class ID is not valid."); location.replace("./?page=classes")</script>';
	}
}else{
	echo '<script>alert("Class ID is Required."); location.replace("./?page=classes")</script>';
}
?>
<style>
	#class-img{
		max-width:100%;
		max-height:35em;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="content py-5 px-3 bg-gradient-purple">
	<h2><b>Class Details</b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
	<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
		<div class="card rounded-0">
			<div class="card-body">
                <div class="container-fluid">
					<center>
						<img src="<?= validate_image(isset($image_path) ? $image_path : '') ?>" alt="<?= isset($name) ? $name : '' ?>" class="img-thumbnail p-0 border" id="class-img">
					</center>
                    <dl>
                        <dt class="text-muted">Category</dt>
                        <dd class="pl-4"><?= isset($category_name) ? $category_name : "" ?></dd>
                        <dt class="text-muted">Name</dt>
                        <dd class="pl-4"><?= isset($name) ? $name : "" ?></dd>
                        <dt class="text-muted">Description</dt>
                        <dd class="pl-4"><?= isset($description) ? str_replace(["\n\r", "\n", "\r"],"<br>", htmlspecialchars_decode($description)) : '' ?></dd>
                        <dt class="text-muted">Instructor</dt>
                        <dd class="pl-4"><?= isset($instructor) ? $instructor : "" ?></dd>
                        <dt class="text-muted">Fee</dt>
                        <dd class="pl-4"><?= isset($fee) ? format_num($fee) : "" ?></dd>
						<dt class="text-muted">Status</dt>
                        <dd class="pl-4">
                            <?php if($status == 1): ?>
                                <span class="badge badge-success px-3 rounded-pill">Active</span>
                            <?php else: ?>
                                <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                            <?php endif; ?>
                        </dd>
                    </dl>
                </div>
            </div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-danger btn-sm bg-gradient-danger rounded-0" type="button" id="delete_data"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-primary btn-sm bg-gradient-purple rounded-0" href="./?page=classes/manage_class&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Edit</a>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=classes"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<script>
    $(function(){
		$('#delete_data').click(function(){
			_conf("Are you sure to delete this class permanently?","delete_class", ["<?= isset($id) ? $id :'' ?>"])
		})
    })
    function delete_class($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_class",
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
					location.replace("./?page=classes");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>