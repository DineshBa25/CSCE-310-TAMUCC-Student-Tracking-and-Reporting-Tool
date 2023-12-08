<?php

namespace App\Controllers;

class ReportsController extends BaseController
{
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

    private function getDbConnection()
    {
        return \Config\Database::connect();
    }

    private function generateTotalEnrollmentReport()
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

    private function generateMinorityParticipationReport()
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

    private function generateStudentMajorReport()
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
    private function generateK12EnrollmentReport()
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
