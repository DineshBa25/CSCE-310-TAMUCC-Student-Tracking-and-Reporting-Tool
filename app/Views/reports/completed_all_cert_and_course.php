<!-- Inside partials/report_completed_certifications_and_courses.php -->
<div class="bg-gray-800 p-6 rounded-lg shadow-md overflow-hidden">
    <h3 class="text-2xl text-white font-bold mb-6 text-center">Completion Report</h3>
    <div class="flex items-center justify-center">
        <div class="mr-4">
            <span class="text-green-500 material-icons-outlined" style="font-size: 4rem;">
                All Certifications and Courses
            </span>
        </div>
        <div class="text-white">
            <div class="text-4xl font-bold">
                <?= esc($reportData['CompletedBothCount']) ?>
            </div>
            <div class="text-lg text-gray-400">Students Completed</div>
        </div>
    </div>
    <div class="mt-6">
        <p class="text-gray-400 text-sm text-center">
            This represents the total number of students who have successfully completed all their certifications and courses.
        </p>
    </div>
</div>
