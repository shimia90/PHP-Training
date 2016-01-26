<?php 
    // New Button
    $linkNew        =   URL::createLink('admin', 'group', 'add');
    $btnNew         =   Helper::cmsButton('New', 'toolbar-popup-new', $linkNew, 'icon-32-new');
    
    // Publish
    $linkPublish    =   URL::createLink('admin', 'group', 'index');
    $btnPublish     =   Helper::cmsButton('Publish', 'toolbar-publish', $linkPublish, 'icon-32-publish');
    
    // Unpublish
    $linkUnPublish  =   URL::createLink('admin', 'group', 'index');
    $btnUnPublish   =   Helper::cmsButton('Unpublish', 'toolbar-unpublish', $linkUnPublish, 'icon-32-unpublish');
    
    // Trash
    $linkTrash      =   URL::createLink('admin', 'group', 'index');
    $btnTrash       =   Helper::cmsButton('Trash', 'toolbar-trash', $linkTrash, 'icon-32-trash');
    
    // Save
    $linkSave       =   URL::createLink('admin', 'group', 'add');
    $btnSave        =   Helper::cmsButton('Save', 'toolbar-apply', $linkSave, 'icon-32-apply');
    
    // Save & Close
    $linkSaveClose  =   URL::createLink('admin', 'group', 'add');
    $btnSaveClose   =   Helper::cmsButton('Save & Close', 'toolbar-save', $linkSaveClose, 'icon-32-save');
    
    // Save & New
    $linkSaveNew    =   URL::createLink('admin', 'group', 'add');
    $btnSaveNew     =   Helper::cmsButton('Save & New', 'toolbar-save-new', $linkSaveNew, 'icon-32-save-new');
    
    // Cancel
    $linkCancel     =   URL::createLink('admin', 'group', 'add');
    $btnCancel      =   Helper::cmsButton('Cancel', 'toolbar-cancel', $linkSaveNew, 'icon-32-cancel');
    
    switch ($this->arrayParams['action']) {
        case 'index': 
            $strButton      =   $btnNew . $btnPublish . $btnUnPublish . $btnTrash; 
            break;
        case 'add':
            $strButton      =   $btnSave . $btnSaveClose . $btnSaveNew . $btnCancel;
            break;
    }
?>
<div id="toolbar-box">
	<div class="m">
		<!-- TOOLBAR -->
		<div class="toolbar-list" id="toolbar">
			<ul>
				<?php echo $strButton; ?>
			</ul>
			<div class="clr"></div>
		</div>
		<!-- TITLE -->
		<div class="pagetitle icon-48-groups">
			<h2><?php echo $this->_title;?></h2>
		</div>
	</div>
</div>