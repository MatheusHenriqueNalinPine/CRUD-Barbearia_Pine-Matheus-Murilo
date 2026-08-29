<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barbearia Pine')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background:
                linear-gradient(135deg, #0d0d0d 0%);
            color: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            background: rgba(20, 20, 20, 0.9);
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }



        .bg-dark {
            background-color: #101010 !important;
        }

        .text-info {
            color: #b1b0ad !important;
        }

        .text-secondary {
            color: #d9d9d9 !important;
        }

        .form-label,
        .text-danger {
            color: #f0d78c !important;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #c89b2e, #d9b654);
            border: none;
            color: #111;
            font-weight: 700;
            letter-spacing: 1px;
            border-radius: 3px;
            padding: 12px 14px;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #d7a634, #efc763);
            color: #111;
        }

        .btn:focus,
        .btn:active:focus,
        .form-control:focus,
        a:focus {
            outline: none;
            box-shadow: none !important;
        }

        .form-control {
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: rgba(14,14,14,0.9) !important;
            color: #f5f5f5 !important;
            border-radius: 3px;
            padding: 12px 14px;
        }

        .form-control:focus {
            background-color: #111 !important;
            box-shadow: none;
            color: #f5f5f5 !important;
        }

        .input-group-text {
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-right: none;
            background: rgba(12,12,12,0.8) !important;
            color: #d9d9d9 !important;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.12);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #f8d7da;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>