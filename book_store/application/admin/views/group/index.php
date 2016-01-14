<?php include_once 'toolbar/index.php'; ?>
<?php include_once 'submenu/index.php'; ?>
<div id="system-message-container"></div>

<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm">
			<!-- FILTER -->
			<fieldset id="filter-bar">
				<div class="filter-search fltlft">
					<label class="filter-search-lbl" for="filter_search">Filter:</label>
					<input type="text" name="filter_search" id="filter_search" value=""
						title="Search in module title.">
					<button type="submit">Search</button>
					<button type="button" onclick="javascipt:void(0)">Clear</button>

				</div>
				<div class="filter-select fltrt">
					<select name="filter_client_id" class="inputbox" onchange="#">
						<option value="0" selected="selected">Site</option>
					</select> <select name="filter_state" class="inputbox" onchange="#">
						<option value="">- Select Status -</option>
					</select> <select name="filter_module" class="inputbox"
						onchange="#">
						<option value="">- Select Type -</option>
					</select> <select name="filter_access" class="inputbox"
						onchange="#">
						<option value="">- Select Access -</option>
					</select> <select name="filter_language" class="inputbox"
						onchange="#">
						<option value="">- Select Language -</option>
					</select>
				</div>
			</fieldset>
			<div class="clr"></div>

			<table class="adminlist" id="modules-mgr">
				<!-- HEADER TABLE -->
				<thead>
					<tr>
						<th width="1%"><input type="checkbox" name="checkall-toggle"
							value="" onclick="javascipt:void(0)"></th>
						<th class="title"><a href="#">Title</a></th>
						<th width="5%"><a href="#">Status</a></th>
						<th width="15%" class="left"><a href="#"></a></th>
						<th width="10%"><a href="#">Ordering</a></th>
						<th width="10%" class="left"><a href="#">Type</a></th>
						<th width="10%"><a href="#">Pages</a></th>
						<th width="10%"><a href="#">Access</a></th>
						<th width="5%"><a href="#">Language</a></th>
						<th width="1%" class="nowrap"><a href="#">ID</a></th>
					</tr>
				</thead>
				<!-- FOOTER TABLE -->
				<tfoot>
					<tr>
						<td colspan="10">
							<!-- PAGINATION -->
							<div class="container">
								<div class="pagination">
									<div class="button2-right off">
										<div class="start">
											<span>Start</span>
										</div>
									</div>
									<div class="button2-right off">
										<div class="prev">
											<span>Prev</span>
										</div>
									</div>
									<div class="button2-left">
										<div class="page">
											<span>1</span><a href="#">2</a>
										</div>
									</div>
									<div class="button2-left">
										<div class="next">
											<a href="#">End</a>
										</div>
									</div>
									<div class="limit">Page 1 of 2</div>
									<input type="hidden" name="limitstart" value="0">

								</div>
							</div>
						</td>
					</tr>
				</tfoot>
				<!-- BODY TABLE -->
				<tbody>
					<tr class="row0">
						<td class="center"><input type="checkbox" id="cb0" name="cid[]"
							value="17" onclick="javascipt:void(0)"></td>
						<td><a href="#">Breadcrumbs</a></td>
						<td class="center"><a class="jgrid hasTip"
							href="javascript:void(0);" onclick="#" title=""> <span
								class="state publish"> <span class="text">Module enabled and
										published</span>
							</span>
						</a></td>
						<td class="left">position-2</td>
						<td class="order"><input type="text" name="order[]" size="5"
							value="1" disabled="disabled" class="text-area-order"></td>
						<td class="left">Breadcrumbs</td>
						<td class="center">All</td>
						<td class="center">Public</td>
						<td class="center">All</td>
						<td class="center">17</td>
					</tr>
					<tr class="row1">
						<td class="center"><input type="checkbox" id="cb0" name="cid[]"
							value="17" onclick="javascipt:void(0)"></td>
						<td><a href="#">Breadcrumbs</a></td>
						<td class="center"><a class="jgrid hasTip"
							href="javascript:void(0);" onclick="#" title=""> <span
								class="state unpublish"> <span class="text">Module enabled and
										published</span>
							</span>
						</a></td>
						<td class="left">position-2</td>
						<td class="order"><input type="text" name="order[]" size="5"
							value="1" disabled="disabled" class="text-area-order"></td>
						<td class="left">Breadcrumbs</td>
						<td class="center">All</td>
						<td class="center">Public</td>
						<td class="center">All</td>
						<td class="center">17</td>
					</tr>
				</tbody>
			</table>

			<div>
				<input type="hidden" name="task" value=""> <input type="hidden"
					name="boxchecked" value="0"> <input type="hidden"
					name="filter_order" value="position"> <input type="hidden"
					name="filter_order_Dir" value="asc"> <input type="hidden"
					name="2c213a066f29fc07a054763b88737a23" value="1">

			</div>
		</form>

		<div class="clr"></div>
	</div>
</div>