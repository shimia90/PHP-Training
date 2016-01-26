<div class="block">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?php echo $this->_title; ?></div>
    </div><!--  navbar -->
    <div class="block-content collapse in">
        <div class="span12">
            
            <div id="search-information">
                <div class="span8">
                    <div id="example_length">
                        <!-- User Search Form -->
                        <form action="#" method="post" id="user_form" class="form-inline mb_10">
                            <label>
                                Name: 
                                <!-- User Select -->
                                <?php echo Helper::createUserSelect($this->Users, 'user_name', 'user_name', 'Select User'); ?> 
                            </label>
                            <label>
                                From <span id="two-inputs"><input id="date-range200" size="20" name="date_from" value=""> To <input id="date-range201" size="20" name="date_to" value=""></span>
                            </label>
                            <input type="hidden" name="type" value="single" />
                            <input type="hidden" name="page_submit" value="record" />
                            <button class="btn btn-warning" type="submit">Search</button>
                        </form>
                       <!-- User Search Form -->
                       
                       <!-- Alert Message -->
                       <?php if(isset($_POST['user_name']) && trim($_POST['user_name']) == '') : echo Helper::createAlert('Username is empty!', 'Please select a user'); ?>
                       <?php elseif(isset($_POST['date_from']) && trim($_POST['date_from'] == '') || isset($_POST['date_to']) && trim($_POST['date_to'] == '') ) : echo Helper::createAlert('Date is empty!', 'Please select date'); ?>
                       <?php elseif(isset($_POST['date_from']) && isset($_POST['user_name']) && isset($_POST['date_to']) && $_POST['date_from'] == '' && $_POST['date_to'] == '' && $_POST['user_name'] == '') : echo Helper::createAlert('These fields are empty!', 'Please input'); endif; ?>
                       <!-- Alert Message -->
                    </div>
                    
                    <!-- Working Time -->
                    
                    <!-- Working Time -->
                </div><!-- span8 -->
                <div class="span4 text-right">
                
                </div>
            </div><!-- search-information -->
            
        </div><!-- span12 -->
    </div><!-- block-content -->
</div>