<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>
<?php
require_once 'backend-index.php';
$masp = "";
if(isset($_GET['masp'])){
    $masp = $_GET['masp'];
}
$conn = connect();
mysqli_set_charset($conn, 'utf8');
$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND masp = '".$masp."'";
$result = mysqli_query($conn, $sql);
$loaisp = "";
while ($row = mysqli_fetch_assoc($result)) {
    $loaisp = $row['madm'];
    ?>
    <div class="container-fluid form" style="margin-top: -23px; padding: 20px">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-prd">
                    <img src="<?php echo $row['anhchinh'] ?>" class="main-prd-img">
                    <div class="basic-info">
                        <h2><?php echo $row['tensp'] ?></h2>
                        <span class="main-prd-price"><?php echo $row['gia'] ?> VND</span>
                        
                        <h4><b>Thông tin cơ bản</b></h4>
                        <ul>
                            <li>Nơi sản xuất: <?php echo $row['xuatsu'] ?></li>
                            <li>Ngày sản xuất: <?php if($row['ngaysanxuat'] != "") echo date('d/m/Y', strtotime($row['ngaysanxuat'])); else echo "Đang cập nhật"; ?></li>
                            <li>Hạn sử dụng: <?php echo $row['hansudung'] ?></li>
                            <li><span class="km">Khuyến mãi: <?php echo $row['khuyenmai'] ?> %</span></li>
                            <br><a class="btn btn-primary" href="order.php?masp=<?php echo $masp ?>">Mua ngay</a>
                        </ul>
                    </div>
                </div>

                <div style="clear: both;"></div>

            </div>
            <?php } ?>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>