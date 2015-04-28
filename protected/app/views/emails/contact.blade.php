<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Xin chào Admin  ! </h2>
		<p> Bạn có 1 thông tin liên hệ mới từ khách hàng </p>
		<p>
			Email : {{ $email }} <br />
			Tên : {{ $name }}<br />
			Website : {{ $website }}<br />
		</p>
		<p> Nội dung : </p>
		<div>
			{{ $comment }}
		</div>
		
		<p> Thank You </p><br /><br />
		
		{{ CNF_APPNAME }} 
	</body>
</html>