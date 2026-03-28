<?php 
$conn;
function connect(){
    $conn = mysqli_connect('localhost','root','','qlbh') or die('Không thể kết nối!');
    return $conn;
}
function disconnect($conn){
    mysqli_close($conn);
}

// Danh sach thanh vien
function member_list(){
    $conn = connect();
    mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM thanhvien ORDER BY date DESC";
    $result = mysqli_query($conn, $sql); ?>

    <thead>
        <tr>
            <th>ID</th> <th>Tên</th> <th>Tên tài khoản</th>
            <th>Mật khẩu</th> <th>Địa chỉ</th> <th>Số ĐT</th>
            <th>Email</th> <th>Ngày tham gia</th> <th>Quyền</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)){?>
        <tr>
            <td><?php echo $row['id'] ?></td> <td><?php echo $row['ten'] ?></td>
            <td><?php echo $row['tentaikhoan'] ?></td> <td>*****</td>
            <td><?php echo $row['diachi'] ?></td> <td><?php echo $row['sodt'] ?></td>
            <td><?php echo $row['email'] ?></td> <td><?php echo $row['date'] ?></td>
            <td><?php if($row['quyen'])echo "Admin"; else echo "User";  ?></td>
            <td><span class="btn btn-danger" onclick="xoa_taikhoan('<?php echo $row["id"] ?>')">Xóa</span></td>
        </tr>
        <?php } ?>
    </tbody>
    <?php
    disconnect($conn);
}

// Danh sach giao dich (Đơn hàng)
function exchange_list(){
    $conn = connect();
    mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM giaodich WHERE tinhtrang = 0 LIMIT ".$_SESSION['limit']."";
    $i = 1;
    $result = mysqli_query($conn, $sql); ?>

    <thead>
        <tr>
            <th>STT</th> <th>Tình trạng</th> <th>Tên khách hàng</th>
            <th>Quận</th> <th>Địa chỉ</th> <th>Số ĐT</th>
            <th>Tổng tiền</th> <th>Ngày đặt</th> <th>Thao tác</th>
        </tr>
    </thead>
    <tbody id="body-gd-list">
        <?php while ($row = mysqli_fetch_assoc($result)){?>
        <tr>
            <td><?php echo $i++ ?></td>
            <td><?php if($row['tinhtrang']) echo "<h4 class='label label-success'>Đã giao</h4>"; else echo "<h4 class='label label-danger'>Chưa giao</h4>";  ?></td>
            <td><?php echo $row['ten'] ?></td> <td><?php echo $row['quan'] ?></td>
            <td><?php echo $row['diachi'] ?></td> <td><?php echo $row['sodt'] ?></td>
            <td><?php echo number_format($row['tongtien']) ?> đ</td> <td><?php echo $row['ngaygd'] ?></td>
            <td>
                <?php if($row['tinhtrang'] == '0'){ ?>
                <span class="btn btn-success" onclick="xong('<?php echo $row['magd'] ?>')">Xong</span>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        <div class="container-fluid text-center lmbtnctn">
            <button onclick="load_more_gd(0, 'body-gd-list','chuagd')" id="loadmorebtngd">Tải thêm</button>
        </div>
    </tbody>
    <?php
    disconnect($conn);
}

// Danh sach danh muc san pham
function type_list(){
    $conn = connect();
    mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM danhmucsp";
    $result = mysqli_query($conn, $sql); ?>

    <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)){?>
        <tr>
            <td><?php echo $row['madm'] ?></td> 
            <td><?php echo $row['tendm'] ?></td>
            <td>
                <span class="btn btn-danger" onclick="xoa_dm('<?php echo $row['madm'] ?>')">Xóa</span>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    <?php
    disconnect($conn);
}


function product_list(){
    $conn = connect();
    mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM sanpham s LEFT JOIN danhmucsp d ON s.madm = d.madm ORDER BY ngay_nhap DESC LIMIT ".$_SESSION['limit']."";
    $i = 1;
    $result = mysqli_query($conn, $sql); ?>
    
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên món ăn</th> 
            <th>Giá (VNĐ)</th> 
            <th>Hạn sử dụng</th>
            <th>Khối lượng</th> 
            <th>Thành phần</th> 
            <th>Khuyến Mãi</th> 
            <th>Tình trạng</th> 
            <th>Danh mục</th>
            <th>Ảnh</th> 
            <th>Ngày nhập</th> 
            <th>Sửa</th> 
            <th>Xóa</th>
        </tr>
    </thead>
    <tbody id='body-sp-list'>
        <?php while ($row = mysqli_fetch_assoc($result)){?>
        <tr>
            <td><?php echo $i++ ?></td> 
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
        <?php } ?>
    </tbody>
    
    <?php
    disconnect($conn);
}

// In ra cac loai sp cho the select
function list_type_pr_for_add(){
    $conn = connect();
    mysqli_set_charset($conn, 'utf8');
    $sql = "SELECT * FROM danhmucsp";
    ?>  <select class="form-control" id="madm"> <?php
    $result = mysqli_query($conn, $sql); ?>
    <?php while ($row = mysqli_fetch_assoc($result)){?>
    <option value="<?php echo $row['madm'] ?>"><?php echo $row['tendm'] ?></option>
    <?php } ?>
    </select>
<?php
}
?>