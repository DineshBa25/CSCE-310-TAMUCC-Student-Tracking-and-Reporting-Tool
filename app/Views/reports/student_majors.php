<!-- Inside partials/report_student_majors.php -->
<div class="bg-gray-800 p-5 rounded-lg shadow-md">
    <h3 class="text-xl text-gray-300 font-bold mb-2">Student Majors</h3>
    <table class="min-w-full leading-normal">
        <thead>
        <tr>
            <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Major
            </th>
            <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Student Count
            </th>
        </tr>
        </thead>
        <tbody class="text-gray-300">
        <?php foreach ($reportData as $major): ?>
            <tr>
                <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                    <?= esc($major['Major']) ?>
                </td>
                <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                    <?= esc($major['MajorCount']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
