<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Edit Your Event</h1>
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

            <div class="max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md">
                <form action="/event/update/<?= $event['Event_ID'] ?>" method="post"
                    <?= csrf_field() ?>
                    <input type="hidden" name="event_id" value="<?= $event['Event_ID'] ?>">


                    

                    <div class="mb-6">
                        <label for="uin" class="block text-white text-sm font-medium mb-2">UIN:</label>
                        <textarea name="uin" id="uin" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($event['UIN']) ?></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="program_num" class="block text-white text-sm font-medium mb-2">Program Number:</label>
                        <textarea name="program_num" id="program_num" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($event['Program_Num']) ?></textarea>
                    </div>


                    <div class="mb-6">
                        <label for="start_date" class="block text-white text-sm font-medium mb-2">Start Date:</label>
                        <textarea name="start_date" id="start_date" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($event['Start_Date']) ?></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="start_time" class="block text-white text-sm font-medium mb-2">Start Time:</label>
                        <textarea name="start_time" id="start_time" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($event['Start_Time']) ?></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="location" class="block text-white text-sm font-medium mb-2">Location:</label>
                        <textarea name="location" id="location" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($event['Location']) ?></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="end_date" class="block text-white text-sm font-medium mb-2">End Date:</label>
                        <textarea name="end_date" id="end_date" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($event['End_Date']) ?></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="end_time" class="block text-white text-sm font-medium mb-2">End Time:</label>
                        <textarea name="end_time" id="end_time" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($event['End_Time']) ?></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="event_type" class="block text-white text-sm font-medium mb-2">Event Type:</label>
                        <textarea name="event_type" id="event_type" rows="4" class="w-full bg-gray-700 text-white border border-gray-600 rounded-md py-2 px-3 focus:outline-none focus:border-indigo-500"><?= esc($event['Event_Type']) ?></textarea>
                    </div>
                    

                    <div class="flex justify-between items-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Event
                        </button>
                        <button type="button" onclick="window.location.href='<?= base_url('/index.php/view_event') ?>';" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>
</body>
</html>
