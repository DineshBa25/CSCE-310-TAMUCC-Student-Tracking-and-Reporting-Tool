<!-- Inside partials/report_minority_participation.php -->
<div class="bg-gray-800 p-5 rounded-lg shadow-md">
    <h3 class="text-xl text-gray-300 font-bold mb-2">Minority Participation by Program</h3>
    <?php $lastProgramName = ""; ?>
    <?php foreach ($reportData as $entry): ?>
<?php if ($entry['ProgramName'] != $lastProgramName): ?>
<?php if ($lastProgramName != ""): ?>
    </tbody>
    </table>
<?php endif; ?>
    <h4 class="text-lg text-gray-300 font-bold mt-4 mb-2"><?= esc($entry['ProgramName']) ?></h4>
    <table class="min-w-full leading-normal">
        <thead>
        <tr>
            <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Race
            </th>
            <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                Count
            </th>
        </tr>
        </thead>
        <tbody class="text-gray-300">
        <?php endif; ?>
        <tr>
            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                <?= esc($entry['Race']) ?>
            </td>
            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                <?= esc($entry['MinorityCount']) ?>
            </td>
        </tr>
        <?php $lastProgramName = $entry['ProgramName']; ?>
        <?php endforeach; ?>
        <?php if ($lastProgramName != ""): ?>
        </tbody>
    </table>
<?php endif; ?>
</div>
