<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Create Event</h1>
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
                <form action="/application/submit" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-7">
                        <label for="program" class="block text-white text-sm font-medium mb-2">What program do you intend to apply for?</label>
                        <!-- dropdown with all the programs listed-->
                        <select id="program" name="program" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500">
                            <!-- go through $programs and add each ones 'Name' as an option-->
                            <?php foreach ($programs as $program): ?>
                                <option value="<?= esc($program['Program_Num']) ?>"><?= esc($program['Name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- UIN (greyed out and disabled)-->
                    <div class="mb-7">
                        <label for="uin" class="block text-white text-sm font-medium mb-2">UIN</label>
                        <input type="text" name="uin" id="uin" required readonly class="bg-gray-600  border-gray-600 shadow appearance-none  rounded w-full py-2 px-3 text-gray-400 leading-tight " value="<?=$userData['UIN']?>">
                    </div>

                    <!-- completed certifications (text area)-->
                    <div class="mb-7">
                        <label for="start_date" class="block text-white text-sm font-medium mb-2">Start Date</label>
                        <textarea placeholder="Enter the start date of the event." name="start_date" id="start_date" cols="30" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"></textarea>
                    </div>

                    <!-- uncompleted certifications (text area)-->
                    <div class="mb-7">
                        <label for="start_time" class="block text-white text-sm font-medium mb-2">Start Time</label>
                        <textarea placeholder="Please enter the start time of the event." name="start_time" id="start_time" cols="30" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"></textarea>
                    </div>

                    <!-- purpose statement (text area) with description given-->
                    <div class="mb-7">
                        <label for="location" class="block text-white text-sm font-medium mb-2">Location</label>
                        <textarea placeholder="Please enter the location of the event." name="location" id="location" cols="30" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"></textarea>
                    </div>

                    <div class="mb-7">
                        <label for="end_date" class="block text-white text-sm font-medium mb-2">End Date</label>
                        <textarea placeholder="Please enter the end date of the event." name="end_date" id="end_date" cols="30" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"></textarea>
                    </div>

                    <div class="mb-7">
                        <label for="end_time" class="block text-white text-sm font-medium mb-2">End Time</label>
                        <textarea placeholder="Please enter the end time of the event." name="end_time" id="end_time" cols="30" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"></textarea>
                    </div>

                    <div class="mb-7">
                        <label for="event_type" class="block text-white text-sm font-medium mb-2">Event Type</label>
                        <textarea placeholder="Please enter the event type of the event." name="event_type" id="event_type" cols="30" rows="5" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"></textarea>
                    </div>


                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit Application</button>
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
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/event/view') ?>';" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                View Events
            </button>
            <!-- button to edit application-->
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/event/edit') ?>';" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                Edit an event
            </button>
            <!-- button to delete application-->
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/event/delete') ?>';" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                Delete an event
            </button>
        </div>
    </div>
</main>
</body>
</html>
