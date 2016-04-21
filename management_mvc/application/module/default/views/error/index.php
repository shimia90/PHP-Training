<div class="error-pages">

    <img src="<?php echo TEMPLATE_URL . '/default/main/img'?>/404.png" alt="404" class="icon" width="400" height="260">
    <h1>Sorry but we couldn't find this page</h1>
    <h4>It seems that this page doesn't exist or has been removed</h4>

    <div class="bottom-links">
      <a href="#" class="btn btn-default" onclick="window.history.back();">Go Back</a>
      <a href="<?php echo URL::createLink('default', 'index', 'index')?>" class="btn btn-light">Go Homepage</a>
    </div>

</div>