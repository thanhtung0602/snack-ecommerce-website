<?php 
require_once 'layout/second_header.php' ;
require_once 'backend-index.php';
$masp = $q = "";
$_SESSION['cost'] = []; 
$sql = "SELECT * FROM sanpham WHERE 1=0"; 

if(isset($_GET['masp'])){
    $masp = $_GET['masp'];
    $_SESSION['buynow'] = $masp;
}

if(isset($_GET['q'])){
    $q = $_GET['q'];
    if($q == 'multi'){
        if($_SESSION['rights'] == "default"){
            if(isset($_SESSION['client_cart']) && count($_SESSION['client_cart']) > 1){
                $tmpArr = $_SESSION['client_cart'];
                array_shift($tmpArr);
                $x = '('.implode(',',$tmpArr).')';
                $sql = "SELECT * FROM sanpham WHERE masp in ".$x."";
            } else {
                echo "<script>alert('Giỏ hàng trống!')</script>";
                return 0;
            }
        } else {
            $tmpArr = $_SESSION['user_cart'];
            array_shift($tmpArr);
            $x = '('.implode(',',$tmpArr).')';
            $sql = "SELECT * FROM sanpham WHERE masp in ".$x."";
        }
    } elseif($q == 'buylikepr'){
        $tmpArr = $_SESSION['like'];
        array_shift($tmpArr);
        $x = '('.implode(',',$tmpArr).')';
        $sql = "SELECT * FROM sanpham WHERE masp in ".$x."";
    }
} else {
    $sql = "SELECT * FROM sanpham WHERE masp = '".$masp."'";
}

$conn = connect();
mysqli_set_charset($conn, 'utf8');
$result = mysqli_query($conn, $sql);
?>

<script type="text/javascript">
function tinh_tien() {
    var costs = document.getElementsByClassName('cost');
    var inputs = document.getElementsByName('sl[]');
    var total = 0;

    for (var i = 0; i < costs.length; i++) {
        var price = parseFloat(costs[i].getAttribute('data-val'));
        var quantity = parseInt(inputs[i].value);
        
        if (!isNaN(quantity) && quantity > 0) {
            total += price * quantity;
        }
    }

    // Hiển thị tổng tiền với định dạng phân cách hàng nghìn
    document.getElementById('tong_tien').innerHTML = total.toLocaleString('vi-VN');
}

// Chạy tính tiền ngay khi trang vừa load xong
window.onload = function() {
    tinh_tien();
}
</script>

<div class="container-fluid form" style="margin-top: -23px; padding: 20px">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <form action="giaodich.php" method="POST" role="form">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ẢNH</th><th>TÊN SẢN PHẨM</th><th>ĐƠN GIÁ</th><th>SỐ LƯỢNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><img src="<?php echo $row['anhchinh'] ?>" style="width: 70px"></td>
                            <td><?php echo $row['tensp'] ?></td>
                            <td class="cost" data-val="<?php echo $row['gia'] ?>">
                                <?php echo number_format($row['gia']); $_SESSION['cost'][] = $row['gia']; ?>
                            </td>
                            <td width="100px">
                                <input type="number" name="sl[]" class="form-control" value='1' min="1" onchange="tinh_tien()">
                            </td>
                        </tr>
                        <?php } ?>
                        <tr style="color: green; font-size: 18px; font-weight: bold;">
                            <th colspan="2">Tổng cộng:</th>
                            <th id="tong_tien">0</th>
                            <th>VND</th>
                        </tr>
                    </tbody>
                </table>
                
                <legend>Thông tin giao hàng</legend>
                <p class="errorMes" style="color: #666;">Giao hàng tận nhà (Khu vực Hà Nội)</p>
                
                <div class="form-group">
                    <label for="">Tên người nhận: </label>
                    <input type="text" class="form-control" id="s_ten" name="ten" required value="<?php echo ($_SESSION['rights'] == 'user') ? $_SESSION['user']['ten'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="">Quận, huyện: </label>
                    <select class="form-control" name="quan" id="s_quan">
                        <option value="ntl">Nam Từ Liêm</option>
                        <option value="btl">Bắc Từ Liêm</option>
                        <option value="dh">Hà Đông</option>
                        <option value="tx">Thanh Xuân</option>
                        <option value="dd">Đống Đa</option>
                        <option value="cg">Cầu Giấy</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="">Địa chỉ chi tiết: </label>
                    <input type="text" class="form-control" name="dc" id="s_dc" required value="<?php echo ($_SESSION['rights'] == 'user') ? $_SESSION['user']['diachi'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="">Số điện thoại: </label>
                    <input type="text" class="form-control" name="sodt" id="s_sdt" required value="<?php echo ($_SESSION['rights'] == 'user') ? $_SESSION['user']['sodt'] : ''; ?>">
                </div>
                
                <button type="submit" class="btn btn-primary btn-block" style="font-size: 20px; padding: 10px;">Xác nhận Đặt Hàng</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'layout/second_footer.php' ?>