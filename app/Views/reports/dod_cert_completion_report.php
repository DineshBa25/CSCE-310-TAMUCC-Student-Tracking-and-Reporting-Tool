<!-- Inside partials/report_dod_completion.php -->
<div class="bg-gray-800 p-6 rounded-lg shadow-lg overflow-hidden">
    <h3 class="text-2xl text-white font-bold mb-6 text-center">DoD 8570.01M Training Completion</h3>
    <div class="flex items-center justify-center">
        <div class="mr-4">
            <span class="text-blue-500 material-icons-outlined" style="font-size: 4rem;">
                Completed Training
            </span>
        </div>
        <div class="text-white">
            <div class="text-4xl font-bold">
                <?= esc($reportData['DoDCompletionCount']) ?>
            </div>
            <div class="text-lg text-gray-400">Students Completed</div>
        </div>
    </div>
    <div class="mt-6">
        <p class="text-gray-400 text-sm text-center">
            The count represents students who have successfully completed DoD 8570.01M certification preparation training.
        </p>
    </div>
</div>
