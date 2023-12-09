<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Edit your User</h1>
            <hr class="border ml-6 mr-6 mb-5 border-gray-600 border-2">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-500 text-white text-center py-2 px-4 rounded">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="bg-red-500 text-white text-center py-2 px-4 rounded">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Profile Update Form -->
            <div class=" max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md">
                <form action="/user/update/<?= $userData['UIN'] ?>" method="post">
                    <?= csrf_field() ?>
                    <!-- UIN (text input)-->
                    <div class="mb-7">
                        <label for="uin" class="block text-white text-sm font-medium mb-2">UIN</label>
                        <input type="text" disabled name="uin" id="uin" required readonly class="bg-gray-600  border-gray-600 shadow appearance-none  rounded w-full py-2 px-3 text-gray-400 leading-tight " value="<?=$userData['UIN']?>">
                    </div>
                    <!-- First Name (text input)-->
                    <div class="mb-7">
                        <label for="first_name" class="block text-white text-sm font-medium mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"  value="<?=$userData['First_Name']?>">
                    </div>
                    <!-- Middle Initial (text input)-->
                    <div class="mb-7">
                        <label for="middle_initial" class="block text-white text-sm font-medium mb-2">Middle Initial</label>
                        <input type="text" name="middle_initial" id="middle_initial" maxlength="1" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" value="<?=$userData['M_Initial']?>">
                    </div>
                    <!-- Last Name (text input)-->
                    <div class="mb-7">
                        <label for="last_name" class="block text-white text-sm font-medium mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" value="<?=$userData['Last_Name']?>">
                    </div>
                    <!-- User Name (text input)-->
                    <div class="mb-7">
                        <label for="username" class="block text-white text-sm font-medium mb-2">User Name</label>
                        <input type="text" name="username" id="username" required maxlength="20" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" value="<?=$userData['Username']?>">
                    </div>
                    <!-- Password (text input)-->
                    <div class="mb-7">
                        <label for="password" class="block text-white text-sm font-medium mb-2">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter a new password (replace current one)"  maxlength="20" minlength="8" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>
                    <!-- Confirm Password (text input)-->
                    <div class="mb-7">
                        <label for="confirm_password" class="block text-white text-sm font-medium mb-2">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password replacement"  maxlength="20" minlength="8" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- User Type (select with options)-->
                    <div class="mb-7">
                        <label for="user_type" class="block text-white text-sm font-medium mb-2">User Type</label>
                        <select name="user_type" id="user_type" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" >
                            <option value="Student" <?= (isset($userData['User_Type']) && $userData['User_Type'] == 'Student') ? 'selected' : '' ?>>Student</option>
                            <option value="Administrator" <?= (isset($userData['User_Type']) && $userData['User_Type'] == 'Administrator') ? 'selected' : '' ?>>Administrator</option>
                        </select>
                    </div>
                    <!-- Email (text input)-->
                    <div class="mb-7">
                        <label for="email" class="block text-white text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" id="email" required maxlength="50" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"  value="<?=$userData['Email']?>">
                    </div>
                    <!-- Discord Name (text input)-->
                    <div class="mb-7">
                        <label for="discord_username" class="block text-white text-sm font-medium mb-2">User Name</label>
                        <input type="text" name="discord_username" id="discord_username" required maxlength="20" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"  value="<?=$userData['Discord_Name']?>">
                    </div>
                    <!-- Is Active (select with options)-->
                    <div class="mb-7">
                        <label for="is_active" class="block text-white text-sm font-medium mb-2">Activation status</label>
                        <select name="is_active" id="is_active" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                            <option value="1" <?= (isset($userData['IsActive']) && $userData['IsActive'] == 1) ? 'selected' : '' ?>>Activated</option>
                            <option value="0" <?= (isset($userData['IsActive']) && $userData['IsActive'] == 0) ? 'selected' : '' ?>>Deactivated</option>
                        </select>
                    </div>

                    <!-- Student-specific fields, initially hidden -->
                    <div id="student_fields" style="display:none;">
                        <hr/>
                        <h3 class="text-gray-400 p-5 text-2xl font-bold text-center">Student-specific fields</h3>
                        <!-- Gender (Select)-->
                        <div class="mb-7">
                            <label for="gender" class="block text-white text-sm font-medium mb-2">Gender</label>
                            <select name="gender" id="gender" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="Male" <?= (isset($studentData['Gender']) && $studentData['Gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= (isset($studentData['Gender']) && $studentData['Gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                                <option value="Prefer not to say" <?= (isset($studentData['Gender']) && $studentData['Gender'] == 'Prefer not to say') ? 'selected' : '' ?>>Prefer not to say</option>
                            </select>
                        </div>

                        <!-- Hispanic_Latino (Select)-->
                        <div class="mb-7">
                            <label for="hispanic_latino" class="block text-white text-sm font-medium mb-2">Hispanic or Latino</label>
                            <select name="hispanic_latino" id="hispanic_latino" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="1" <?= (isset($studentData['Hispanic_Latino']) && $studentData['Hispanic_Latino'] == 1) ? 'selected' : '' ?>>Yes</option>
                                <option value="0" <?= (isset($studentData['Hispanic_Latino']) && $studentData['Hispanic_Latino'] == 0) ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                        <!-- Race (select)-->
                        <div class="mb-7">
                            <label for="race" class="block text-white text-sm font-medium mb-2">Race</label>
                            <select name="race" id="race" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="" <?= (!isset($studentData['Race']) || $studentData['Race'] == '') ? 'selected' : '' ?>>--Please Select--</option>
                                <option value="White" <?= (isset($studentData['Race']) && $studentData['Race'] == 'White') ? 'selected' : '' ?>>White</option>
                                <option value="Black" <?= (isset($studentData['Race']) && $studentData['Race'] == 'Black') ? 'selected' : '' ?>>Black</option>
                                <option value="Asian" <?= (isset($studentData['Race']) && $studentData['Race'] == 'Asian') ? 'selected' : '' ?>>Asian</option>
                                <option value="Native American"  <?= (isset($studentData['Race']) && $studentData['Race'] == 'Native American') ? 'selected' : '' ?>>Native American</option>
                                <option value="Pacific Islander"  <?= (isset($studentData['Race']) && $studentData['Race'] == 'Pacific Islander') ? 'selected' : '' ?>>Pacific Islander</option>
                                <option value="Other" <?= (isset($studentData['Race']) && $studentData['Race'] == 'Other') ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <!-- US_Citizen (Select)-->
                        <div class="mb-7">
                            <label for="us_citizen" class="block text-white text-sm font-medium mb-2">US Citizen</label>
                            <select name="us_citizen" id="us_citizen" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="" <?= (!isset($studentData['US_Citizen']) || $studentData['US_Citizen'] === '') ? 'selected' : '' ?>>--Please Select--</option>
                                <option value="1" <?= (isset($studentData['US_Citizen']) && $studentData['US_Citizen'] == 1) ? 'selected' : '' ?>>Yes</option>
                                <option value="0" <?= (isset($studentData['US_Citizen']) && $studentData['US_Citizen'] == 0) ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                        <!-- First_Generation (Select)-->
                        <div class="mb-7">
                            <label for="first_generation" class="block text-white text-sm font-medium mb-2">First Generation</label>
                            <select name="first_generation" id="first_generation" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="" <?= (!isset($studentData['First_Generation']) || $studentData['First_Generation'] === '') ? 'selected' : '' ?>>--Please Select--</option>
                                <option value="1" <?= (isset($studentData['First_Generation']) && $studentData['First_Generation'] == 1) ? 'selected' : '' ?>>Yes</option>
                                <option value="0" <?= (isset($studentData['First_Generation']) && $studentData['First_Generation'] == 0) ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                        <!-- DoB (date input)-->
                        <div class="mb-7">
                            <label for="dob" class="block text-white text-sm font-medium mb-2">Date of Birth</label>
                            <input type="date" name="dob" id="dob" value="<?= isset($studentData['DoB']) ? esc($studentData['DoB']) : '' ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                        </div>
                        <!-- GPA (number input)-->
                        <div class="mb-7">
                            <label for="gpa" class="block text-white text-sm font-medium mb-2">GPA</label>
                            <input type="number" step="0.01" min="0" max="4" name="gpa" id="gpa" value="<?= isset($studentData['GPA']) ? esc($studentData['GPA']) : '' ?>" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                        </div>
                        <!-- Major (text input)-->
                        <div class="mb-7">
                            <label for="major" class="block text-white text-sm font-medium mb-2">Major</label>
                            <input type="text" name="major" id="major" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"  value="<?= isset($studentData['Major']) ? esc($studentData['Major']) : '' ?>">
                        </div>
                        <!-- TODO possibly change to dropdown with list of minors -->
                        <!-- Minor_1 (text input)-->
                        <div class="mb-7">
                            <label for="minor_1" class="block text-white text-sm font-medium mb-2">Minor 1</label>
                            <input type="text" name="minor_1" id="minor_1" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" value="<?= isset($studentData['Minor_1']) ? esc($studentData['Minor_1']) : '' ?>">
                        </div>
                        <!-- Minor_2 (text input)-->
                        <div class="mb-7">
                            <label for="minor_2" class="block text-white text-sm font-medium mb-2">Minor 2</label>
                            <input type="text" name="minor_2" id="minor_2" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" value="<?= isset($studentData['Minor_2']) ? esc($studentData['Minor_2']) : '' ?>">
                        </div>
                        <!-- Expected_Graduation (number input)-->
                        <div class="mb-7">
                            <label for="expected_graduation" class="block text-white text-sm font-medium mb-2">Expected Graduation Year</label>
                            <select name="expected_graduation" id="expected_graduation" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="" <?= (!isset($studentData['Expected_Graduation']) || $studentData['Expected_Graduation'] === '') ? 'selected' : '' ?>>--Please Select--</option>
                                <option value="2023" <?= (isset($studentData['Expected_Graduation']) && $studentData['Expected_Graduation'] == '2023') ? 'selected' : '' ?>>2023</option>
                                <option value="2024" <?= (isset($studentData['Expected_Graduation']) && $studentData['Expected_Graduation'] == '2024') ? 'selected' : '' ?>>2024</option>
                                <option value="2025" <?= (isset($studentData['Expected_Graduation']) && $studentData['Expected_Graduation'] == '2025') ? 'selected' : '' ?>>2025</option>
                                <option value="2026" <?= (isset($studentData['Expected_Graduation']) && $studentData['Expected_Graduation'] == '2026') ? 'selected' : '' ?>>2026</option>
                                <option value="2027" <?= (isset($studentData['Expected_Graduation']) && $studentData['Expected_Graduation'] == '2027') ? 'selected' : '' ?>>2027</option>
                                <option value="2028" <?= (isset($studentData['Expected_Graduation']) && $studentData['Expected_Graduation'] == '2028') ? 'selected' : '' ?>>2028</option>
                            </select>
                        </div>
                        <!-- School (text input)-->
                        <!-- TODO Add more colleges -->
                        <div class="mb-7">
                            <label for="school" class="block text-white text-sm font-medium mb-2">School</label>
                            <select name="school" id="school" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="Arts and Sciences" <?= (isset($studentData['School']) && $studentData['School'] == 'Arts and Sciences') ? 'selected' : '' ?>>Arts and Sciences</option>
                                <option value="Engineering" <?= (isset($studentData['School']) && $studentData['School'] == 'Engineering') ? 'selected' : '' ?>>Engineering</option>
                                <option value="Business" <?= (isset($studentData['School']) && $studentData['School'] == 'Business') ? 'selected' : '' ?>>Business</option>
                                <option value="Education and Human Development" <?= (isset($studentData['School']) && $studentData['School'] == 'Education and Human Development') ? 'selected' : '' ?>>Education and Human Development</option>
                                <option value="Health Sciences" <?= (isset($studentData['School']) && $studentData['School'] == 'Health Sciences') ? 'selected' : '' ?>>Health Sciences</option>
                            </select>
                        </div>
                        <!-- Classification (text input)-->
                        <div class="mb-7">
                            <label for="classification" class="block text-white text-sm font-medium mb-2">Classification</label>
                            <select name="classification" id="classification" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="" <?= (!isset($studentData['Classification']) || $studentData['Classification'] === '') ? 'selected' : '' ?>>--Please Select--</option>
                                <option value="Freshman" <?= (isset($studentData['Classification']) && $studentData['Classification'] == 'Freshman') ? 'selected' : '' ?>>Freshman</option>
                                <option value="Sophomore" <?= (isset($studentData['Classification']) && $studentData['Classification'] == 'Sophomore') ? 'selected' : '' ?>>Sophomore</option>
                                <option value="Junior" <?= (isset($studentData['Classification']) && $studentData['Classification'] == 'Junior') ? 'selected' : '' ?>>Junior</option>
                                <option value="Senior" <?= (isset($studentData['Classification']) && $studentData['Classification'] == 'Senior') ? 'selected' : '' ?>>Senior</option>
                            </select>
                        </div>
                        <!-- Phone (number input)-->
                        <div class="mb-7">
                            <label for="phone" class="block text-white text-sm font-medium mb-2">Phone</label>
                            <input type="tel" name="phone" id="phone" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500" value=<?= isset($studentData['Phone']) ? esc($studentData['Phone']) : '' ?>>
                        </div>
                        <div class="mb-7">
                            <label for="student_type" class="block text-white text-sm font-medium mb-2">Student Type</label>
                            <select name="student_type" id="student_type" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="" <?= (!isset($studentData['Student_Type']) || $studentData['Student_Type'] === '') ? 'selected' : '' ?>>--Please Select--</option>
                                <option value="Full-Time" <?= (isset($studentData['Student_Type']) && $studentData['Student_Type'] == 'Full-time') ? 'selected' : '' ?>>Full-Time</option>
                                <option value="Part-Time" <?= (isset($studentData['Student_Type']) && $studentData['Student_Type'] == 'Part-time') ? 'selected' : '' ?>>Part-Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>
<script>
    // Function to show or hide the student fields
    function toggleStudentFields() {
        var userType = document.getElementById('user_type').value;
        var studentFields = document.getElementById('student_fields');

        // If the user type is Student, show the additional fields
        if (userType === 'Student') {
            studentFields.style.display = 'block';
        } else {
            studentFields.style.display = 'none';
        }
    }

    // Event listener for when the user type dropdown changes
    document.getElementById('user_type').addEventListener('change', toggleStudentFields);

    // Initially call the function to set the correct display state
    toggleStudentFields();
</script>
</body>
</html>
