<style>
    .class-img-holder{
        width:100%;
        height:12.5em;
        overflow:hidden;
    }
    .class-img{
        width:100%;
        height:100%;
        object-fit: cover;
        object-position: center center;
        transition: all .3s ease-in-out;
    }
    .class-item:hover .class-img{
        transform: scale(1.2)
    }
    #search:empty{
        font-style:italic;
    }
    #search{
        border-right:unset !important;
        border-top-right-radius:0px !important;
        border-bottom-right-radius:0px !important;
    }
    #search-icon{
        border-left:unset !important;
        border-top-left-radius:0px !important;
        border-bottom-left-radius:0px !important;
    }
    #search:focus{

    }
</style>
<section class="py-3">
	<div class="container">
		<div class="content bg-gradient-purple py-5 px-3">
			<h4 class="">Our Available Classes</h4>
		</div>
		<div class="row mt-n3 justify-content-center">
            <div class="col-lg-10 col-md-11 col-sm-11 col-sm-11">
                <div class="card card-outline rounded-0">
                    <div class="card-body">
                        <div class="row justify-content-center mb-3">
                            <div class="col-lg-8 col-md-10 col-xs-12 col-sm-12">
                                <div class="input-group input-group-lg">
                                    <input type="search" id="search" class="form-control rounded-pill px-3" placeholder="Find class by name or description">
                                    <span class="btn btn-outline border rounded-pill " id="search-icon" type="button"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-xl-4 row-md-6 col-sm-12 col-xs-12 gy-3 gx-3 align-items-center justify-content-center">
                            <?php 
                                $qry = $conn->query("SELECT *, COALESCE((SELECT `name` from `category_list` where `class_list`.`category_id` = `category_list`.`id` and `status` = 1 and `delete_flag` = 0), 'Category has been removed') as category_name FROM `class_list` where delete_flag = 0 and `status` = 1 order by `name` asc");
                                while($row = $qry->fetch_assoc()):
                            ?>
                            <div class="col class-item">
                                <a class="card rounded-0 shadow class-item text-decoration-none text-reset" href="./?p=yclasses/view_class&id=<?= $row['id'] ?>">
                                    <div class="position-relative">
                                        <div class="img-top position-relative class-img-holder">
                                            <img src="<?= validate_image($row['image_path']) ?>" alt="" class="class-img">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="line-height:1em">
                                            <div class="card-title w-100 mb-0"><?= $row['name'] ?></div>
                                            <div class="card-description text-muted"><small><?= $row['category_name'] ?></small></div>
                                            <div class="card-description text-right">
                                                <small class="badge badge-default bg-purple rounded-pill"><?= format_num($row['fee']) ?></small>
                                            </div>

                                            <div class="card-description w-100 truncate-3 mt-2"><small class="text-muted"><?= strip_tags(htmlspecialchars_decode($row['description'])) ?></small></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>
<script>
    $(function(){
        $('#search').on('input change', function(){
            var _f = $(this).val().toLowerCase()
            $('.class-item').each(function(){
                var txt = $(this).text().toLowerCase()
                if(txt.includes(_f)){
                    $(this).toggle(true)
                }else{
                    $(this).toggle(false)
                }
            })
        })
    })
</script>