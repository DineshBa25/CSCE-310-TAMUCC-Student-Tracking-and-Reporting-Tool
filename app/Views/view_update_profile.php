<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Update and View Profile</h1>
            <hr class="border ml-6 mr-6 mb-5 border-gray-600 border-2">
            <h3 class="text-gray-400 p-5 text-2xl font-bold text-center">Update User Data</h3>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-500 text-white text-center py-2 px-4 rounded">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="bg-red-500 text-white text-center py-2 px-4 rounded">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Profile Update Form -->
            <div class=" max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md">
                <form action="/profile/update_process" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-7">
                        <label for="first_name" class="block text-white text-sm font-medium mb-2">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?= esc($userData['First_Name']) ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" required>
                    </div>

                    <div class="mb-7">
                        <label for="m_initial" class="block text-white text-sm font-medium mb-2">Middle Initial</label>
                        <input type="text" id="m_initial" name="m_initial" value="<?= esc($userData['M_Initial']) ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>

                    <div class="mb-7">
                        <label for="last_name" class="block text-white text-sm font-medium mb-2">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?= esc($userData['Last_Name']) ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" required>
                    </div>

                    <div class="mb-7">
                        <label for="email" class="block text-white text-sm font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" value="<?= esc($userData['Email']) ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" required>
                    </div>

                    <div class="mb-7">
                        <label for="last_name" class="block text-white text-sm font-medium mb-2">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?= esc($userData['Last_Name']) ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" required>
                    </div>

                    <div class="mb-7">
                        <label for="username" class="block text-white text-sm font-medium mb-2">User Name</label>
                        <input type="text" id="user_name" name="user_name" value="<?= esc($userData['Username']) ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" required>
                    </div>

                    <div class="mb-7">
                        <label for="discord_uname" class="block text-white text-sm font-medium mb-2">User Name</label>
                        <input type="text" id="discord_uname" name="discord_uname" value="<?= esc($userData['Discord_Name']) ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" required>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                    </div>
                </form>
            </div>
            <hr class="border ml-6 mr-6 mb-10 border-gray-600 border-2">

            <!--Button that links to password reset page -->
            <div class="flex justify-center mt-4">
                <h2 class="text-gray-400 p-5 text-2xl font-bold text-center">Reset Password:  </h2>
                <button type="button" onclick="window.location.href='<?= base_url('/index.php/reset_password') ?>';" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Reset Password
                </button>
            </div>



            <hr class="border ml-6 mt-10 mr-6 mb-5 border-gray-600 border-2">

            <h3 class="text-gray-400 p-5 text-2xl font-bold text-center">View Student Information</h3>

            <!-- Student Information Display -->
            <div class="max-w-4xl mx-auto p-6 bg-gray-800 rounded-md shadow-md">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <tbody class="text-white">
                        <tr>
                            <td class="border px-4 py-2">GPA:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['GPA']) ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Major:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['Major']) ?></td>
                        </tr>
                        <!-- ... add other student fields as necessary ... -->
                        <tr>
                            <td class="border px-4 py-2">Minor 1:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['Minor_1']) ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Minor 2:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['Minor_2']) ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Expected Graduation:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['Expected_Graduation']) ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">School:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['School']) ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Classification:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['Classification']) ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Phone:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['Phone']) ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">Student Type:</td>
                            <td class="border px-4 py-2"><?= esc($studentData['Student_Type']) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-4">
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/dashboard') ?>';" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </button>
        </div>

    </div>
</main>
</body>
</html>
