<?php 
$conn;
function connect(){
    $conn = mysqli_connect('localhost','root','','qlbh') or die('Không thể kết nối!');
    return $conn;
}
function disconnect($conn){
    mysqli_close($conn);
}
function validate_input_sql($conn, $str){
    return mysqli_real_escape_string($conn, $str);
}
$q = ""; if(isset($_POST['q'])){ $q = $_POST['q']; }
$fname = ""; if(isset($_GET['fname'])){ $fname = $_GET['fname']; }

if($fname == "load_more"){ load_more(); }
if($fname == "load_more_gd"){ load_more_gd(); }

switch ($q) {
    case 'them_sp': them_sp(); break;
    case 'xoa_sp': xoa_sp(); break;
    case 'them_dm': them_dm(); break;
    case 'xoa_dm': xoa_dm(); break;
    case 'giaodich_chuagh': giaodich_chuagh(); break;
    case 'giaodich_dagh': giaodich_dagh(); break;
    case 'giaodich_tatcagh': giaodich_tatcagh(); break;
    case 'giaodich_xong': giaodich_xong(); break;
    case 'them_admin': them_admin(); break;
    case 'xoa_taikhoan': xoa_taikhoan(); break;
    case 'sua_sp': sua_sp(); break;
}

// HÀM LOAD THÊM SẢN PHẨM (CHUẨN ĐỒ ĂN)
function load_more(){
    session_start();
    $cr = '';
    if(isset($_GET['current'])){$cr = $_GET['current'];}
    $st = ($cr+1)*$_SESSION['limit']; // Vị trí bắt đầu lấy sản phẩm tiếp theo

    $conn = connect();
    mysqli_set_charset($conn, 'utf8');
    
    // Dùng LEFT JOIN y hệt như hàm product_list() để không bỏ sót sản phẩm nào
    $sql = "SELECT * FROM sanpham s LEFT JOIN danhmucsp d ON s.madm = d.madm ORDER BY s.ngay_nhap DESC LIMIT ".$st.",".$_SESSION['limit'];
    $result = mysqli_query($conn, $sql);

    // Nếu không còn sản phẩm nào trong Database thì báo "từ khóa" để file JS tự ẩn nút Load More đi
    if(mysqli_num_rows($result) == 0){
        echo "hetcmnrdungbamnua";
        disconnect($conn);
        return;
    }

    $i = $st;
    while ($row = mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><?php echo ++$i ?></td> 
            <td><?php echo isset($row['tensp']) ? $row['tensp'] : '' ?></td>
            <td><?php echo isset($row['gia']) ? number_format($row['gia']) : '0' ?></td> 
            <td><?php echo isset($row['hansudung']) ? $row['hansudung'] : (isset($row['baohanh']) ? $row['baohanh'] : '') ?></td>
            <td><?php echo isset($row['trongluong']) ? $row['trongluong'] : '' ?></td> 
            <td><?php echo isset($row['thanhphan']) ? $row['thanhphan'] : (isset($row['chatlieu']) ? $row['chatlieu'] : '') ?></td>
            <td><?php echo isset($row['khuyenmai']) ? $row['khuyenmai'] : '0' ?>%</td>
            <td><?php echo isset($row['tinhtrang']) ? $row['tinhtrang'] : '' ?></td> 
            <td><?php echo isset($row['tendm']) ? $row['tendm'] : '' ?></td>
            <td><img src="../<?php echo isset($row['anhchinh']) ? $row['anhchinh'] : '' ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
            <td><?php echo isset($row['ngay_nhap']) ? date('d-m-Y', strtotime($row['ngay_nhap'])) : '' ?></td>
            <td><span onclick="display_edit_sanpham('<?php echo isset($row['masp']) ? $row['masp'] : '' ?>')"><a class="btn btn-warning" href="#sua_sp-area">Sửa</a></span></td>
            <td><span class="btn btn-danger" onclick="xoa_sp('<?php echo isset($row['masp']) ? $row['masp'] : '' ?>')">Xóa</span></td>
        </tr>
        <?php
    }
    disconnect($conn);
}

// HÀM THÊM MÓN ĂN MỚI
function them_sp(){
    $conn = connect();
    $tensp = isset($_POST['tensp']) ? validate_input_sql($conn, $_POST['tensp']) : '';
    $gia = isset($_POST['gia']) ? (int)validate_input_sql($conn, $_POST['gia']) : 0;
    $hansudung = isset($_POST['baohanh']) ? validate_input_sql($conn, $_POST['baohanh']) : ''; 
    $trongluong = isset($_POST['trongluong']) ? validate_input_sql($conn, $_POST['trongluong']) : '';
    $thanhphan = isset($_POST['chatlieu']) ? validate_input_sql($conn, $_POST['chatlieu']) : ''; 
    $khuyenmai = isset($_POST['khuyenmai']) ? (int)validate_input_sql($conn, $_POST['khuyenmai']) : 0;
    
    // Nếu không có madm thì mặc định là 1
    $madm = (isset($_POST['madm']) && $_POST['madm'] != '') ? (int)validate_input_sql($conn, $_POST['madm']) : 1; 
    $anhchinh = isset($_POST['anhchinh']) ? validate_input_sql($conn, $_POST['anhchinh']) : '';
    
    // Dữ liệu tạo tự động cho khớp Database
    $xuatsu = "Việt Nam"; 
    $ngaysanxuat = date('Y-m-d');
    $now = date('Y-m-d H:i:s');
    $luotmua = rand(20, 100); 

    mysqli_set_charset($conn,'utf8');
    
    if($tensp == "" || $gia == 0){
        echo "Tên và giá không được để trống!";
        return 0;   
    }
    
   
    $sql = "INSERT INTO sanpham (madm, tensp, gia, khuyenmai, xuatsu, ngaysanxuat, hansudung, anhchinh, luotmua, ngay_nhap, trongluong, thanhphan) 
            VALUES ('$madm', '$tensp', '$gia', '$khuyenmai', '$xuatsu', '$ngaysanxuat', '$hansudung', '$anhchinh', '$luotmua', '$now', '$trongluong', '$thanhphan')";
            
    if(!mysqli_query($conn, $sql)){
        echo "LỖI DATABASE: " . mysqli_error($conn);
    } else {
        echo "THANH_CONG";
    }
    disconnect($conn);
}

// HÀM SỬA MÓN ĂN
function sua_sp(){
    $masp = $_POST['masp_sua'];
    $tensp = $_POST['tensp_ed'];
    $gia = $_POST['gia_ed'];
    $hansudung = $_POST['baohanh_ed']; 
    $khuyenmai = $_POST['khuyenmai_ed'];
    
    $set = []; $data = [];
    if($tensp != ""){$data[] = $tensp; $set[] = 'tensp';}
    if($gia != ""){$data[] = $gia; $set[] = 'gia';}
    if($hansudung != ""){$data[] = $hansudung; $set[] = 'hansudung';}
    if($khuyenmai != ""){$data[] = $khuyenmai; $set[] = 'khuyenmai';}
    
    $str = '';
    for ($i=0; $i < count($set); $i++) { 
        $str.= $set[$i]."='".$data[$i]."',";
    }
    $str = trim($str, ',');
    $conn = connect();
    $sql = "UPDATE sanpham SET ".$str." WHERE masp = '".$masp."'";
    
    if(!mysqli_query($conn, $sql)){
        echo "<script>alert('Lỗi cập nhật!')</script>";
    } else {
        echo "<script>alert('Cập nhật món ăn thành công!')</script>";
    }
    disconnect($conn);
}

function xoa_sp(){
    $masp = $_POST['masp_xoa']; $conn = connect();
    $sql = "DELETE FROM sanpham WHERE masp = '".$masp."'";
    if(mysqli_query($conn, $sql)){ echo "<script>alert('Xóa thành công!')</script>"; } 
    else { echo "<script>alert('Đã xảy ra lỗi!')</script>"; }
}

function them_dm(){
    $tendm = $_POST['tendm']; $xuatsu = $_POST['xuatsu']; $conn = connect();
    $sql = "INSERT INTO danhmucsp VALUES (NULL,'".$tendm."','".$xuatsu."')";
    if(mysqli_query($conn, $sql)){ echo "<script>alert('Thêm danh mục thành công!')</script>"; } 
}

function xoa_dm(){
    $madm = $_POST['madm_xoa']; $conn = connect();
    $sql = "DELETE FROM danhmucsp WHERE madm = '".$madm."'";
    if(mysqli_query($conn, $sql)){ echo "<script>alert('Xóa thành công!')</script>"; } 
    else { echo "<script>alert('Lỗi! Bạn phải xóa hết những sản phẩm thuộc danh mục này trước!')</script>"; }
}

function giaodich_chuagh(){
    session_start(); $conn = connect(); mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM giaodich WHERE tinhtrang = 0 LIMIT ".$_SESSION['limit'];
    $i = 1; $result = mysqli_query($conn, $sql); ?>
    <thead><tr><th>STT</th> <th>Tình trạng</th> <th>Tên khách</th><th>Quận</th> <th>Địa chỉ</th> <th>Số ĐT</th><th>Tổng tiền</th> <th>Ngày đặt</th> <th>Thao tác</th></tr></thead>
    <tbody id="gd_chuagd_body">
        <?php while ($row = mysqli_fetch_assoc($result)){?>
        <tr><td><?php echo $i++ ?></td><td><h4 class='label label-danger'>Chưa giao</h4></td><td><?php echo $row['ten'] ?></td> <td><?php echo $row['quan'] ?></td><td><?php echo $row['diachi'] ?></td> <td><?php echo $row['sodt'] ?></td><td><?php echo number_format($row['tongtien']) ?> đ</td> <td><?php echo $row['ngaygd'] ?></td><td><span class="btn btn-success" onclick="xong('<?php echo $row['magd'] ?>')">Xong</span></td></tr>
        <?php } ?>
    </tbody>
    <?php disconnect($conn);
}

function giaodich_dagh(){
    session_start(); $conn = connect(); mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM giaodich WHERE tinhtrang = 1 LIMIT ".$_SESSION['limit'];
    $i = 1; $result = mysqli_query($conn, $sql); ?>
    <thead><tr><th>STT</th> <th>Tình trạng</th> <th>Tên khách</th><th>Quận</th> <th>Địa chỉ</th> <th>Số ĐT</th><th>Tổng tiền</th> <th>Ngày đặt</th> <th>Thao tác</th></tr></thead>
    <tbody id="gd_dagd_body">
        <?php while ($row = mysqli_fetch_assoc($result)){?>
        <tr><td><?php echo $i++ ?></td><td><h4 class='label label-success'>Đã giao</h4></td><td><?php echo $row['ten'] ?></td> <td><?php echo $row['quan'] ?></td><td><?php echo $row['diachi'] ?></td> <td><?php echo $row['sodt'] ?></td><td><?php echo number_format($row['tongtien']) ?> đ</td> <td><?php echo $row['ngaygd'] ?></td><td></td></tr>
        <?php } ?>
    </tbody>
    <?php disconnect($conn);
}

function giaodich_tatcagh(){
    session_start(); $conn = connect(); mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM giaodich LIMIT ".$_SESSION['limit'];
    $i = 1; $result = mysqli_query($conn, $sql); ?>
    <thead><tr><th>STT</th> <th>Tình trạng</th> <th>Tên khách</th><th>Quận</th> <th>Địa chỉ</th> <th>Số ĐT</th><th>Tổng tiền</th> <th>Ngày đặt</th> <th>Thao tác</th></tr></thead>
    <tbody id="gd_tatcagd_body">
        <?php while ($row = mysqli_fetch_assoc($result)){?>
        <tr><td><?php echo $i++ ?></td><td><?php if($row['tinhtrang']) echo "<h4 class='label label-success'>Đã giao</h4>"; else echo "<h4 class='label label-danger'>Chưa giao</h4>";  ?></td><td><?php echo $row['ten'] ?></td> <td><?php echo $row['quan'] ?></td><td><?php echo $row['diachi'] ?></td> <td><?php echo $row['sodt'] ?></td><td><?php echo number_format($row['tongtien']) ?> đ</td> <td><?php echo $row['ngaygd'] ?></td><td><?php if($row['tinhtrang'] == '0'){ ?><span class="btn btn-success" onclick="xong('<?php echo $row['magd'] ?>')">Xong</span><?php } ?></td></tr>
        <?php } ?>
    </tbody>
    <?php disconnect($conn);
}

function load_more_gd(){
    session_start(); $cr = $stt = '';
    if(isset($_GET['current'])){$cr = $_GET['current'];}
    if(isset($_GET['stt'])){$stt = $_GET['stt'];}
    $st = ($cr+1)*$_SESSION['limit'];
    if($stt == "dagd"){
        if($st > $_SESSION['gd_dagd'] + 1){ echo "hetcmnrdungbamnua"; return; }
        $sql = "SELECT * FROM giaodich WHERE tinhtrang = 1 LIMIT ".$st.",".$_SESSION['limit']."";
    } elseif ($stt == "chuagd") {
        if($st > $_SESSION['gd_chua'] + 1){ echo "hetcmnrdungbamnua"; return; }
        $sql = "SELECT * FROM giaodich WHERE tinhtrang = 0 LIMIT ".$st.",".$_SESSION['limit']."";
    } else {
        if($st > $_SESSION['gd_all'] + 1){ echo "hetcmnrdungbamnua"; return; }
        $sql = "SELECT * FROM giaodich LIMIT ".$st.",".$_SESSION['limit']."";
    }
    $conn = connect(); mysqli_set_charset($conn, 'utf8'); $result = mysqli_query($conn, $sql); $i = $st;
    while ($row = mysqli_fetch_assoc($result)){ ?>
        <tr><td><?php echo ++$i ?></td><td><?php if($row['tinhtrang'] == 0){ echo "<h4 class='label label-danger'>Chưa giao</h4>"; } else { echo "<h4 class='label label-success'>Đã giao</h4>"; } ?></td><td><?php echo $row['ten'] ?></td> <td><?php echo $row['quan'] ?></td><td><?php echo $row['diachi'] ?></td> <td><?php echo $row['sodt'] ?></td><td><?php echo number_format($row['tongtien']) ?> đ</td> <td><?php echo $row['ngaygd'] ?></td><td><?php if($row['tinhtrang'] == '0'){ ?><span class="btn btn-success" onclick="xong('<?php echo $row['magd'] ?>')">Xong</span><?php } ?></td></tr>
    <?php }
}

function giaodich_xong(){
    $magd = $_POST['magd_xong']; $conn = connect(); mysqli_set_charset($conn, 'utf8');
    $sql = "UPDATE giaodich SET tinhtrang = '1' WHERE magd = '".$magd."'";
    mysqli_query($conn, $sql); disconnect($conn);
}

function them_admin(){
    $conn = connect(); $ten = $_POST['ten']; $tentk = $_POST['tentk']; $mk = $_POST['mk'];
    $sql = "INSERT INTO thanhvien VALUES (NULL,'".$ten."','".$tentk."','".$mk."','','','','','1')";
    if(!mysqli_query($conn, $sql)){ echo "<script>alert('Tên tài khoản đã tồn tại!')</script>"; } 
    else { echo "<script>alert('Tạo thành công!')</script>"; }
    disconnect($conn);
}
function xoa_taikhoan(){
    $id = $_POST['id_tk_xoa']; $conn = connect();
    $sql = "DELETE FROM thanhvien WHERE id = '".$id."'";
    mysqli_query($conn, $sql); disconnect($conn);
}
?>