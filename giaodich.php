<?php 
session_start();
require_once 'backend-index.php';
require_once 'layout/second_header.php';

// FIX 1: Tách riêng các biến. $money phải là số 0, $sl phải là mảng
$ten = $quan = $dc = $sodt = "";
$money = 0; 
$sl = [];

if(isset($_POST['ten']))  { $ten  = $_POST['ten'];  }
if(isset($_POST['quan'])) { $quan = $_POST['quan']; }
if(isset($_POST['dc']))   { $dc   = $_POST['dc'];   }
if(isset($_POST['sodt'])) { $sodt = $_POST['sodt']; }
if(isset($_POST['sl']))   { $sl   = $_POST['sl'];   }

// Kiểm tra rỗng
if($ten == "" || $quan == "" || $dc == "" || $sodt == ""){
    echo "<div class='container'><h3 style='color:red;'>Không được để trống bất kỳ thông tin giao hàng nào!</h3></div>";
    require_once 'layout/second_footer.php';
    return 0;
}

date_default_timezone_set('Asia/Ho_Chi_Minh');
$now = date("Y-m-d H:i:s");
$conn = connect();
mysqli_set_charset($conn, 'utf8');

// 1. Tính tổng tiền
for($i = 0; $i < count($sl); $i++){
    if($sl[$i] < 1){ // Đồ ăn vặt tối thiểu phải mua 1 món chứ
        echo "<h3 style='color: red; padding: 30px;'>Số lượng sản phẩm không hợp lệ!</h3>";
        require_once 'layout/second_footer.php';
        return 0;
    }
    // Lấy giá từ session cost đã lưu ở trang order.php
    $x = (int)str_replace(' ','',$_SESSION['cost'][$i]);
    $money += (int)$sl[$i] * $x; // Đảm bảo tất cả đều là số khi nhân cộng
}

if($money == 0){
    echo "<h3 style='color: red; padding: 30px;'>Đơn hàng không có giá trị!</h3>";
    require_once 'layout/second_footer.php';
    return 0;
}
?>

<div class="container" style="min-height: 400px; padding: 50px 0;">
    <div class="row">
        <div class="col-sm-12" style="text-align: center;">
            <h2 style="color: green;">✔ Đặt hàng THÀNH CÔNG!</h2>
            <p style="font-size: 18px;">Cảm ơn bạn <b><?php echo $ten; ?></b> đã ủng hộ <b>Vua Ăn Vặt</b>!</p>
            <div style="background: #f9f9f9; padding: 20px; display: inline-block; border-radius: 10px; border: 1px dashed #ccc;">
                Giá trị đơn hàng: <b style="color: red; font-size: 24px;"><?php echo number_format($money, 0, ","," ") ?> VND</b><br>
                <small>(Thanh toán tiền mặt khi nhận hàng - Ship khu vực Hà Nội)</small>
            </div>
            <br><br>
            <a href="index.php" class="btn btn-primary">Tiếp tục mua món khác</a>
            <br><br>
            <img src="images/tks4buying.png" style="max-width: 200px; opacity: 0.7;" alt="Cảm ơn bạn">
        </div>
    </div>
</div>

<?php
// 2. Lưu vào bảng giaodich
$user_id = (isset($_SESSION['rights']) && $_SESSION['rights'] == "user" && isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;

// FIX 2: Dùng NULL cho cột ID tự tăng thay vì chuỗi rỗng ''
$sql_gd = "INSERT INTO giaodich VALUES (NULL, 0, '$user_id', '$ten', '$quan', '$dc', '$sodt', '$money', '$now')";

if(mysqli_query($conn, $sql_gd)){
    $last_magd = mysqli_insert_id($conn); 
    
    // 3. Xử lý lưu chi tiết đơn hàng (chitietgd)
    if(isset($_SESSION['buynow']) && $_SESSION['buynow'] != ""){
        // Trường hợp "Mua ngay"
        $buynow = $_SESSION['buynow'];
        $sql_ct = "INSERT INTO chitietgd VALUES ('$last_magd', '$buynow', '".$sl[0]."')";
        mysqli_query($conn, $sql_ct);
        unset($_SESSION['buynow']); 
    } else {
        // Trường hợp mua từ giỏ hàng
        $cart_name = (isset($_SESSION['rights']) && $_SESSION['rights'] == "user") ? 'user_cart' : 'client_cart';
        $new_masp = $_SESSION[$cart_name];
        array_shift($new_masp); // Bỏ 'tmp'
        
        for($i = 0; $i < count($new_masp); $i++){
            $masp = $new_masp[$i];
            $so_luong = $sl[$i];
            $sql_ct = "INSERT INTO chitietgd VALUES ('$last_magd', '$masp', '$so_luong')";
            mysqli_query($conn, $sql_ct);
        }
        
        // 4. XÓA GIỎ HÀNG SAU KHI ĐẶT THÀNH CÔNG
        $_SESSION[$cart_name] = array("tmp");
        if(isset($_SESSION['rights']) && $_SESSION['rights'] == "user"){
            $sql_del_db = "DELETE FROM giohang WHERE user_id = '$user_id'";
            mysqli_query($conn, $sql_del_db);
        }
    }
} else {
    echo "<p align='center' style='color:red;'>Lỗi hệ thống: Không thể lưu đơn hàng. Vui lòng liên hệ hotline!</p>";
}

disconnect($conn);
require_once 'layout/second_footer.php';
?>