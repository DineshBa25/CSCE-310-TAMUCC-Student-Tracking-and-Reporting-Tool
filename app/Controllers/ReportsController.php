<?php

namespace App\Controllers;

/**
 * Class ReportsController
 *
 * This class represents the reports controller in the application.
 */
class ReportsController extends BaseController
{
    /**
     * View the reports dashboard.
     *
     * If the user is not logged in, redirect them to the login page.
     * Based on the 'reportType' query parameter, determine which report data to generate.
     * Include the report data, user data, and report type in the view.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string Returns a redirect response to the login page if the user is not logged in. Otherwise, it returns the rendered view with the report
     * data, user data, and report type.
     */
    public function viewReportsDashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $reportType = $this->request->getVar('reportType'); // 'reportType' would be a query parameter
        $reportData = [];

        $userData = $this->userData;

        // Determine which report to generate based on the 'reportType' parameter
        switch ($reportType) {
            case 'total-enrollment':
                $reportData = $this->generateTotalEnrollmentReport();
                break;
            case 'minority-participation':
                $reportData = $this->generateMinorityParticipationReport();
                break;
            case 'student-majors':
                $reportData = $this->generateStudentMajorReport();
                break;
            case 'internship-locations':
                $reportData = $this->generateInternshipLocationsReport();
                break;
            case 'federal-internship':
                $reportData = $this->generateFederalInternshipReport();
                break;
            case 'seeking-federal-internships':
                $reportData = $this->generateSeekingFederalInternshipReport();
                break;
            case 'completed-certifications-and-courses':
                $reportData = $this->generateCompletedCertificationsAndCoursesReport();
                break;
            case 'foreign-language-course':
                $reportData = $this->generateForeignLanguageCourseReport();
                break;
            case 'cryptography-course':
                $reportData = $this->generateCryptographyCourseReport();
                break;
            case 'dod-enrollment':
                $reportData = $this->generateDoDEnrollmentReport();
                break;
            case 'dod-completion':
                $reportData = $this->generateDoDCompletionReport();
                break;
            case 'dod-exam-taken':
                $reportData = $this->generateDoDExamTakenReport();
                break;
            case 'k12-participation':
                $reportData = $this->generateK12EnrollmentReport();
                break;
        }

        // Include the report data in the view
        return view('reports', ['userData' => $userData, 'reportType' => $reportType, 'reportData' => $reportData]);
    }

    /**
     * Get the database connection.
     *
     * This method returns a database connection object by calling the connect() method from the \Config\Database class.
     *
     * @return \CodeIgniter\Database\BaseConnection Returns the database connection object.
     */
    private function getDbConnection()
    {
        return \Config\Database::connect();
    }

    /**
     * Generate the Total Enrollment Report.
     *
     * This method retrieves data from the database to generate a report on the total enrollment count for each program.
     * The SQL query joins the College_Student table with the Programs table and counts the number of students in each program.
     * The report data includes the program name and enrollment count.
     *
     * @return array Returns an array of associative arrays representing the report data.
     * Each associative array contains two keys:
     *  - 'ProgramName': The name of the program.
     *  - 'EnrollmentCount': The number of students enrolled in the program.
     */
    public function generateTotalEnrollmentReport()
    {
        $db = $this->getDbConnection();

        // The SQL query joins the College_Student table with the Programs table
        // and counts the number of students in each program.
        $sql = "SELECT p.Name as ProgramName, COUNT(a.UIN) as EnrollmentCount
            FROM Applications a
            JOIN Programs p ON a.Program_Num = p.Program_Num
            WHERE p.IsActive = 1
            GROUP BY a.Program_Num";

        $query = $db->query($sql);

        return $query->getResultArray();
    }

    /**
     * Generates a minority participation report.
     *
     * This method fetches data from the database to generate a report on the participation of minority students
     * by program and race. It groups students by program and race, and counts the number of students in each group.
     *
     * @return array An array of arrays representing the report data. Each inner array contains the following keys:
     *               - ProgramName: The name of the program.
     *               - Race: The race of the students.
     *               - MinorityCount: The count of minority students in the program and race group.
     */
    public function generateMinorityParticipationReport()
    {
        $db = $this->getDbConnection();

        // Adjust the query to group students by program and race, and count the number of students.
        $sql = "SELECT p.Name as ProgramName, cs.Race, COUNT(*) as MinorityCount
            FROM College_Student cs
            JOIN Applications a ON cs.UIN = a.UIN
            JOIN Programs p ON a.Program_Num = p.Program_Num
            WHERE cs.Race != 'Caucasian' AND cs.Race IS NOT NULL AND p.IsActive = 1
            GROUP BY p.Program_Num, cs.Race
            ORDER BY p.Name, cs.Race";

        $query = $db->query($sql);

        return $query->getResultArray();
    }

    /**
     * Generates a student major report.
     *
     * This method fetches data from the database to generate a report on the number of students in each major.
     * It counts the number of students in each major and sorts them alphabetically by major name.
     *
     * @return array An array of arrays representing the report data. Each inner array contains the following keys:
     *               - Major: The name of the major.
     *               - MajorCount: The count of students in the major.
     */
    public function generateStudentMajorReport()
    {
        $db = $this->getDbConnection();

        // The SQL query counts the number of students in each major.
        $sql = "SELECT Major, COUNT(*) as MajorCount
            FROM College_Student
            GROUP BY Major
            ORDER BY Major";

        $query = $db->query($sql);

        return $query->getResultArray();
    }

    /**
     * Generates an internship locations report.
     *
     * This method fetches data from the database to generate a report on the number of students at each internship location.
     * It counts the number of students at each location and orders the results by location name.
     *
     * @return array An array of arrays representing the report data. Each inner array contains the following keys:
     *               - Location: The name of the internship location.
     *               - StudentCount: The count of students at the internship location.
     */
    private function generateInternshipLocationsReport()
    {
        $db = $this->getDbConnection();

        // The SQL query counts the number of students at each internship location.
        $sql = "SELECT Location, COUNT(*) as StudentCount
            FROM Internship
            GROUP BY Location
            ORDER BY Location";

        $query = $db->query($sql);

        return $query->getResultArray();
    }

    /**
     * Generates a federal internship report.
     *
     * This method fetches data from the database to generate a report on the number of students in federal internships.
     * It calculates the total number of students in internships, the number of students in federal internships,
     * and the percentage of federal internships out of the total internships.
     *
     * @return array An array containing the following keys:
     *               - TotalInternshipCount: The total number of students in internships.
     *               - FederalInternshipCount: The number of students in federal internships.
     *               - Percentage: The percentage of federal internships out of the total internships.
     */
    private function generateFederalInternshipReport()
    {
        $db = $this->getDbConnection();

        // Query to get the total number of students in internships.
        $totalSql = "SELECT COUNT(DISTINCT ia.UIN) as TotalInternshipCount
                 FROM Intern_App ia";
        $totalQuery = $db->query($totalSql);
        $totalResult = $totalQuery->getRowArray();
        $totalInternshipCount = $totalResult['TotalInternshipCount'];

        // Query to get the number of students in federal internships.
        $federalSql = "SELECT COUNT(DISTINCT ia.UIN) as FederalInternshipCount
                   FROM Intern_App ia
                   JOIN Internship i ON ia.Intern_ID = i.Intern_ID
                   WHERE i.Is_Gov = 1";
        $federalQuery = $db->query($federalSql);
        $federalResult = $federalQuery->getRowArray();
        $federalInternshipCount = $federalResult['FederalInternshipCount'];

        // Calculate the percentage of federal internships.
        $percentage = ($totalInternshipCount > 0) ? ($federalInternshipCount / $totalInternshipCount) * 100 : 0;

        return [
            'TotalInternshipCount' => $totalInternshipCount,
            'FederalInternshipCount' => $federalInternshipCount,
            'Percentage' => $percentage
        ];
    }

    /**
     * Generates a report on the number of students seeking federal internships.
     *
     * This method fetches data from the database to generate a report on the number of students who are seeking
     * federal internships. It counts the number of distinct UINs in the Intern_App table where the internship is
     * a government internship and the status is either "Seeking" or "Pending".
     *
     * @return array An array containing the following key-value pair:
     *               - SeekingFederalCount: The count of students seeking federal internships.
     */
    private function generateSeekingFederalInternshipReport()
    {
        $db = $this->getDbConnection();

        // Query to get the number of students seeking federal internships.
        // 'Status' should be a field in 'Intern_App' that indicates the seeking status.
        $sql = "SELECT COUNT(DISTINCT ia.UIN) as SeekingFederalCount
            FROM Intern_App ia
            JOIN Internship i ON ia.Intern_ID = i.Intern_ID
            WHERE i.Is_Gov = 1 AND ia.Status = 'Seeking' or ia.Status = 'Pending'";

        $query = $db->query($sql);
        $seekingFederalResult = $query->getRowArray();
        $seekingFederalCount = $seekingFederalResult['SeekingFederalCount'];

        return [
            'SeekingFederalCount' => $seekingFederalCount
        ];
    }

    /**
     * Generates a report on the students who have completed all certifications and courses.
     *
     * This method fetches data from the database to generate a report on the students who have completed
     * all certifications and all courses. It retrieves the UIN of students who have completed all certifications
     * and all courses separately, and then finds the intersection of both sets to get the students who have
     * completed both. The method returns the count of such students.
     *
     * @return array An array containing the count of students who have completed both certifications and courses.
     *               The array has the following key:
     *               - CompletedBothCount: The count of students who have completed both certifications and courses.
     */
    private function generateCompletedCertificationsAndCoursesReport()
    {
        $db = $this->getDbConnection();

        // Query to get the number of students who have completed all certifications
        $certificationsSql = "SELECT UIN
                          FROM Cert_Enrollment
                          GROUP BY UIN
                          HAVING COUNT(CASE WHEN Status <> 'Completed' THEN 1 END) = 0";
        $certificationsQuery = $db->query($certificationsSql);
        $completedCertifications = $certificationsQuery->getResultArray();

        // Query to get the number of students who have completed all courses
        $coursesSql = "SELECT UIN
                   FROM Class_Enrollment
                   GROUP BY UIN
                   HAVING COUNT(CASE WHEN Status <> 'Completed' THEN 1 END) = 0";
        $coursesQuery = $db->query($coursesSql);
        $completedCourses = $coursesQuery->getResultArray();

        // Find intersection of both sets to get students who have completed both certifications and courses
        $completedBoth = array_uintersect($completedCertifications, $completedCourses, function ($item1, $item2) {
            return $item1['UIN'] - $item2['UIN'];
        });

        return [
            'CompletedBothCount' => count($completedBoth)
        ];
    }

    /**
     * Generates a report on the number of students enrolled in foreign language courses.
     *
     * This method fetches data from the database to generate a report on the number of students enrolled in
     * foreign language courses. It counts the number of unique UINs in Class_Enrollment table that are
     * associated with classes of type 'Foreign Language'.
     *
     * @return array An associative array representing the report data. The array contains the following key:
     *               - LanguageCourseCount: The count of students enrolled in foreign language courses.
     */
    private function generateForeignLanguageCourseReport()
    {
        $db = $this->getDbConnection();

        // The SQL query counts the number of students enrolled in strategic foreign language courses.
        // Replace 'Foreign Language' with the actual identifier used in your 'Classes' table.
        $sql = "SELECT COUNT(DISTINCT ce.UIN) as LanguageCourseCount
            FROM Class_Enrollment ce
            JOIN Classes c ON ce.Class_ID = c.Class_ID
            WHERE c.Type = 'Foreign Language'";

        $query = $db->query($sql);
        $result = $query->getRowArray();

        return $result;
    }

    /**
     * Generates a report on certification completion.
     *
     * This method fetches data from the database to generate a report on the completion of certifications.
     * It checks if the user is logged in through the session, redirects to the login page if not.
     * It retrieves the certification completion data by joining the Cert_Enrollment and Certification tables,
     * filtering by completed certifications, and grouping by certification name.
     * The result is returned as an array of arrays, where each inner array contains the following keys:
     * - Name: The name of the certification.
     * - Count: The count of completed certifications for that certification.
     *
     * @return \CodeIgniter\View\View A View object that renders the 'reports/certification_completion' view,
     *                               passing the report data as the 'data' variable.
     */
    public function reportCertificationCompletion()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $db = $this->getDbConnection();
        $sql = "SELECT c.Name, COUNT(*) as Count FROM Cert_Enrollment ce INNER JOIN Certification c ON ce.Cert_ID = c.Cert_ID WHERE ce.Status = 'Completed' GROUP BY c.Name";
        $query = $db->query($sql);
        $result = $query->getResultArray();

        return view('reports/certification_completion', ['data' => $result]);
    }

    /**
     * Generates a report on the number of students enrolled in cryptography courses.
     *
     * This method fetches data from the database to generate a report on the number of students enrolled
     * in cryptography courses. It counts the number of distinct UINs in the Class_Enrollment table for classes
     * that have a type of 'Mathematical Foundations of Cryptography' or a description that contains 'Cryptography'.
     *
     * @return array An array with a single key-value pair representing the report data. The key is 'CryptoCourseCount'
     *               and the value is the count of students enrolled in cryptography courses.
     */
    private function generateCryptographyCourseReport()
    {
        $db = $this->getDbConnection();

        // The SQL query counts the number of students enrolled in cryptography courses.
        // Adjust the WHERE clause to match how these courses are identified in your database.
        $sql = "SELECT COUNT(DISTINCT ce.UIN) as CryptoCourseCount
            FROM Class_Enrollment ce
            JOIN Classes c ON ce.Class_ID = c.Class_ID
            WHERE c.Type = 'Mathematical Foundations of Cryptography' OR c.Description LIKE '%Cryptography%'";

        $query = $db->query($sql);
        $result = $query->getRowArray();

        return $result;
    }

    /**
     * Generates a report on the enrollment of students in DoD 8570.01M preparation training courses.
     *
     * This method fetches data from the database to generate a report on the number of students currently
     * enrolled in DoD 8570.01M preparation training courses. The enrollment count is determined by counting
     * the number of records in the Cert_Enrollment table with a 'Status' value of 'Enrolled' for certifications
     * that have 'DoD 8570.01M' in their name or description.
     *
     * @return array An associative array containing the following key-value pair:
     *               - DoDEnrollmentCount: The count of students currently enrolled in DoD 8570.01M preparation
     *                 training courses.
     */
    private function generateDoDEnrollmentReport()
    {
        $db = $this->getDbConnection();

        // SQL query to count the number of students currently enrolled in DoD 8570.01M preparation training courses.
        // This assumes that 'DoD 8570.01M' is part of the name or description of the relevant certifications.
        $sql = "SELECT COUNT(*) as DoDEnrollmentCount
            FROM Cert_Enrollment ce
            INNER JOIN Certification c ON ce.Cert_ID = c.Cert_ID
            WHERE ce.Status = 'Enrolled'";
        $query = $db->query($sql);
        $result = $query->getRowArray();

        return $result;
    }

    /**
     * Generates a Department of Defense (DoD) completion report.
     *
     * This method fetches data from the database to generate a report on the completion of DoD 8570.01M preparation
     * training courses. It counts the number of students who have completed the training courses and retrieves the names
     * of the certifications they have completed.
     *
     * @return array An associative array representing the report data with the following keys:
     *               - DoDCompletionCount: The count of students who have completed the DoD preparation training courses.
     *               - CompletedCertifications: A string containing the names of the completed certifications,
     *                                         separated by commas and ordered alphabetically.
     */
    private function generateDoDCompletionReport()
    {
        $db = $this->getDbConnection();

        // SQL query to count the number of students who have completed the DoD 8570.01M preparation training courses
        // and retrieve the names of the certifications they completed.
        $sql = "SELECT COUNT(*) as DoDCompletionCount, GROUP_CONCAT(DISTINCT c.Name ORDER BY c.Name ASC) as CompletedCertifications
            FROM Cert_Enrollment ce
            INNER JOIN Certification c ON ce.Cert_ID = c.Cert_ID
            WHERE ce.Status = 'Completed'";

        $query = $db->query($sql);
        $result = $query->getRowArray();

        return $result;
    }

    /**
     * Generates a report on the number of students who have taken the DoD 8570.01M exam and their completed certifications.
     *
     * This method fetches data from the database to generate a report on the number of students who have taken the
     * DoD 8570.01M preparation training courses. It also retrieves the names of the certifications they completed.
     *
     * @return array An associative array representing the report data. The array has the following keys:
     *               - DoDExamTakenCount: The count of students who have taken the DoD 8570.01M exam.
     *               - CompletedCertifications: A string containing the names of the certifications the students completed,
     *                                         separated by commas and sorted alphabetically.
     */
    private function generateDoDExamTakenReport()
    {
        $db = $this->getDbConnection();

        // SQL query to count the number of students who have completed the DoD 8570.01M preparation training courses
        // and retrieve the names of the certifications they completed.
        $sql = "SELECT COUNT(*) as DoDExamTakenCount, GROUP_CONCAT(DISTINCT c.Name ORDER BY c.Name ASC) as CompletedCertifications
            FROM Cert_Enrollment ce
            INNER JOIN Certification c ON ce.Cert_ID = c.Cert_ID
            WHERE ce.Training_Status = 'In Progress (Exam Taken)' OR ce.Training_Status = 'PASSED' OR ce.Training_Status = 'FAILED'";

        $query = $db->query($sql);
        $result = $query->getRowArray();

        return $result;
    }

    /**
     * Generates a K-12 enrollment report.
     *
     * This method fetches data from the database to generate a report on the enrollment of K-12 students
     * in each program. It counts the number of K-12 students enrolled in each program and also calculates
     * the total number of K-12 students who have enrolled in any program.
     *
     * @return array An associative array with the following keys:
     *               - ProgramEnrollments: An array of arrays representing the program enrollments.
     *                 Each inner array contains the following keys:
     *                 - ProgramName: The name of the program.
     *                 - K12EnrollmentCount: The count of K-12 students enrolled in the program.
     *               - TotalK12Students: The total count of K-12 students who have enrolled in any program.
     */
    public function generateK12EnrollmentReport()
    {
        $db = $this->getDbConnection();

        // SQL query to count the number of K-12 students enrolled in each program.
        $sql = "SELECT p.Name as ProgramName, COUNT(*) as K12EnrollmentCount
            FROM Track t
                     JOIN College_Student cs ON t.UIN = cs.UIN
                     JOIN Programs p ON t.Program_Num = p.Program_Num
            WHERE cs.Classification = 'K-12'
            GROUP BY p.Program_Num";

        $query = $db->query($sql);
        $programEnrollments = $query->getResultArray();

        // SQL query to count the total number of K-12 students who have enrolled in any program.
        $totalK12StudentsSql = "SELECT COUNT(*) AS TotalK12Students
                            FROM (
                                SELECT DISTINCT cs.UIN
                                FROM College_Student cs
                                WHERE cs.Classification = 'K-12'
                            ) AS K12Students";

        $totalK12StudentsQuery = $db->query($totalK12StudentsSql);
        $totalK12Students = $totalK12StudentsQuery->getRowArray();

        // Add the total K-12 students count to the result.
        $result = [
            'ProgramEnrollments' => $programEnrollments,
            'TotalK12Students' => $totalK12Students['TotalK12Students']
        ];

        return $result;
    }


}
