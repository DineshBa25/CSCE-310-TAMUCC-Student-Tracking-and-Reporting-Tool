<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Report</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Program Report for <?= esc($reportData['ProgramName']) ?></h1>
            <hr class="border ml-6 mr-6 mb-5 border-gray-600 border-2">

            <!-- Report Details -->
            <div class="mb-5 bg-gray-800 rounded-md shadow-md p-6">
                <h3 class="text-gray-400 text-2xl font-bold text-center mb-4">Enrollment Details</h3>

                <!-- Table for Report Data -->
                <table class="table-auto w-full">
                    <thead>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-2">Metric</th>
                        <th class="px-4 py-2">Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border px-4 py-2">Total Students</td>
                        <td class="border px-4 py-2"><?= esc($reportData['TotalStudents']) ?></td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">Minority Students</td>
                        <td class="border px-4 py-2"><?= esc($reportData['MinorityStudents']) ?></td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">K-12 Students</td>
                        <td class="border px-4 py-2"><?= esc($reportData['K12Students']) ?></td>
                    </tr>
                    <!-- Add additional rows for other metrics as needed -->
                    </tbody>
                </table>

                <h3 class="text-gray-400 text-2xl font-bold text-center mt-6 mb-4">Majors Distribution</h3>

                <!-- Table for Majors Data -->
                <table class="table-auto w-full">
                    <thead>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-2">Major</th>
                        <th class="px-4 py-2">Students Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Loop through majors data to display rows -->
                    <?php foreach ($reportData['Majors'] as $major => $count): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= esc($major) ?></td>
                            <td class="border px-4 py-2"><?= esc($count) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center mt-4">
                <button type="button" onclick="window.location.href='<?= base_url('/index.php/view_program') ?>';" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Back to program view
                </button>
            </div>
        </div>
    </div>
</main>
</body>
</html>
