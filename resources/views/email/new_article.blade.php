<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký nhận tin</title>
</head>
<body>
    <h1>@if($confirmLink) Cảm ơn bạn đã đăng ký nhận tin từ chúng tôi! @else Bạn đã đăng ký nhận tin rồi! @endif</h1>

    @if($confirmLink)
        <p>Chúng tôi rất vui mừng khi bạn quyết định nhận tin tức từ chúng tôi. Để xác nhận đăng ký, vui lòng nhấn vào liên kết dưới đây:</p>
        <p><a href="{{ $confirmLink }}">Xác nhận đăng ký</a></p>
    @endif

    <p>Nếu bạn không muốn nhận tin nữa, bạn có thể hủy đăng ký bất cứ lúc nào bằng cách nhấn vào liên kết dưới đây:</p>
    <p><a href="{{ $unsubscribeLink }}">Hủy đăng ký nhận tin</a></p>

    <p>Trân trọng,</p>
</body>
</html>
