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

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Add new file</h1>
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

            <!-- Profile Update Form -->
            <div class=" max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md">
                <form action="/file/add" enctype="multipart/form-data" method="post">
                    <?= csrf_field() ?>


                    <!-- file name (text input)-->
                    <div class="mb-7">
                        <label for="filename" class="block text-white text-sm font-medium mb-2">File Name</label>
                        <input type="text" name="filename" id="filename" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- file (file)-->
                    <div class="mb-7">
                        <label for="userfile" class="block text-white text-sm font-medium mb-2">File</label>
                        <input type="file" name="userfile" id="userfile" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- file type (select with options)-->
                    <div class="mb-7">
                        <label for="filetype" class="block text-white text-sm font-medium mb-2">File Type (PDF Only)</label>
                        <select name="filetype" id="filetype" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                            <option value="Resume">Resume</option>
                            <option value="Cover Letter">Cover Letter</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>


                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Document/File</button>
                    </div>
                </form>
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
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/view_file') ?>';" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                View, Edit, or Delete Files
            </button>
        </div>
    </div>
</main>
</body>
</html>
