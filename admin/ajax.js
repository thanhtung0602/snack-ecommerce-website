// HÀM THÊM SẢN PHẨM (Đã dọn dẹp sạch sẽ rác đồng hồ)
function them_sp(){
    var q = 'them_sp',
    tensp = $('#tensp').val(),
    gia = $('#gia').val(),
    baohanh = $('#baohanh').val(), // Ô này HTML đang hiểu là Hạn sử dụng
    trongluong = $('#trongluong').val(),
    chatlieu = $('#chatlieu').val(), // Ô này HTML đang hiểu là Thành phần
    khuyenmai = $('#khuyenmai').val(),
    madm = $('#madm').val(),
    anhchinh = $('#anhchinh').val();

    if(tensp == "" || gia == ""){
        alert("Tên món ăn và giá không được để trống!");
        return 0;
    }
    $.ajax({
        url : "for-ajax.php",
        type : "post",
        dataType:"text",
        data : {
            q: q, 
            tensp: tensp, 
            gia: gia, 
            baohanh: baohanh, 
            trongluong: trongluong, 
            chatlieu: chatlieu, 
            khuyenmai: khuyenmai, 
            madm: madm, 
            anhchinh: anhchinh
        },
        success : function (result){
            $("#sp_error").html(result);
            window.location.reload(); // Tải lại trang sau khi thêm
        }
    });
}

function xoa_sp(masp_xoa){
    var q = 'xoa_sp';
    if(confirm("Bạn có chắc chắn muốn xóa món này không?")){
        $.ajax({
            url : "for-ajax.php",
            type : "post",
            dataType:"text",
            data : {
                q , masp_xoa
            },
            success : function (result){
                $('#sp_error').html(result);
                window.location.reload();
            }
        });
    }
}

function them_dm(){
    var q = 'them_dm';
    var tendm = $('#tendm').val();
    var xuatsu = $('#xuatsu').val() || 'Việt Nam'; // Mặc định là VN nếu ko có ô nhập
    if(tendm == ""){
        alert('Tên danh mục không được để trống!');
        return 0;
    }
    $.ajax({
        url : "for-ajax.php",
        type : "post",
        dataType:"text",
        data : {
            q, tendm, xuatsu
        },
        success : function (result){
            $('#sp_error').html(result);
            window.location.reload();
        }
    });
}

function xoa_dm(madm_xoa){
    var q = 'xoa_dm';
    if(confirm("Xóa danh mục này?")){
        $.ajax({
            url : "for-ajax.php",
            type : "post",
            dataType:"text",
            data : {
                q , madm_xoa
            },
            success : function (result){
                $('#sp_error').html(result);
                window.location.reload();
            }
        });
    }
}

// Sắp xếp các giao dịch
function list_chuagh(){
    var q = 'giaodich_chuagh';
    $('#loadmorebtngd').attr('onclick','load_more_gd(0,`gd_chuagd_body`,`chuagd`)');
    $('#loai_gd').text("chưa giao hàng");
    $.ajax({
        url : "for-ajax.php",
        type : "post",
        dataType:"text",
        data : { q },
        success : function (result){
            $('#tbl-giaodich-list').html(result);
        }
    });
}

function list_dagh(){
    var q = 'giaodich_dagh';
    $('#loadmorebtngd').attr('onclick','load_more_gd(0,`gd_dagd_body`,`dagd`)');
    $('#loai_gd').text("đã giao hàng");
    $.ajax({
        url : "for-ajax.php",
        type : "post",
        dataType:"text",
        data : { q },
        success : function (result){
            $('#tbl-giaodich-list').html(result);
        }
    });
}

function list_tatcagh(){
    var q = 'giaodich_tatcagh';
    $('#loadmorebtngd').attr('onclick','load_more_gd(0,`gd_tatcagd_body`,`tatcagd`)');
    $('#loai_gd').text("tất cả");
    $.ajax({
        url : "for-ajax.php",
        type : "post",
        dataType:"text",
        data : { q },
        success : function (result){
            $('#tbl-giaodich-list').html(result);
        }
    });
}

// Giao dịch đã xong
function xong(magd_xong){
    var q = 'giaodich_xong';
    if(confirm("Xác nhận đã giao đơn hàng này?")){
        $.ajax({
            url : "for-ajax.php",
            type : "post",
            dataType:"text",
            data : {
                q, magd_xong
            },
            success: function(result){
                window.location.reload(); 
            }
        });
    }
}

function them_admin(){
    var q = 'them_admin';
    var ten = $('#admin-name').val();
    var tentk = $('#admin-username').val();
    var mk = $('#admin-password').val();
    $.ajax({
        url : "for-ajax.php",
        type : "post",
        dataType:"text",
        data : {
            q, ten, tentk, mk
        },
        success : function (result){
            $('#tbl-thanhvien-list').html(result);
            location.reload();
        }
    });
}

function xoa_taikhoan(id_tk_xoa){
    var q = 'xoa_taikhoan';
    if(confirm("Xóa tài khoản này?")){
        $.ajax({
            url : "for-ajax.php",
            type : "post",
            dataType:"text",
            data : {
                q, id_tk_xoa
            },
            success : function (result){
                $('#tbl-thanhvien-list').html(result);
                location.reload();
            }
        });
    }
}

function display_edit_sanpham(masp_sua_sp){
    $('#sua_sp-area').show(300);
    $('#edit_sp_btn').attr("onclick","sua_sp('"+masp_sua_sp+"')");
   
    $('html, body').animate({ scrollTop: $("#sua_sp-area").offset().top - 50 }, 500);
}

function sua_sp(masp_sua){
    var q = 'sua_sp';
    var tensp_ed = $('#tensp-edit').val();
    var gia_ed = $('#gia-edit').val();
    var baohanh_ed = $('#baohanh-edit').val(); // Hạn sử dụng
    var khuyenmai_ed = $('#khuyenmai-edit').val();
    


    if(tensp_ed == "" && gia_ed == "" && baohanh_ed == "" && khuyenmai_ed == ""){
        alert("Bạn phải nhập thông tin mới để sửa!");
        return 0;
    }
    $.ajax({
        url : "for-ajax.php",
        type : "post",
        dataType:"text",
        data : {
            q: q, 
            masp_sua: masp_sua, 
            tensp_ed: tensp_ed, 
            gia_ed: gia_ed, 
            baohanh_ed: baohanh_ed, 
            khuyenmai_ed: khuyenmai_ed
        },
        success : function (result){
            $('#big-error').html(result);
            location.reload(); 
        }
    });
}