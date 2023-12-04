<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Tailwind CSS CDN -->
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
    </style>
</head>
<body class="bg-opacity-70 flex justify-center items-center h-screen relative">
<!-- Cybersecurity Logo -->
<div class="mb-6 text-center">
    <img class="logo h-30 w-200" src="<?= base_url('/images/tamu-cyber-long-logo.png'); ?>" alt="Cybersecurity Logo">
</div>
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-500 text-white text-center py-2 px-4 rounded m-20">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php elseif (session()->getFlashdata('error')): ?>
    <div class="bg-red-500 text-white text-center py-2 px-4 rounded m-20">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php elseif (session()->getFlashdata('warning')): ?>
    <div class="bg-yellow-500 text-white text-center py-2 px-4 rounded">
        <?= session()->getFlashdata('warning') ?>
    </div>
<?php endif; ?>
<div class="bg-white bg-opacity-80 p-8 rounded shadow-md w-full max-w-sm">
    <h3 class="mb-3 text-center text-xl">Student Tracking and Reporting Tool</h3>
    <h2 class="mb-6 text-center text-2xl font-bold">Login Form</h2>
    <form action="<?= site_url('login/authenticate') ?>" method="post">
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
            <input type="text" name="username" id="username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
            <input type="password" name="password" id="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <a href="<?= site_url('register') ?>" class="text-blue-500 hover:underline">Don't have an account? Register here</a>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Login</button>
        </div>
    </form>
</div>
</body>
</html>
