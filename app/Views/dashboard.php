<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Add custom styles for the drawer */
        .drawer {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 300px;
            background-color: #1f2023;
            box-shadow: -2px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .drawer.active {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

<nav class="bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo section -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="#"><img class="h-10 w-2000" src="<?= base_url('/images/tamu-cyber-long-logo.png'); ?>" alt="User Avatar"></a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                    <a href="#" class="border-indigo-500 text-white-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Dashboard
                    </a>
                    <!-- Add other navigation links here -->
                </div>
            </div>
            <!-- Profile dropdown -->
            <div class="ml-3 relative flex items-center">
                <div>
                    <!-- Account Button (Toggle Drawer) -->
                    <button type="button" class="max-w-xs bg-gray-800 rounded-full flex items-center justify-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <!-- User avatar -->
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full" src="<?= base_url('/images/account-icon.png'); ?>" alt="">
                    </button>
                </div>
                <!-- Dropdown menu (Drawer) -->
                <div id="user-drawer" class="drawer">
                    <div class="bg-gray-800 h-full">
                        <div class="py-6 px-4 bg-gray-700 text-white">
                            <!-- Get full name -->
                            <h2 class="text-2xl font-bold"><?= $userData['First_Name'] . ' ' . $userData['M_Initial'] . '. ' . $userData['Last_Name']; ?> </h2>
                            <!-- Get email address -->
                            <p class="text-gray-500"><?= $userData['Email']; ?></p>
                        </div>
                        <div class="py-4 px-4">
                            <a href="<?= site_url('logout'); ?>" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 focus:outline-none focus:bg-red-100 transition duration-150 ease-in-out">
                                Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-700 rounded-lg h-96 flex justify-center items-center">
                <span class="text-gray-500">Welcome to the Dashboard</span>
            </div>
        </div>
        <!-- /End replace -->
    </div>
</main>

<script>
    // JavaScript to toggle the drawer
    const userMenuButton = document.getElementById('user-menu-button');
    const userDrawer = document.getElementById('user-drawer');

    userMenuButton.addEventListener('click', () => {
        userDrawer.classList.toggle('active');
    });

    // Close the drawer when clicking outside of it
    document.addEventListener('click', (e) => {
        if (userDrawer.classList.contains('active') && !userDrawer.contains(e.target) && !userMenuButton.contains(e.target)) {
            userDrawer.classList.remove('active');
        }
    });
</script>

</body
