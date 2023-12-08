<!-- Inside partials/report_k12_enrollment.php -->
<div class="bg-gray-800 p-5 rounded-lg shadow-md">
    <h3 class="text-2xl text-white font-bold mb-6 text-center">K-12 Student Enrollment</h3>
    <div class="flex items-center justify-center">
        <div class="mr-4">
            <span class="text-blue-500 material-icons-outlined" style="font-size: 4rem;">
                Total Enrollment
            </span>
        </div>
        <div class="text-white">
            <div class="text-4xl font-bold">
                <?= esc($reportData['TotalK12Students']) ?>
            </div>
            <div class="text-lg text-gray-400">K-12 Students</div>
        </div>
    </div>
    <div class="mt-6">
        <p class="text-gray-400 text-sm text-center">
            The count represents the total number of K-12 students enrolled in various programs. This includes all K-12 students, regardless of program enrollment.
        </p>
    </div>
    <hr class=" mt-7 mb-7"/>
    <h3 class="text-xl text-gray-300 font-bold mb-2">K-12 Student Enrollment by Program</h3>
    <table class="min-w-full leading-normal">
        <thead>
        <tr>
            <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Program Name
            </th>
            <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Enrollment Count
            </th>
        </tr>
        </thead>
        <tbody class="text-gray-300">
        <?php foreach ($reportData['ProgramEnrollments'] as $programEnrollment): ?>
            <tr>
                <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                    <?= esc($programEnrollment['ProgramName']) ?>
                </td>
                <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                    <?= esc($programEnrollment['K12EnrollmentCount']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
