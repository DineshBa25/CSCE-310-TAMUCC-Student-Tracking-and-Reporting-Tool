<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <!-- Include Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('<?= base_url('/images/cyber-background.png'); ?>');
            background-size: cover;
            backdrop-filter: blur(3px);
        }
        .logo {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: auto;
        }
        .my-custom-margin-top {
            margin-top: 600px; /* Adjust the value as needed */
            padding: 50px;
        }
    </style>
</head>
<body class="bg-opacity-70 flex justify-center items-center h-screen relative">
<!-- Cybersecurity Logo -->
<div class="mb-6 text-center">
    <img class="logo h-30 w-200" src="<?= base_url('/images/tamu-cyber-long-logo.png'); ?>" alt="Cybersecurity Logo">
</div>
<div class="my-custom-margin-top">
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-500 text-white text-center py-2 px-4 rounded m-20">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php elseif (session()->getFlashdata('error')): ?>
    <div class="bg-red-500 text-white text-center py-2 px-4 rounded m-20">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<div class="bg-white bg-opacity-80 p-8 rounded shadow-md w-full max-w-sm">
    <h3 class="mb-3 text-center text-xl">Student Tracking and Reporting Tool</h3>
    <h2 class="mb-6 text-center text-2xl font-bold">Registration Form</h2>
    <form action="<?= site_url('registration/process') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label for="uin" class="block text-gray-700 text-sm font-bold mb-2">UIN:</label>
            <input type="text" name="uin" id="uin" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
            <input type="text" name="first_name" id="first_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="m_initial" class="block text-gray-700 text-sm font-bold mb-2">Middle Initial:</label>
            <input type="text" name="m_initial" id="m_initial" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
            <input type="text" name="username" id="username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
            <input type="password" name="password" id="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="user_type" class="block text-gray-700 text-sm font-bold mb-2">User Type:</label>
            <input type="text" name="user_type" id="user_type" required readonly class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-400 leading-tight focus:outline-none focus:shadow-outline" value="Student">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" name="email" id="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="discord_name" class="block text-gray-700 text-sm font-bold mb-2">Discord Name:</label>
            <input type="text" name="discord_name" id="discord_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Register</button>
        </div>
    </form>
    <div class="mt-4">
        <a href="<?= site_url('login') ?>" class="text-blue-500 hover:underline">Already have an account? Login here</a>
    </div>
</div>
</div>
</body>
</html>
