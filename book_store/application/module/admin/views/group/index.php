<?php 
    include_once (MODULE_PATH . 'admin/views/toolbar.php');
    include_once 'submenu/index.php';
    
    // COLUMN
	@$columnPost   =	$this->arrayParams['filter_column'];
	@$orderPost    =	$this->arrayParams['filter_column_dir'];
	$lblName 	   =	Helper::cmsLinkSort('Name', 'name', $columnPost, $orderPost);
	$lblStatus     =    Helper::cmsLinkSort('Status', 'status', $columnPost, $orderPost);
	$lblGroupACP   =    Helper::cmsLinkSort('Group ACP', 'group_acp', $columnPost, $orderPost);
	$lblOrdering   =    Helper::cmsLinkSort('Ordering', 'ordering', $columnPost, $orderPost);
	$lblCreated    =    Helper::cmsLinkSort('Created', 'created', $columnPost, $orderPost);
	$lblCreatedBy  =    Helper::cmsLinkSort('Created By', 'created_by', $columnPost, $orderPost);
	$lblModified   =    Helper::cmsLinkSort('Modified', 'modified', $columnPost, $orderPost);
	$lblModifiedBy =    Helper::cmsLinkSort('Modified By', 'modified_by', $columnPost, $orderPost);
	$lblID         =    Helper::cmsLinkSort('ID', 'id', $columnPost, $orderPost);
	
	// SELECT BOX 
	$arrStatus         =   array('default' => '- Select Status -', '1' => 'Publish', '0' => 'Unpublish' );
	$selectBoxStatus   =   Helper::cmsSelectBox('filter_state', 'inputbox', $arrStatus, @$this->arrayParams['filter_state']);
	
	// SELECT GROUP ACP
	$arrGroupACP         =   array('default' => '- Select Group ACP -', '1' => 'Yes', '0' => 'No' );
	$selectGroupACP   =   Helper::cmsSelectBox('filter_group_acp', 'inputbox', $arrGroupACP, @$this->arrayParams['filter_group_acp']);
	
	// PAGINATION
	$paginationHTML    =   $this->pagination->showPagination(URL::createLink('admin', 'group', 'index'));
	
	// MESSAGE
	$message           =   Session::get('message');
	Session::delete('message');
	$strMessage        =   Helper::cmsMessage($message);
	
?>
<div id="system-message-container"><?php echo $strMessage; ?></div>

<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm">
			<!-- FILTER -->
			<fieldset id="filter-bar">
				<div class="filter-search fltlft">
					<label class="filter-search-lbl" for="filter_search">Filter:</label>
					<input type="text" name="filter_search" id="filter_search" value="<?php echo @$this->arrayParams['filter_search']; ?>" />
					<button type="submit" name="submit-keyword">Search</button>
					<button type="button" name="clear-keyword">Clear</button>

				</div>
				<div class="filter-select fltrt">
					<?php echo $selectBoxStatus . $selectGroupACP; ?>
				</div>
			</fieldset>
			<div class="clr"></div>

			<table class="adminlist" id="modules-mgr">
				<!-- HEADER TABLE -->
				<thead>
					<tr>
						<th width="1%"><input type="checkbox" name="checkall-toggle" /></th>
						<th class="title"><?php echo $lblName; ?></th>
						<th width="10%%"><?php echo $lblStatus; ?></th>
						<th width="10%"><?php echo $lblGroupACP; ?></th>
						<th width="10%"><?php echo $lblOrdering; ?></th>
						<th width="10%"><?php echo $lblCreated; ?></th>
						<th width="10%"><?php echo $lblCreatedBy; ?></th>
						<th width="10%"><?php echo $lblModified; ?></th>
						<th width="10%"><?php echo $lblModifiedBy; ?></th>
						<th width="1%" class="nowrap"><?php echo $lblID; ?></th>
					</tr>
				</thead>
				<!-- FOOTER TABLE -->
				<tfoot>
					<tr>
						<td colspan="10">
							<!-- PAGINATION -->
							<div class="container">
							     <?php echo $paginationHTML; ?>
						</td>
					</tr>
				</tfoot>
				<!-- BODY TABLE -->
				<tbody>
				    <?php 
				        if(!empty($this->Items)) :
				            $i  = 0;
				            foreach($this->Items as $key => $value) :
				               $id          =   $value['id'];
				               $ckb         =   '<input type="checkbox" name="cid[]" value="'.$id.'" />';
				               $name        =   $value['name'];
				               $row         =   ($i % 2 == 0) ? 'row0' : 'row1'; 
				               
				               // index.php?module=admin&controller=group&action=ajaxStatus&id=2&status=0
				               $status      =   Helper::cmsStatus($value['status'], URL::createLink('admin', 'group', 'ajaxStatus', array('id' => $id, 'status' => $value['status'])), $id);
				               $group_acp   =   Helper::cmsGroupACP($value['group_acp'], URL::createLink('admin', 'group', 'ajaxGroupACP', array('id' => $id, 'group_acp' => $value['group_acp'])), $id);
				               $ordering    =   '<input type="text" name="order['.$id.']" size="5" value="'.$value['ordering'].'" class="text-area-order">';
				               $created     =   Helper::formatDate('d-m-Y', $value['created']);
				               $created_by  =   $value['created_by'];
				               $modified    =   Helper::formatDate('d-m-Y', $value['modified']);
				               $modified_by =   $value['modified_by'];
				               $linkEdit    =   URL::createLink('admin', 'group', 'form', array('id' => $id));
							   
							echo '<tr class="'.$row.'">
									<td class="center">'.$ckb.'</td>
									<td><a href="'.$linkEdit.'">'.$name.'</a></td>
									<td class="center">'.$status.'</td>
									<td class="center">'.$group_acp.'</td>
									<td class="center">'.$ordering.'</td>
									<td class="center">'.$created.'</td>
									<td class="center">'.$created_by.'</td>
									<td class="center">'.$modified.'</td>
									<td class="center">'.$modified_by.'</td>
									<td class="center">'.$id.'</td>
								</tr>';
								   $i++;
							endforeach;
						endif;
					?>
				</tbody>
			</table>

			<div>
				<input type="hidden" name="filter_column" value="name" />
				<input type="hidden" name="filter_page" value="1" />
                <input type="hidden" name="filter_column_dir" value="desc" /> 
			</div>
		</form>

		<div class="clr"></div>
	</div>
</div>