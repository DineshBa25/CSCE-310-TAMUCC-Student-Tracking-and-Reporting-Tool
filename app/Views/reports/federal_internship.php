<!-- Inside partials/report_federal_internships.php -->
<div class="bg-gray-800 p-6 rounded-lg shadow-md overflow-hidden">
    <h3 class="text-2xl text-white font-bold mb-4 text-center">Federal Internship Participation</h3>
    <div class="flex items-center justify-center mb-4">
        <div class="text-white text-center px-4 py-2 mr-4">
            <div class="text-4xl font-bold">
                <?= esc($reportData['FederalInternshipCount']) ?>
            </div>
            <div class="text-sm text-gray-400">
                Federal Internships
            </div>
        </div>
        <div class="text-white text-center px-4 py-2">
            <div class="text-4xl font-bold">
                <?= esc($reportData['TotalInternshipCount']) ?>
            </div>
            <div class="text-sm text-gray-400">
                Total Internships
            </div>
        </div>
    </div>
    <div class="w-full bg-gray-700 rounded-full h-2.5 dark:bg-gray-700 mb-2">
        <div class="bg-green-500 h-2.5 rounded-full" style="width: <?= esc($reportData['Percentage']) ?>%"></div>
    </div>
    <div class="text-center text-white">
        <?= number_format(esc($reportData['Percentage']), 2) ?>% in Federal Internships
    </div>
</div>
