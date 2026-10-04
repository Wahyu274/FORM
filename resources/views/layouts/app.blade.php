<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'STARLINK — Inventaris Jaringan Partner Kalimantan')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Leaflet CSS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --starkink-navy: #0F172A;
            --starkink-blue: #1E40AF;
            --starkink-light-blue: #2563EB;
            --starkink-sky: #0284C7;
            --starkink-bg: #F8FAFC;
            --starkink-card: #FFFFFF;
            --starkink-border: #E2E8F0;
            --starkink-border-focus: #3B82F6;
            --starkink-text: #0F172A;
            --starkink-muted: #64748B;
        }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--starkink-bg);
            color: var(--starkink-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .bg-starkink-navy {
            background-color: var(--starkink-navy) !important;
        }

        .bg-starkink-blue {
            background-color: var(--starkink-blue) !important;
        }

        .text-starkink-blue {
            color: var(--starkink-blue) !important;
        }

        .text-starkink-sky {
            color: #38BDF8 !important;
        }

        .btn-starkink-primary {
            background: linear-gradient(135deg, #1E40AF 0%, #2563EB 100%);
            color: #FFFFFF;
            border: none;
            font-weight: 600;
            padding: 0.65rem 1.4rem;
            border-radius: 0.6rem;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-starkink-primary:hover {
            background: linear-gradient(135deg, #1E3A8A 0%, #1D4ED8 100%);
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(30, 64, 175, 0.3);
        }

        .card-starkink {
            background: #FFFFFF;
            border: 1px solid var(--starkink-border);
            border-radius: 0.875rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px -2px rgba(15, 23, 42, 0.05);
            transition: box-shadow 0.2s ease;
        }

        .card-starkink:hover {
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
        }

        .form-control, .form-select {
            border-radius: 0.55rem;
            border: 1px solid #CBD5E1;
            padding: 0.62rem 0.85rem;
            font-size: 0.92rem;
            color: #1E293B;
            background-color: #FFFFFF;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--starkink-light-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.85rem;
            margin-bottom: 0.35rem;
            letter-spacing: -0.1px;
        }

        .required-star {
            color: #EF4444;
            font-weight: bold;
        }

        /* Progress Steps */
        .step-progress-bar {
            height: 6px;
            background-color: #E2E8F0;
            border-radius: 3px;
            overflow: hidden;
        }

        .step-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1E40AF 0%, #2563EB 50%, #38BDF8 100%);
            transition: width 0.3s ease;
        }

        /* Custom Scrollbar for Dynamic Tables */
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        .table-responsive::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 3px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 3px;
        }
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        /* Photo Upload Box */
        .photo-preview-box {
            width: 100%;
            height: 130px;
            border: 2px dashed #CBD5E1;
            border-radius: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            cursor: pointer;
            background-color: #F8FAFC;
            transition: all 0.2s ease;
            overflow: hidden;
            position: relative;
            padding: 0.5rem;
        }

        .photo-preview-box:hover {
            border-color: var(--starkink-light-blue);
            background-color: #EFF6FF;
        }

        .photo-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        @media (max-width: 575.98px) {
            .photo-preview-box {
                height: 115px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('content')

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @yield('scripts')
</body>
</html>
