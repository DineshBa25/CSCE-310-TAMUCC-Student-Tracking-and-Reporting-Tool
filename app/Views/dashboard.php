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
                <!-- Drawer -->
                <div id="user-drawer" class="drawer">
                    <div class="bg-gray-800 h-full">
                        <div class="py-6 px-4 bg-gray-700 text-white">
                            <!-- Get full name -->
                            <h2 class="text-2xl font-bold"><?= $userData['First_Name'] . ' ' . $userData['M_Initial'] . '. ' . $userData['Last_Name']; ?> </h2>
                            <!-- Get email address -->
                            <p class="text-gray-500"><?= $userData['Email']; ?></p>
                        </div>
                        <div class="bg-yellow-300 text-black">
                            <!-- Get full name -->
                            <h2 class="text-2xl text-center font-bold"><?= $userData['User_Type']?> </h2>
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
                <h1 class="text-gray-300 p-5 text-5xl font-bold">Welcome, <?= $userData['First_Name']?></h1>
                <hr class="border ml-6 mr-6 border-gray-600 border-2">
                <?php if ($userData['User_Type'] == 'Administrator'): ?>
                    <!-- Admin Dashboard Buttons -->
                    <div class="space-y-6 p-6">
                        <!-- User Authentication and Roles -->
                        <div>
                            <h2 class="text-lg font-semibold text-white mb-3">User Authentication and Roles</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Add New Admin
                                </button>
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Modify User Roles
                                </button>
                                <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    View User List
                                </button>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Remove User
                                </button>
                            </div>
                        </div>
                        <hr class="border-t border-gray-600"> <!-- Horizontal Divider -->

                        <!-- Program Information Management -->
                        <div>
                            <h2 class="text-lg font-semibold text-white mb-3">Program Information Management</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                                <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Add New Program
                                </button>
                                <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Program Details
                                </button>
                                <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                                    Generate Program Report
                                </button>
                                <button class="bg-red-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                    Delete Program
                                </button>
                            </div>
                        </div>
                        <hr class="border-t border-gray-600"> <!-- Horizontal Divider -->

                        <!-- Program Progress Tracking -->
                        <div>
                            <h2 class="text-lg font-semibold text-white mb-3">Program Progress Tracking</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                                <button class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded">
                                    Record Student Progress
                                </button>
                                <button class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Student Progress
                                </button>
                                <button class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded">
                                    View Student Progress
                                </button>
                                <button class="bg-red-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Delete Progress Report
                                </button>
                            </div>
                        </div>
                        <hr class="border-t border-gray-600"> <!-- Horizontal Divider -->

                        <!-- Event Management -->
                        <div>
                            <h2 class="text-lg font-semibold text-white mb-3">Event Management</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                                <button class="bg-rose-500 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded">
                                    Create New Event
                                </button>
                                <button class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Event Details
                                </button>
                                <button class="bg-violet-500 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded">
                                    View Event Info
                                </button>
                                <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                    Delete Event
                                </button>
                            </div>
                        </div>
                        <!-- No divider after the last section -->
                    </div>
                <?php endif; ?>
            </div>
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
