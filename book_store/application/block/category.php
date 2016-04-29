<?php
	$model 	= new Model();
	
	$cateID = '';
	if(isset($this->arrayParams['book_id'])){
		$bookID	= $this->arrayParams['book_id'];
		$queryCate	= "SELECT `category_id` FROM `".TBL_BOOK."` WHERE id = '$bookID'";
		$resultCate	= $model->fetchRow($queryCate);
		$cateID		= $resultCate['category_id'];
	}else if(isset($this->arrayParams['category_id'])){
		$cateID	= $this->arrayParams['category_id'];
	}
	
	$query	= "SELECT `id`, `name` FROM `".TBL_CATEGORY."` WHERE `status`  = 1 ORDER BY `ordering` ASC";

	$listCats	= $model->fetchAll($query);
	
	
	echo $cateID;
	
	$xhtml		= '';
	if(!empty($listCats)) {
		foreach($listCats as $key => $value){
			$link	= URL::createLink('default', 'book', 'list', array('category_id' => $value['id']));
			$name	 = $value['name'];
			if($cateID == $value['id']){
				$xhtml	.= '<li><a class="active" title="'.$name.'" href="'.$link.'">'.$name.'</a></li>';
			}else{
				$xhtml	.= '<li><a title="'.$name.'" href="'.$link.'">'.$name.'</a></li>';
			}
		}
	}
?>
<div class="right_box">

	<div class="title">
		<span class="title_icon"><img src="<?php echo $imageURL; ?>/bullet5.gif" alt="" title="" /></span>Categories
	</div>

	<ul class="list">
		<?php echo $xhtml;?>
	</ul>
</div>
<div class="clear"></div>