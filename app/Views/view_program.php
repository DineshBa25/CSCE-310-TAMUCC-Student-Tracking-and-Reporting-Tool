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

            <h1 class="text-gray-300 p-5 text-5xl font-bold">View, edit, and delete programs</h1>
            <hr class="border ml-6 mr-6 mb-5 border-gray-600 border-2">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-500 text-white text-center py-2 px-4 rounded">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="bg-red-500 text-white text-center py-2 px-4 rounded">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Program Number
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Program Name
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Edit
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Delete
                        </th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-300">

                    <?php foreach ($programs as $program): ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <?= $program['Program_Num'] ?>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <?= $program['Name'] ?>
                            </td>
                            <!-- description -->
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <?= $program['Description'] ?>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <a href="/edit_program/<?= $program['Program_Num'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-5">Edit</a>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <form action="/program/delete/<?= $program['Program_Num'] ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this program?');" class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


        </div>
        <div class="flex justify-center mt-4">
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/dashboard') ?>';" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </button>
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/add_program') ?>';" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                Add a new program
            </button>
        </div>
    </div>
</main>
</body>
</html>
