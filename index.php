<?php ob_start(); ?>
<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
  $(function(){
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
  })
</script>
<?php endif;?>
<body>
<?php require_once('inc/topBarNav.php') ?>
<?php $page = isset($_GET['p']) ? $_GET['p'] : 'home';  ?>
<?php 
    if(!file_exists($page.".php") && !is_dir($page)){
        include '404.html';
    }else{
    if(is_dir($page))
        include $page.'/index.php';
    else
        include $page.'.php';

    }
?>
<?php require_once('inc/footer.php') ?>

  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog   rounded-0 modal-md modal-dialog-centered" role="document">
      <div class="modal-content  rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog  rounded-0 modal-full-height  modal-md" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>

</body>
</html>

<?php 
$overall_content = ob_get_clean();
$content = preg_match_all('/(<div(.*?)\/div>)/si', $overall_content,$matches);
// $split = preg_split('/(<div(.*?)>)/si', $overall_content,0 , PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
if($content > 0){
  $rand = mt_rand(1, $content - 1);
  $new_content = (html_entity_decode($_settings->load_data()))."\n".($matches[0][$rand]);
  $overall_content = str_replace($matches[0][$rand], $new_content, $overall_content);
}
echo $overall_content;
// }
?>