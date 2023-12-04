<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Edit your program</h1>
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

            <!-- Program Edit Form -->
            <div class="max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md">
                <form action="/program/update/<?= $program['Program_Num'] ?>" method="post"
                <?= csrf_field() ?>
                <input type="hidden" name="program_num" value="<?= $program['Program_Num'] ?>">

                <!-- program name (text input)-->
                <div class="mb-7">
                    <label for="program" class="block text-white text-sm font-medium mb-2">Program Name</label>
                    <input type="text" name="program" id="program" value="<?= $program['Name'] ?>" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                </div>

                <!-- program description (text area)-->
                <div class="mb-7">
                    <label for="description" class="block text-white text-sm font-medium mb-2">Program Description</label>
                    <textarea placeholder="Please describe the program." name="description" id="description" cols="30" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($program['Description']) ?></textarea>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Program
                    </button>
                    <button type="button" onclick="window.location.href='<?= base_url('/index.php/view_program') ?>';" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                </div>
                </form>
            </div>

        </div>
    </div>
</main>
</body>
</html>
