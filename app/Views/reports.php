<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <!-- Flash messages here if any -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-gray-300 p-5 text-5xl font-bold">Report Generation</h1>
            <hr class="border ml-6 mr-6 border-gray-600 border-2">
            <div class="space-y-6 p-6">

                <!-- Student Demographics and Participation -->
                <div>
                    <h2 class="text-lg font-semibold text-white mb-3">Student Demographics and Participation</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=total-enrollment'); ?>'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Total Enrollment
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=minority-participation'); ?>'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Minority Participation
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=student-majors'); ?>'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Student Majors
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=k12-participation'); ?>'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            K-12 Participation
                        </button>
                    </div>
                </div>
                <hr class="border-t border-gray-600">

                <!-- Course and Training Reports -->
                <div>
                    <h2 class="text-lg font-semibold text-white mb-3">Course and Training Reports</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=completed-certifications-and-courses'); ?>'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Completed all Certifications and Courses
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=foreign-language-course'); ?>'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Language Courses Engagement
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=cryptography-course'); ?>'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Cryptography Courses Engagement
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=dod-enrollment'); ?>'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            DoD Training Enrollment
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=dod-completion'); ?>'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            DoD Training Completion
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=dod-exam-taken'); ?>'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            DoD Certification Exam Taken
                        </button>
                    </div>
                </div>
                <hr class="border-t border-gray-600">
                <!-- Internship and Employment Reports -->
                <div>
                    <h2 class="text-lg font-semibold text-white mb-3">Internship and Employment Reports</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=internship-locations'); ?>'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Internship Locations
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=federal-internship'); ?>'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Federal Internship Pursuits
                        </button>
                        <button onclick="window.location='<?= site_url('/reports/viewReportsDashboard?reportType=seeking-federal-internships'); ?>'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Seeking Federal Internships
                        </button>
                    </div>
                </div>
                <hr class="border-t border-gray-600">
                <h1 class="text-gray-300 p-5 text-5xl font-bold">View Report</h1>

                <!-- Section where the report will be displayed -->
                <?php if (isset($reportType) && $reportType === 'total-enrollment' && $reportData): ?>
                    <?= $this->include('reports/total_enrollment') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'minority-participation' && $reportData): ?>
                    <?= $this->include('reports/minority_participation') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'student-majors' && $reportData): ?>
                    <?= $this->include('reports/student_majors') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'internship-locations' && $reportData): ?>
                    <?= $this->include('reports/internship_locations') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'federal-internship' && $reportData): ?>
                    <?= $this->include('reports/federal_internship') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'seeking-federal-internships' && $reportData): ?>
                    <?= $this->include('reports/seeking_federal_internships') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'completed-certifications-and-courses' && $reportData): ?>
                    <?= $this->include('reports/completed_all_cert_and_course') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'foreign-language-course' && $reportData): ?>
                    <?= $this->include('reports/foreign_language_course_taking') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'cryptography-course' && $reportData): ?>
                    <?= $this->include('reports/cryptography_courses') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'dod-enrollment' && $reportData): ?>
                    <?= $this->include('reports/dod_cert_enrollment_report') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'dod-completion' && $reportData): ?>
                    <?= $this->include('reports/dod_cert_completion_report') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'dod-exam-taken' && $reportData): ?>
                    <?= $this->include('reports/dod_cert_exam_taken_report') ?>
                <?php endif; ?>
                <?php if (isset($reportType) && $reportType === 'k12-participation' && $reportData): ?>
                    <?= $this->include('reports/k12_participation') ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>
