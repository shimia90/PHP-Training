<?php include_once 'html/header.php'; ?>
<!--  CONTENT -->
<div id="content-box">
<?php require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php'; ?>
</div>
<?php include_once 'html/footer.php'; ?>