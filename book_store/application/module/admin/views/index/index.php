<?php
	$imageURL 	=	$this->_dirImg;
	$xhtml 		=	'';
	$arrMenu 	=	array(
						array('link' 	=>	URL::createLink('admin', 'book', 'add'), 			'name'  =>	'Add new book', 		'image' =>	'icon-48-article-add'),
						array('link' 	=>	URL::createLink('admin', 'book', 'index'), 			'name'  =>	'Book manager', 		'image' =>	'icon-48-article'),
						array('link' 	=>	URL::createLink('admin', 'category', 'index'), 		'name'  =>	'Category manager', 	'image' =>	'icon-48-category'),
						array('link' 	=>	URL::createLink('admin', 'group', 'index'), 		'name'  =>	'Group Manager', 		'image' =>	'icon-48-groups'),
						array('link' 	=>	URL::createLink('admin', 'user', 'index'), 			'name'  =>	'User Manager', 		'image' =>	'icon-48-user'),
					);
	foreach($arrMenu as $key => $value) {
		$image 	=	$imageURL . '/header/' . $value['image'] . '.png';
		$xhtml 	.=	'<div class="icon-wrapper">
                        <div class="icon">
                            <a href="'.$value['link'].'">
                                <img alt="" src="'.$image.'">
                                <span>'.$value['name'].'</span>
                            </a>
                        </div>
                    </div>';
	}
?>
<div id="element-box">
	<div class="m">
        <div class="adminform">
            <div class="cpanel-left">
                <div class="cpanel">
					<?php echo $xhtml; ?>
                </div>
            </div>
            
        </div>
        <div class="clr"></div>
    </div>
</div>