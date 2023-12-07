<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-500 text-white text-center py-2 px-4 rounded">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white text-center py-2 px-4 rounded">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php elseif (session()->getFlashdata('warning')): ?>
        <div class="bg-yellow-500 text-white text-center py-2 px-4 rounded">
            <?= session()->getFlashdata('warning') ?>
        </div>
    <?php endif; ?>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-gray-300 p-5 text-5xl font-bold">Report Generation</h1>
            <hr class="border ml-6 mr-6 border-gray-600 border-2">
                <!-- Admin Dashboard Buttons -->
                <div class="space-y-6 p-6">
                    <!-- User Authentication and Roles -->
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-3">User Authentication and Roles</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                            <a href="<?= site_url('/add_user'); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Add New Administrator
                            </a>
                            <a href="<?= site_url('/view_users'); ?>" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                View, edit and delete Students or Administrators
                            </a>
                        </div>
                    </div>
                    <hr class="border-t border-gray-600"> <!-- Horizontal Divider -->

                    <!-- Program Information Management -->
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-3">Program Information Management</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                            <a href="<?= site_url('/add_program'); ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Add a program
                            </a>
                            <a href="<?= site_url('/view_program'); ?>" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                View, Edit, or Delete Programs
                            </a>

                        </div>
                    </div>
                    <hr class="border-t border-gray-600"> <!-- Horizontal Divider -->

                    <!-- Program Progress Tracking -->
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-3">Program Progress Tracking</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Record Student Progress
                            </button>
                            <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Edit/View Student Progress
                            </button>
                            <button class="bg-red-500 hover:bg-red-700  text-white font-bold py-2 px-4 rounded">
                                Delete Progress Report
                            </button>
                        </div>
                    </div>
                    <hr class="border-t border-gray-600"> <!-- Horizontal Divider -->

                    <!-- Event Management -->
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-3">Event Management</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Create New Event
                            </button>
                            <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Edit/View Event Details
                            </button>
                            <button class="bg-red-500 hover:bg-red-700  text-white font-bold py-2 px-4 rounded">
                                Delete Event
                            </button>
                        </div>
                    </div>
                    <!-- No divider after the last section -->
                </div>
        </div>
    </div>
</main>
</body
