<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Edit Your Application</h1>
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

            <!-- Application Edit Form -->
            <div class="max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md">
                <form action="/application/update/<?= $application['App_Num'] ?>" method="post"
                    <?= csrf_field() ?>
                    <input type="hidden" name="app_num" value="<?= $application['App_Num'] ?>">

                    <!-- Existing data should be fetched from the database and filled in as values in the input fields -->

                    <!-- Dropdown to select the program (with the current program preselected) -->
                    <div class="mb-6">
                        <label for="program" class="block text-white text-sm font-medium mb-2">Select Program:</label>
                        <select id="program" name="program" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                            <?php foreach ($programs as $program): ?>
                                <option value="<?= esc($program['Program_Num']) ?>" <?= $program['Program_Num'] == $application['Program_Num'] ? 'selected' : '' ?>>
                                    <?= esc($program['Name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Completed Certifications (text area) -->
                    <div class="mb-6">
                        <label for="completed_certifications" class="block text-white text-sm font-medium mb-2">Completed Certifications:</label>
                        <textarea name="completed_certifications" id="completed_certifications" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($application['Com_Cert']) ?></textarea>
                    </div>

                    <!-- Uncompleted Certifications (text area) -->
                    <div class="mb-6">
                        <label for="uncompleted_certifications" class="block text-white text-sm font-medium mb-2">Uncompleted Certifications:</label>
                        <textarea name="uncompleted_certifications" id="uncompleted_certifications" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($application['Uncom_Cert']) ?></textarea>
                    </div>

                    <!-- Purpose Statement (text area) -->
                    <div class="mb-6">
                        <label for="purpose_statement" class="block text-white text-sm font-medium mb-2">Purpose Statement:</label>
                        <textarea name="purpose_statement" id="purpose_statement" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($application['Purpose_Statement']) ?></textarea>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Application
                        </button>
                        <button type="button" onclick="window.location.href='<?= base_url('/index.php/view_application') ?>';" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
