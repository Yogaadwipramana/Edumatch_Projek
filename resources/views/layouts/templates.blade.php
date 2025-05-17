<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Technical Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f9;
        }

        .layout {
            display: flex;
        }

        /* Profile */
        .profile-container .profile-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }


        /* Sidebar */
        .sidebar {
            background-color: #fff;
            width: 250px;
            transition: all 0.3s ease;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .logo {
            padding: 20px;
            font-size: 22px;
            font-weight: bold;
            color: #6366f1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .toggle-btn {
            position: absolute;
            right: -15px;
            top: 20px;
            background: #6366f1;
            border-radius: 50%;
            color: white;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #333;
            cursor: pointer;
            transition: 0.2s;
        }

        .sidebar ul li.active,
        .sidebar ul li:hover {
            background-color: #eef2ff;
            color: #6366f1;
            border-right: 4px solid #6366f1;
        }

        .sidebar.collapsed ul li span {
            display: none;
        }

        .sidebar.collapsed .logo span {
            display: none;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar .search {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #ddd;
            padding: 8px 12px;
            border-radius: 8px;
            flex: 1;
            max-width: 400px;
        }

        .navbar .icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar .profile-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 1000;
                height: 100%;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body>
    <div class="layout">
        @include('layouts.sidebar')

        <div class="content">
            @include('layouts.navbar')

            <div style="margin-top: 20px;">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.querySelector('.toggle-btn');
        const sidebar = document.querySelector('.sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>

</html>
