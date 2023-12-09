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

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Application Status</h1>
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

            <!-- Show application status for each application (Show program and status, and app number) -->
            <div class="max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Application Number
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Program Name
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Status
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

                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <?= $application['App_Num'] ?>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <?= $application['Program_Name'] ?>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                    <span aria-hidden class="absolute inset-0 <?= $application['status'] === 'Pending' ? 'bg-yellow-500' : ($application['status'] === 'Accepted' ? 'bg-green-500' : 'bg-red-500') ?> rounded-full"></span>
                                    <span class="relative text-white">
                                        <?= $application['status'] ?>
                                    </span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <a href="/edit_application/<?= $application['App_Num'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-5">Edit</a>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <form action="/application/delete/<?= $application['App_Num'] ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this application?');" class="text-red-600 hover:text-red-900">
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
            <!-- button to view application status-->
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/application/status') ?>';" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                Submit an application
            </button>
            <!-- button to edit application-->
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/application/edit') ?>';" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                Edit a submitted application
            </button>
            <!-- button to delete application-->
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/application/delete') ?>';" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                Delete a submitted application
            </button>
        </div>
    </div>
</main>
</body>
</html>
