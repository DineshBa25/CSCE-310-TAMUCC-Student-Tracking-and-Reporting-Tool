<!-- Inside partials/report_internship_locations.php -->
<div class="bg-gray-800 p-6 rounded-lg shadow-lg overflow-hidden">
    <h3 class="text-2xl text-white font-bold mb-4 text-center">Internship Location Distribution</h3>

    <!-- Summary section -->
    <div class="mb-4">
        <p class="text-lg text-gray-300 text-center mb-2">
            Overview of student distribution across internship locations.
        </p>
    </div>

    <!-- Internship locations table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-600">
            <thead>
            <tr>
                <th class="px-5 py-3 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                    Internship Location
                </th>
                <th class="px-5 py-3 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                    Student Count
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-600 text-gray-300">
            <?php foreach ($reportData as $location): ?>
                <tr>
                    <td class="px-5 py-5 bg-gray-700 text-sm">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <?= esc($location['Location']) ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-5 bg-gray-700 text-sm">
                        <?= esc($location['StudentCount']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
