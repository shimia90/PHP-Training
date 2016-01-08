<?php 
    $xhtml = '';
    if(!empty($this->items)) {
        foreach($this->items as $key => $value) {
            $id     =   $value['id'];
            $xhtml .= '<div class="row" id="item-'.$id.'">
                    		<p class="w-10"><input type="checkbox" name="checkbox[]" id="checkbox" value="'.$id.'" /></p>
                    		<p class="w-10">'.$value['team'].'</p>
                    		<p class="w-10">'.$id.'</p>
                    		<p class="w-10">'.$value['nickname'].'</p>
                    		<p class="w-10">'.$value['fullname'].'</p>
                    		<p class="w-10">'.$value['position'].'</p>
                    		<p class="w-10 action">
                    		  <a href="#">Edit</a>
                    		  <a href="javascript:deleteItem('.$id.');">Delete</a>
                    		</p>
                    	</div>';
        }
    }
?>
<div class="content">
    <h3>Group :: List</h3>
    <div class="list">
    	<div class="row head">
    		<p class="w-10"><input type="checkbox" name="check-all" id="check-all" /></p>
    		<p class="w-10">Team</p>
    		<p class="w-10">ID</p>
    		<p class="w-10">Nickname</p>
    		<p class="w-10">Fullname</p>
    		<p class="w-10">Position</p>
    		<p class="w-10 action">Action</p>
    	</div>
    	<?php echo $xhtml; ?>
    </div>
    <div id="dialog-confirm" title="Are you sure to delete this user?" style="display: none;">
      <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
</div>     