function add_favo(id){
    var link = link_home + "/home/favora";
	$.post( link,{id : id}, function( data ) {
		if(data == 100){
			$('.popup-with-zoom-anim').click();
			jQuery(".login_notify").show();
			jQuery(".login_notify").html('Vui lòng đăng nhập để sử dụng chức năng này');
		}
		if(data == 101){
			alert('Thao tác không thành công ! vui lòng thử lại');
		}
		if(data == 1){
			alert('Thêm sản phẩm thành công !');
		}
	});
}

function del_favo(id){
    var link = link_home + "/home/delfavora";
	$.post( link,{id : id}, function( data ) {
		if(data == 100){
			$('.popup-with-zoom-anim').click();
			jQuery(".login_notify").show();
			jQuery(".login_notify").html('Vui lòng đăng nhập để sử dụng chức năng này');
		}
		if(data == 101){
			alert('Thao tác không thành công ! vui lòng thử lại');
		}
		if(data == 1){
			$("#li_"+id).remove();
			alert('Xóa sản phẩm thành công !');
		}
	});
}

function add_cart(id){
    var link = link_home + "/home/addcart";
	$.post( link,{id : id,num:'1'}, function( data ) {
		if(data == 101){
			alert('Thao tác không thành công ! vui lòng thử lại');
		}
		if(data == 1){
			alert('Thêm sản phẩm thành công !');
			var num = $('#num-cart').text();
			$('#num-cart').text(parseInt(num)+1);
		}
	});
}

function add_cart_detail(id){
    var link = link_home + "/home/addcart";
    var num = parseInt($("#quantity_pd").val());
	$.post( link,{id : id, num:num}, function( data ) {
		if(data == 101){
			alert('Thao tác không thành công ! vui lòng thử lại');
		}
		if(data == 1){
			window.location.href = link_home + "/gio-hang-cua-toi.html";
		}
	});
}

function del_cart(id){
	var link = link_home + "/home/delcart";
	var price = $("#total_"+id).val();
	$.post( link,{id : id}, function( data ) {
		if(data == 101){
			alert('Thao tác không thành công ! vui lòng thử lại');
		}
		if(data == 1){
			$("#"+id).remove();
			var total = parseInt($("#total").val());
			var result = total - parseInt(price);
			$("#total").val(result);
			$("#total_"+id).val(result);
			$("#show_total1").text(formatNumber(result));
			$("#show_total2").text(formatNumber(result)); 
		}
	});
}

function update_cart(id,price,old_num){
	var link = link_home + "/home/updatecart";
	var num = parseInt($("#sl_"+id).val());

	if(num <= 0){
		alert("Vui lòng nhập giá trị lớn hơn 0");return false;
	}
	$.post( link,{id : id,num : num}, function( data ) {
		if(data == 101){
			alert('Thao tác không thành công ! vui lòng thử lại');
		}
		if(data == 1){
			var total = parseInt($("#total").val());
			var result = total - parseInt(price * parseInt(old_num)) + parseInt(price * num);
			$("#total_pro_"+id).text(formatNumber(parseInt(price * num)));
			$("#total").val(result);
			$("#total_"+id).val(parseInt(price * num));
			$("#show_total1").text(formatNumber(result));
			$("#show_total2").text(formatNumber(result)); 
		}
	});
}

function formatNumber(number)
{
    var number = number.toFixed(2) + '';
    var x = number.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + 'đ';
}

