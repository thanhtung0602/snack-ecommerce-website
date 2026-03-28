<div class='product-container' onclick="hien_sanpham('<?php echo $row['masp']?>')">
    <a data-toggle='modal' href='sanpham.php?masp=<?php echo $row['masp'] ?>' data-target='#modal-id'>
        <img src='<?php echo $row['anhchinh'] ?>' class='product-img'>
        
        <div class='product-detail'>
            <p>✔ Đảm bảo vệ sinh <br>
               ✔ Giao hàng nhanh <br>
            </p>
            <span>Ưu đãi</span>
            <p>✔ Giảm ngay <?php echo $row['khuyenmai'] ?>% khi mua combo<br>
            </p>
        </div>

        <div class='product-info'>
            <h4><b><?php echo $row['tensp'] ?></b></h4>
            <i style="color: #888;">Món ăn vặt hot nhất tuần</i><br>
            <b class='price'>Giá: <?php echo number_format($row['gia']) ?> VND</b>
        </div>

        <div class='buy'>
            <a class='btn btn-default btn-lg unlike-container'><i class='glyphicon glyphicon-heart unlike'></i></a>
            
            <a class='btn btn-primary btn-lg cart-container <?php 
            if($_SESSION['rights'] == "default"){
                if(in_array($row['masp'],$_SESSION['client_cart'])){ echo 'cart-ordered'; } 
            } else {
                if(in_array($row['masp'],$_SESSION['user_cart'])){ echo 'cart-ordered'; }
            } ?>' onclick="addtocart_action('<?php echo $row['masp'] ?>')">
            <i title='Thêm vào giỏ hàng' class='glyphicon glyphicon-shopping-cart cart-item'></i></a>
            
            <a class='btn btn-success btn-lg' href='order.php?masp=<?php echo $row['masp'] ?>'>Mua ngay</a>
        </div>
    </a>
</div>