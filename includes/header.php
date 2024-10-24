<?php
// header.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Admin Dashboard"; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Đặt chiều cao trang bằng 100% màn hình */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        /* Flexbox để toàn bộ trang bao phủ toàn bộ màn hình */
        .container-fluid {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Sidebar và nội dung chính */
        .row.content {
            flex: 1;
            /* Chiếm toàn bộ chiều cao trống còn lại */
            display: flex;
        }

        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
            padding-top: 20px;
        }

        .main-content {
            padding: 20px;
            background-color: #fff;
            width: 100%;
            height: 100%;
        }

        @media screen and (max-width: 767px) {
            .row.content {
                flex-direction: column;
                height: auto;
            }

            .sidenav {
                height: auto;
            }
        }
    </style>
</head>

<body>