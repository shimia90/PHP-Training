<?php 
require_once 'connect.php';

// Tong So Phan Tu
$totalItems             =   $database->totalItem("SELECT COUNT(`id`) AS 'totalItem' FROM `user`");

// Tong So Phan Tu Xuat Hien Tren 1 Trang
$totalItemsPerPage      =   1;   

// So trang xuat hien
$pageRange              =   5;
if($pageRange % 2 == 0) {
    $pageRange += 1;
}

// Tong So Trang
$totalPages             =   ceil($totalItems/$totalItemsPerPage);

// Trang Hien Tai
$currentPage            =   (isset($_GET['page'])) ? $_GET['page'] : 1;

//
$position               =   ($currentPage - 1)* $totalItemsPerPage;

$listPages              =   '';

if($currentPage < 1 && $currentPage > $totalPages || !(is_int($currentPage))) {
    header("location: error.php");
    exit();
}

$paginationHTML = '';
if($totalPages > 1) {
    // PAGINATION
    
    $start = '<li>Start</li>';
    $prev  = '<li>Previous</li>';
    if($currentPage > 1) {
        $start = '<li><a href="?page=1">Start</a></li>';
        $prev  = '<li><a href="'.($currentPage - 1).'">Previous</a></li>';
    }
    
    $next = '<li>Next</li>';
    $end  = '<li>End</li>';
    if($currentPage < $totalPages) {
        $start = '<li><a href="?page='.($currentPage + 1).'">Next</a></li>';
        $prev  = '<li><a href="'.$totalPages.'">End</a></li>';
    }
    
    if($pageRange < $totalPages) {
        if($currentPage == 1) {
            $startPage  =   1;
            $endPage    =   $pageRange;
        } else if($currentPage == $totalPages){
            $startPage      =       $totalPages - $pageRange + 1;
            $endPage        =       $totalPages;
        } else {
            $startPage      =       $currentPage - ($pageRange - 1)/ 2;
            $endPage        =       $currentPage + ($pageRange + 1)/ 2;
            
            if($startPage < 1) {
                $endPage    =   $endPage + 1;
                $startPage  =   1;
            }
            
            if($endPage > $totalPages) {
                
                $endPage    =   $totalPages;
                $startPage  =   $endPage - $pageRange + 1;
            }
        }
        
    } else {
        $startPage = 1;
        $endPage = $totalPages;
    }
    
    for($i = $startPage; $i <= $endPage; $i++) {
        if($i == $currentPage) {
            $listPages  .= '<li class="active">'.$i.'</li>';
        } else {
            $listPages  .= '<li><a href="?page='.$i.'">'.$i.'</a></li>';
        }
    }
    
    $paginationHTML         =   '<ul class="pagination">' . $start . $prev . $listPages . $next . $end . '</ul>';
    
    $start      =       '<li>Start</li>';
    $prev      =       '<li>Previous</li>';
    if($currentPage > 1) {
        $start      =       '<li><a href="?page=1">Start</a></li>';
        $prev      =       '<li><a href="?page='.($currentPage - 1).'">Previous</a></li>';
    }
    
    $next      =       '<li>Next</li>';
    $end      =       '<li>End</li>';
    if($currentPage < $totalPages) {
        $next      =       '<li><a href="?page='.($currentPage + 1).'">Next</a></li>';
        $end      =       '<li><a href="?page='.$totalItems.'">End</a></li>';
    }
    
    
    $paginationHTML         =   '<ul class="pagination">'.$start . $prev. $listPages . $next . $end .'</ul>';
} else {
    $paginationHTML = '';
}

$query[]          =   "SELECT `id`, `username`, CONCAT(`firstname`, ' ', `lastname`) AS fullname, `email`, `birthday`, `status`, `ordering`";
$query[]          =   "FROM `user`";
$query[]          =   "LIMIT $position, $totalItemsPerPage";
$query            =   implode(" ", $query);
$list           =   $database->listRecord($query);
$xhtml          =   '';
if(!empty($list)) {
    $i =    0;
    foreach($list as $key => $item) {
        $row    =   ($i % 2 == 0) ? "odd" : "even";
        $status =   ($item['status'] = 0) ? 'Inactive' : 'Active';
        $xhtml  .=   '<div class="row '.$row.'">
                        <p class="id">'.$item['id'].'</p>
                        <p class="username">'.$item['id'].'</p>
                        <p class="fullname">'.$item['fullname'].'</p>
                        <p class="email">'.$item['email'].'</p>
                        <p class="birthday">'.date('d-m-Y', strtotime($item['birthday'])).'</p>
                        <p class="status">'.$status.'</p>
                        <p class="ordering">'.$item['ordering'].'</p>
                    </div>';
    }
} else {
    $xhtml  .=   'Comming Soon';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Manage User</title>
</head>
<body>
	<div id="wrapper">
		<div class="title">Manage User</div>
		<div class="list">
			<div class="row head">
				<p class="id">ID</p>
				<p class="username">UserName</p>
				<p class="fullname">Full Name</p>
				<p class="email">Email</p>
				<p class="birthday">Birthday</p>
				<p class="status">Status</p>
				<p class="ordering">Ordering</p>
			</div>
			<?php echo $xhtml; ?>
		</div>
		<div id="pagination">
			<?php echo $paginationHTML; ?>
		</div>
	</div>
</body>
</html>