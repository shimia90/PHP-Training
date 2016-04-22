<?php
    @$catID          =       $this->arrayParams['category_id'];
    $model          =       new Model();
    
    $query          =       "SELECT `id`, `name` FROM `category` WHERE `status` = 1 ORDER BY `ordering` ASC";
    $listCats       =       $model->fetchAll($query);
    $xhtml          =       '';
    if(!empty($listCats)) {
        foreach ($listCats as $key => $value) {
            $link       =    URL::createLink('default', 'book', 'list', array('category_id'  =>  $value['id']));
            $name       =       $value['name'];
            if($catID == $value['id']) {
                $xhtml      .=      '<li><a class="active" title="'.$name.'" href="'.$link.'">'.$name.'</a></li>';
            } else {
                $xhtml      .=      '<li><a title="'.$name.'" href="'.$link.'">'.$name.'</a></li>';
            }
        }
    }
    
?>
<div class="right_box">

	<div class="title">
		<span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet5.gif" alt="" title="" /></span>Categories
	</div>

	<ul class="list">
		
		<?php echo $xhtml; ?>
	</ul>

</div>