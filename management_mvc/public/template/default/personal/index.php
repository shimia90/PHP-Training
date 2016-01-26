<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?php echo $this->_metaHTTP;?>
	<?php echo $this->_metaName;?>
    <title><?php echo $this->_title;?></title>
    <?php echo $this->_cssFiles;?>
    <?php echo $this->_jsFiles;?>
</head>
<body>
<?php include_once 'html/header.php'; ?>
<!--  CONTENT -->
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12" id="content">
            <div class="row-fluid">
                <?php require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php'; ?>
            </div><!-- row-fluid -->
        </div><!--  span12 -->
    </div><!-- row-fluid -->
</div><!--  container-fluid -->
<?php include_once 'html/footer.php'; ?>