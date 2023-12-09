<!-- Inside partials/report_foreign_language_courses.php -->
<div class="bg-gray-800 p-6 rounded-lg shadow-lg overflow-hidden">
    <h3 class="text-2xl text-white font-bold mb-4 text-center">Strategic Foreign Language Courses</h3>
    <div class="flex items-center justify-center mb-4">
        <div class="text-white text-center px-4 py-2">
            <span class="material-icons-outlined text-blue-500" style="font-size: 2rem;">
                Taking additional strategic foreign language courses
            </span>
        </div>
        <div class="text-white">
            <div class="text-4xl font-bold">
                <?= esc($reportData['LanguageCourseCount']) ?>
            </div>
            <div class="text-lg text-gray-400">
                Students Enrolled
            </div>
        </div>
    </div>
    <p class="text-gray-400 text-sm text-center">
        The count represents students who have chosen to take additional strategic foreign language courses.
    </p>
</div>
