<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Add new user (Student or Administrator)</h1>
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
                <form action="/user/add" method="post">
                    <?= csrf_field() ?>
                    <!-- UIN (text input)-->
                    <div class="mb-7">
                        <label for="uin" class="block text-white text-sm font-medium mb-2">UIN</label>
                        <input type="text" name="uin" id="uin" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>
                    <!-- First Name (text input)-->
                    <div class="mb-7">
                        <label for="first_name" class="block text-white text-sm font-medium mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>
                    <!-- Middle Initial (text input)-->
                    <div class="mb-7">
                        <label for="middle_initial" class="block text-white text-sm font-medium mb-2">Middle Initial</label>
                        <input type="text" name="middle_initial" id="middle_initial" maxlength="1" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>
                    <!-- Last Name (text input)-->
                    <div class="mb-7">
                        <label for="last_name" class="block text-white text-sm font-medium mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>
                    <!-- User Name (text input)-->
                    <div class="mb-7">
                        <label for="username" class="block text-white text-sm font-medium mb-2">User Name</label>
                        <input type="text" name="username" id="username" required maxlength="20" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>
                    <!-- Password (text input)-->
                    <div class="mb-7">
                        <label for="password" class="block text-white text-sm font-medium mb-2">Password</label>
                        <input type="password" name="password" id="password" required maxlength="20" minlength="8" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>
                    <!-- Confirm Password (text input)-->
                    <div class="mb-7">
                        <label for="confirm_password" class="block text-white text-sm font-medium mb-2">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required maxlength="20" minlength="8" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- User Type (select with options)-->
                    <div class="mb-7">
                        <label for="user_type" class="block text-white text-sm font-medium mb-2">User Type</label>
                        <select name="user_type" id="user_type" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none
                        focus:border-indigo-500">
                            <option value="Student">Student</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                    <!-- Email (text input)-->
                    <div class="mb-7">
                        <label for="email" class="block text-white text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" id="email" required maxlength="50" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none
                        focus:border-indigo-500">
                    </div>
                    <!-- Discord Name (text input)-->
                    <div class="mb-7">
                        <label for="discord_username" class="block text-white text-sm font-medium mb-2">User Name</label>
                        <input type="text" name="discord_username" id="discord_username" required maxlength="20" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                    </div>
                    <!-- Is Active (select with options)-->
                    <div class="mb-7">
                        <label for="is_active" class="block text-white text-sm font-medium mb-2">Should the user account be activated or deactivated upon creation?</label>
                        <select name="is_active" id="is_active" required class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none
                        focus:border-indigo-500">
                            <option value="1">Activated</option>
                            <option value="0">Deactivated</option>
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
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Prefer not to say">Prefer not to say</option>
                            </select>
                        </div>
                        <!-- Hispanic_Latino (Select)-->
                        <div class="mb-7">
                            <label for="hispanic_latino" class="block text-white text-sm font-medium mb-2">Hispanic or Latino</label>
                            <select name="hispanic_latino" id="hispanic_latino" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <!-- Race (select)-->
                        <div class="mb-7">
                            <label for="race" class="block text-white text-sm font-medium mb-2">Race</label>
                            <select name="race" id="race" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <!-- TODO find way to make null not a string -->
                                <option value="null" >--Please Select--</option>
                                <option value="White">White</option>
                                <option value="Black">Black</option>
                                <option value="Asian">Asian</option>
                                <option value="Native American">Native American</option>
                                <option value="Pacific Islander">Pacific Islander</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <!-- US_Citizen (Select)-->
                        <div class="mb-7">
                            <label for="us_citizen" class="block text-white text-sm font-medium mb-2">US Citizen</label>
                            <select name="us_citizen" id="us_citizen" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="null" >--Please Select--</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <!-- First_Generation (Select)-->
                        <div class="mb-7">
                            <label for="first_generation" class="block text-white text-sm font-medium mb-2">First Generation</label>
                            <select name="first_generation" id="first_generation" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="null" >--Please Select--</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <!-- DoB (date input)-->
                        <div class="mb-7">
                            <label for="dob" class="block text-white text-sm font-medium mb-2">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                        </div>
                        <!-- GPA (number input)-->
                        <div class="mb-7">
                            <label for="gpa" class="block text-white text-sm font-medium mb-2">GPA</label>
                            <input type="number" step="0.01" min="0" max="4" name="gpa" id="gpa" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                        </div>
                        <!-- Major (text input)-->
                        <div class="mb-7">
                            <label for="major" class="block text-white text-sm font-medium mb-2">Major</label>
                            <input type="text" name="major" id="major" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                        </div>
                        <!-- TODO possibly change to dropdown with list of minors -->
                        <!-- Minor_1 (text input)-->
                        <div class="mb-7">
                            <label for="minor_1" class="block text-white text-sm font-medium mb-2">Minor 1</label>
                            <input type="text" name="minor_1" id="minor_1" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                        </div>
                        <!-- Minor_2 (text input)-->
                        <div class="mb-7">
                            <label for="minor_2" class="block text-white text-sm font-medium mb-2">Minor 2</label>
                            <input type="text" name="minor_2" id="minor_2" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                        </div>
                        <!-- Expected_Graduation (number input)-->
                        <div class="mb-7">
                            <label for="expected_graduation" class="block text-white text-sm font-medium mb-2">Expected Graduation Year</label>
                            <select name="expected_graduation" id="expected_graduation" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="null" >--Please Select--</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                            </select>
                        </div>
                        <!-- School (text input)-->
                        <!-- TODO Add more colleges -->
                        <div class="mb-7">
                            <label for="school" class="block text-white text-sm font-medium mb-2">School</label>
                            <select name="school" id="school" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="Arts and Sciences">Arts and Sciences</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Business">Business</option>
                                <option value="Education and Human Development">Education and Human Development</option>
                                <option value="Health Sciences">Health Sciences</option>
                            </select>
                        </div>
                        <!-- Classification (text input)-->
                        <div class="mb-7">
                            <label for="classification" class="block text-white text-sm font-medium mb-2">Classification</label>
                            <select name="classification" id="classification" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="null" >--Please Select--</option>
                                <option value="Freshman">Freshman</option>
                                <option value="Sophomore">Sophomore</option>
                                <option value="Junior">Junior</option>
                                <option value="Senior">Senior</option>
                            </select>
                        </div>
                        <!-- Phone (number input)-->
                        <div class="mb-7">
                            <label for="phone" class="block text-white text-sm font-medium mb-2">Phone</label>
                            <input type="tel" name="phone" id="phone" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                        </div>
                        <!-- Student_Type (text input)-->
                        <div class="mb-7">
                            <label for="student_type" class="block text-white text-sm font-medium mb-2">Student Type</label>
                            <select name="student_type" id="student_type" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                                <option value="null" >--Please Select--</option>
                                <option value="Full-Time">Full-Time</option>
                                <option value="Part-Time">Part-Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add user</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="flex justify-center mt-4">
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/dashboard') ?>';" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </button>
            <!-- button to view application status-->
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/view_users') ?>';" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                View, Edit, or Delete Users
            </button>
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
