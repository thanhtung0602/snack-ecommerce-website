
<?php

require_once 'backend-index.php';


$fname = "";
if(isset($_GET['fname'])){
	$fname = $_GET['fname'];
}
switch ($fname) {
	case 'php_saling':
	php_saling();
	break;
	case 'php_new':
	php_new();
	break;
	case 'php_buy':
	php_buy();
	break;
	case 'php_dmsp':
	php_danhmucsp();
	break;
	case 'php_dangky':
	php_dangky();
	break;
	case 'php_dangnhap':
	php_dangnhap();
	break;
	case 'php_giohang':
	php_giohang();
	break;
	case 'php_like':
	php_like();
	break;
	case 'php_search':
	php_search();
	break;
	case 'load_more':
	load_more();
	break;

	default:
	echo "Yêu cầu không tìm thấy!";		
}
function load_more(){
	session_start();
	$cr = '';
	if(isset($_GET['current'])){$cr = $_GET['current'];}
	$st = ($cr+1)*$_SESSION['limit'];
	if($st >= $_SESSION['total']){
		echo "hetrdungbamnua";
	}
	$sql = $_SESSION['sql'] . " LIMIT ".$st.",".$_SESSION['limit']."";
	$conn = mysqli_connect('localhost','root','','qlbh') or die('Không thể kết nối!');
	
	mysqli_set_charset($conn, 'utf8');
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)){
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
}
function php_saling(){
	session_start();
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.khuyenmai DESC LIMIT ".$_SESSION['limit']."";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result))  {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
	$_SESSION['sql'] = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.khuyenmai DESC";
	?>
	<div class="container-fluid text-center">
	<button onclick="load_more(0)" id="loadmorebtn" class="snip1582">Load more</button>
	</div>
	<?php

}
function php_new(){
	session_start();
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.ngay_nhap DESC LIMIT ".$_SESSION['limit']."";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result))  {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
	$_SESSION['sql'] = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.ngay_nhap DESC ";
	?>
	<div class="container-fluid text-center">
	<button onclick="load_more(0)" id="loadmorebtn" class="snip1582">Load more</button>
	</div>
	<?php
}
function php_buy(){
	session_start();
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.luotmua DESC LIMIT ".$_SESSION['limit']."";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result))  {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
	$_SESSION['sql'] = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.luotmua DESC";
	?>
	<div class="container-fluid text-center">
	<button onclick="load_more(0)" id="loadmorebtn" class="snip1582">Load more</button>
	</div>
	<?php
}

function php_danhmucsp(){
    session_start();
    $conn = connect();
    mysqli_set_charset($conn, 'utf8');
    
    $detail = isset($_GET['detail']) ? mysqli_real_escape_string($conn, $_GET['detail']) : "all";

    if ($detail == 'all') {
        $sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm ORDER BY sp.gia ASC";
    } else {
        // Tự động tìm món có tên chứa từ khóa (Ví dụ: bấm 'cay' sẽ ra 'Đồ ăn vật cay')
        $sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND dm.tendm LIKE '%$detail%' ORDER BY sp.gia ASC";
    }

    $sqlx = $sql;
    $sql .= " LIMIT ".$_SESSION['limit'];
    
    echo "<h3>Danh mục: " . ucwords($detail) . "</h3>";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
                <a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
                    <div style="text-align: center;" class='product-img'>
                        <img src='<?php echo $row['anhchinh'] ?>'>
                    </div>
                    <div class='product-info'>
                        <h4><b><?php echo $row['tensp'] ?></b></h4>
                        <b class='price'>Giá: <?php echo number_format($row['gia']) ?> VND</b>
                        <div class='buy'>
                             <a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        }
    } else {
        echo "<div class='container-fluid'><i>Hiện chưa có món nào trong mục này!</i></div>";
    }
    
    disconnect($conn);
	$_SESSION['sql'] = $sqlx;
	?>
	<div class="container-fluid text-center">
	<button onclick="load_more(0)" id="loadmorebtn" class="snip1582">Load more</button>
	</div>
	<?php
}
    
    
	
function php_dangky(){
	require_once 'signUp.php';
}
function php_dangnhap(){
	require_once 'signIn.php';
}
function php_giohang(){
    ?>
    <div class="container-fluid form" style="padding: 20px">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <legend><h2>Giỏ hàng của bạn</h2></legend>

                <?php
                session_start();
                
                // --- XỬ LÝ KHI NGƯỜI DÙNG ĐÃ ĐĂNG NHẬP ---
                if(isset($_SESSION['user'])){
                    $tmpArr = $_SESSION['user_cart'];
                    array_shift($tmpArr);
                    $tmpArr = array_unique($tmpArr);
                    
                    if(count($tmpArr) == 0){
                        echo "<h4>Giỏ hàng trống</h4>";
                        echo "<i>Ây da, bạn chưa chọn món ăn vặt nào cả :)</i>";
                    } else {
                        $conn = connect();
                        mysqli_set_charset($conn, 'utf8');
                        $x = '('.implode(',',$tmpArr).')';
                        $sql = "SELECT * FROM sanpham WHERE masp IN ".$x;
                        $result = mysqli_query($conn, $sql);
                        
                        while ($row = mysqli_fetch_assoc($result)) {?>
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; padding: 15px 0; margin-bottom: 10px;">
                                <div style="display: flex; align-items: center;">
                                    <img src="<?php echo $row['anhchinh'] ?>" style="width: 70px; height: 70px; object-fit: cover; margin-right: 20px; border: 1px solid #eee; border-radius: 5px;">
                                    <div>
                                        <h4 style="margin: 0; color: #333;"><b><?php echo $row['tensp'] ?></b></h4>
                                        <span style="color: red; font-weight: bold; font-size: 16px;"><?php echo number_format($row['gia']) ?> VNĐ</span>
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm" onclick="addtocart_action('<?php echo $row['masp'] ?>'); ajax_giohang();">Xóa ✖</button>
                            </div>
                            <?php } ?>
                        <div style="clear: both; margin-top: 25px;"></div>
                        <a href="order.php?q=multi" class="btn btn-success btn-block" style="color: white; font-size: 22px; padding: 12px; border-radius: 8px;">🛒 Thanh toán (Đặt Hàng)</a>
                    <?php } 
                    
                // --- XỬ LÝ KHI KHÁCH VÃNG LAI (CHƯA ĐĂNG NHẬP) ---
                } else {
                    if(isset($_SESSION['client_cart'])){
                        $arr = $_SESSION['client_cart'];
                        array_shift($arr);
                        $arr = array_unique($arr);
                        
                        if(count($arr) == 0){
                            echo "<h4>Giỏ hàng trống</h4>";
                            echo "<i>Ây da, bạn chưa chọn món ăn vặt nào cả :)</i>";
                        } else {
                            $conn = connect();
                            mysqli_set_charset($conn, 'utf8');
                            $in = '('.implode(',',$arr).')';
                            $sql = "SELECT * FROM sanpham WHERE masp IN ".$in;
                            $result = mysqli_query($conn, $sql);
                            
                            while ($row = mysqli_fetch_assoc($result)) {?>
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; padding: 15px 0; margin-bottom: 10px;">
                                    <div style="display: flex; align-items: center;">
                                        <img src="<?php echo $row['anhchinh'] ?>" style="width: 70px; height: 70px; object-fit: cover; margin-right: 20px; border: 1px solid #eee; border-radius: 5px;">
                                        <div>
                                            <h4 style="margin: 0; color: #333;"><b><?php echo $row['tensp'] ?></b></h4>
                                            <span style="color: red; font-weight: bold; font-size: 16px;"><?php echo number_format($row['gia']) ?> VNĐ</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger btn-sm" onclick="addtocart_action('<?php echo $row['masp'] ?>'); ajax_giohang();">Xóa ✖</button>
                                </div>
                                <?php } ?>
                            <div style="clear: both; margin-top: 25px;"></div>
                            <a href="order.php?q=multi" class="btn btn-success btn-block" style="color: white; font-size: 22px; padding: 12px; border-radius: 8px;">🛒 Thanh toán (Đặt Hàng)</a>
                        <?php }
                    } else {
                        echo "<h4>Giỏ hàng trống</h4>";
                        echo "<i>Ây da, bạn chưa chọn món ăn vặt nào cả :)</i>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}


function php_like(){
    ?>
    <div class="container-fluid form" style="margin-top: -23px; padding: 20px">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <legend><h2>SẢN PHẨM YÊU THÍCH</h2></legend>

                <?php
                session_start();
                if(isset($_SESSION['user'])){
                    $tmpArr = isset($_SESSION['like']) ? $_SESSION['like'] : ['tmp'];
                    
                    // Cắt bỏ giá trị 'tmp' rác
                    if(is_array($tmpArr) && count($tmpArr) > 0){
                        array_shift($tmpArr); 
                        $tmpArr = array_unique($tmpArr);
                    }

                    // Kiểm tra nếu danh sách trống thì dừng lại ngay, KHÔNG chạy SQL
                    if(empty($tmpArr)){
                        echo "<h4>BẠN CHƯA THÍCH SẢN PHẨM NÀO!</h4>";
                        echo "<i>Quay lại trang chủ và thả tym nhé :)</i>";
                    } else {
                        // Nếu có sản phẩm mới chạy SQL
                        $conn = connect();
                        mysqli_set_charset($conn, 'utf8');
                        $x = '('.implode(',',$tmpArr).')';
                        $sql = "SELECT * FROM sanpham WHERE masp IN ".$x;
                        $result = mysqli_query($conn, $sql);
                        
                        while ($row = mysqli_fetch_assoc($result)) {?>
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; padding: 15px 0; margin-bottom: 10px;">
                                <div style="display: flex; align-items: center; cursor: pointer;" onclick="hien_sanpham('<?php echo $row['masp'] ?>')" data-toggle='modal' data-target='#modal-id'>
                                    <img src="<?php echo $row['anhchinh'] ?>" style="width: 70px; height: 70px; object-fit: cover; margin-right: 20px; border: 1px solid #eee; border-radius: 5px;">
                                    <div>
                                        <h4 style="margin: 0; color: #333;"><b><?php echo $row['tensp'] ?></b></h4>
                                        <span style="color: red; font-weight: bold; font-size: 16px;"><?php echo number_format($row['gia']) ?> VNĐ</span>
                                    </div>
                                </div>
                                <div>
                                    <a href="order.php?masp=<?php echo $row['masp'] ?>" class="btn btn-success btn-sm">Mua ngay</a>
                                    <button class="btn btn-default btn-sm" onclick="like_action('<?php echo $row['masp'] ?>'); ajax_like();">Bỏ thích ✖</button>
                                </div>
                            </div>
                            <?php } ?>

                        <div style="clear: both; margin-top: 25px;"></div>
                        <a href="order.php?q=buylikepr" class="btn btn-success btn-block" style="color: white; font-size: 22px; padding: 12px; border-radius: 8px;">🛒 Mua tất cả</a>
                    <?php }
                } else {
                    ?>
                    <i>Xin lỗi, bạn phải <a style="cursor:pointer;" onclick="ajax_dangnhap()">đăng nhập</a> để xem những sản phẩm yêu thích của mình! Nếu chưa có tài khoản, hãy <a style="cursor:pointer;" onclick="ajax_dangky()">đăng ký ngay</a></i>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}

function php_search(){
	$s = $_GET['s'];
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND tensp like '%".$s."%'";
	$result = mysqli_query($conn, $sql);
	?>
	<h4>Kết quả tìm kiếm cho: <?php echo $s ?></h4>
	<?php
	if(mysqli_num_rows($result) == 0){
		echo "<i>Không có kết quả! Hãy thử bằng tên một loại đồng hồ hoặc mẫu mã của nó!</i>";
	}
	while ($row = mysqli_fetch_assoc($result))  {
		$d = strtotime($row['ngay_nhap']);
		?>
		<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
			<a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
				<div style="text-align: center;" class='product-img'>
					<img src='<?php echo $row['anhchinh'] ?>'>
				</div>
				<div class='product-info'>
					<h4><b><?php echo $row['tensp'] ?></b></h4>
					<b class='price'>Giá: <?php echo $row['gia'] ?> VND</b>
					<div class='buy'>
						<a onclick="like_action('<?php echo $row['masp'] ?>')" class='btn btn-default btn-md unlike-container  <?php
						if($_SESSION['rights'] == 'user'){
							if(in_array($row['masp'],$_SESSION['like'])){
								echo 'liked';
							}
						}
						?>'>
						<i class='glyphicon glyphicon-heart unlike'></i>
					</a>
					<a class='btn btn-primary btn-md cart-container <?php 
					if($_SESSION['rights'] == "default"){
						if(in_array($row['masp'],$_SESSION['client_cart'])){
							echo 'cart-ordered';
						} 
					} else {
						if(in_array($row['masp'],$_SESSION['user_cart'])){
							echo 'cart-ordered';
						}
					} ?> '  onclick="addtocart_action('<?php echo $row['masp'] ?>')">
					<i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
					<a class="snip0050" href='order.php?masp=<?php echo $row['masp'] ?>'><span>Mua ngay</span><i class="glyphicon glyphicon-ok"></i></a>
				</div>
			</div>
		</a></div>
		<?php
	}
	disconnect($conn);
}


?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".cart-container").click(function(){
			$(this).toggleClass('cart-ordered');
		});
	});
</script>