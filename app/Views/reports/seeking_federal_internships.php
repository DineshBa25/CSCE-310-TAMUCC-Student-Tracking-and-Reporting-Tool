<!-- Inside partials/report_seeking_federal_internships.php -->
<div class="bg-gray-800 p-6 rounded-lg shadow-lg overflow-hidden">
    <h3 class="text-2xl text-white font-bold mb-4 text-center">Federal Internship Seekers</h3>
    <div class="flex items-center justify-center mb-4">
        <div class="text-white text-center px-4 py-2">
            <span class="material-icons-outlined text-green-500" style="font-size: 4rem;">
                Seeking Federal Internships
            </span>
        </div>
        <div class="text-white">
            <div class="text-4xl font-bold">
                <?= esc($reportData['SeekingFederalCount']) ?>
            </div>
            <div class="text-lg text-gray-400">
                Students Applied/Pending
            </div>
        </div>
    </div>
    <p class="text-gray-400 text-sm text-center">
        The count represents students actively seeking opportunities in federal internships.
    </p>
</div>
