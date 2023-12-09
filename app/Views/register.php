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
            margin-top: 1700px; /* Adjust the value as needed */
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

        <hr>
        <h2 class="mb-6 text-center text-2xl font-bold">Student Information</h2>
        <!-- Gender (Select) -->
        <div class="mb-4">
            <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender:</label>
            <select name="gender" id="gender" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <!-- Race (Select) -->
        <div class="mb-4">
            <label for="race" class="block text-gray-700 text-sm font-bold mb-2">Race:</label>
            <select name="race" id="race" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Race</option>
                <option value="White">White</option>
                <option value="Black">Black</option>
                <option value="Asian">Asian</option>
                <option value="Native American">Native American</option>
                <option value="Pacific Islander">Pacific Islander</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <!-- US Citizen (Checkbox) -->
        <div class="mb-4">
            <label for="us_citizen" class="block text-gray-700 text-sm font-bold mb-2">US Citizen:</label>
            <input type="checkbox" name="us_citizen" id="us_citizen" class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- First Generation (Checkbox) -->
        <div class="mb-4">
            <label for="first_generation" class="block text-gray-700 text-sm font-bold mb-2">First Generation Student:</label>
            <input type="checkbox" name="first_generation" id="first_generation" class="shadow border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- Date of Birth (Date input) -->
        <div class="mb-4">
            <label for="dob" class="block text-gray-700 text-sm font-bold mb-2">Date of Birth:</label>
            <input type="date" name="dob" id="dob" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- GPA (Number input) -->
        <div class="mb-4">
            <label for="gpa" class="block text-gray-700 text-sm font-bold mb-2">GPA:</label>
            <input type="number" step="0.01" name="gpa" id="gpa" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- Major (Text input) -->
        <div class="mb-4">
            <label for="major" class="block text-gray-700 text-sm font-bold mb-2">Major:</label>
            <input type="text" name="major" id="major" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- Minor 1 (Text input) -->
        <div class="mb-4">
            <label for="minor_1" class="block text-gray-700 text-sm font-bold mb-2">Minor 1:</label>
            <input type="text" name="minor_1" id="minor_1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- Minor 2 (Text input) -->
        <div class="mb-4">
            <label for="minor_2" class="block text-gray-700 text-sm font-bold mb-2">Minor 2:</label>
            <input type="text" name="minor_2" id="minor_2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- Expected Graduation (Select) -->
        <div class="mb-4">
            <label for="expected_graduation" class="block text-gray-700 text-sm font-bold mb-2">Expected Graduation Year:</label>
            <input type="number" name="expected_graduation" id="expected_graduation" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- School (Select) -->
        <div class="mb-4">
            <label for="school" class="block text-gray-700 text-sm font-bold mb-2">School:</label>
            <input type="text" name="school" id="school" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- Classification (Select) -->
        <div class="mb-4">
            <label for="classification" class="block text-gray-700 text-sm font-bold mb-2">Classification:</label>
            <select name="classification" id="classification" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Classification</option>
                <option value="Freshman">Freshman</option>
                <option value="Sophomore">Sophomore</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior</option>
                <option value="Graduate">Graduate</option>
            </select>
        </div>

        <!-- Phone (Number input) -->
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
            <input type="tel" name="phone" id="phone" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <!-- Student Type (Select) -->
        <div class="mb-4">
            <label for="student_type" class="block text-gray-700 text-sm font-bold mb-2">Student Type:</label>
            <select name="student_type" id="student_type" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">Select Student Type</option>
                <option value="Full-Time">Full-Time</option>
                <option value="Part-Time">Part-Time</option>
            </select>
        </div>

    </form>
    <div class="mt-4">
        <a href="<?= site_url('login') ?>" class="text-blue-500 hover:underline">Already have an account? Login here</a>
    </div>
</div>
</div>
</body>
</html>
