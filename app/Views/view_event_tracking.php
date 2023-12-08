<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Trackings</title>
    <!-- Include Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">

<?= $this->include('navbar') ?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">

            <h1 class="text-gray-300 p-5 text-5xl font-bold">Event Trackings</h1>
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

            <!-- Show application status for each application (Show program and status, and app number) -->
            <div class="max-w mx-auto p-6 mb-5 bg-gray-800 rounded-md shadow-md overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Event Tracking Number
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            Event ID
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-600 bg-gray-700 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                            UIN
                        </th>
                        
                    </tr>
                    </thead>
                    <tbody class="text-gray-300">

                    <?php foreach ($event_trackings as $event_tracking): ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <?= $event_tracking['ET_Num'] ?>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <?= $event_tracking['Event_ID'] ?>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <?= $event_tracking['UIN'] ?>
                            </td>
                            
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <a href="/edit_event_tracking/<?= $event_tracking['ET_Num'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-5">Edit</a>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-600 bg-gray-700 text-sm">
                                <form action="/eventtracking/delete/<?= $event_tracking['ET_Num'] ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this event tracking?');" class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
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
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/event/create') ?>';" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                Create Event
            </button>
            <!-- button to edit application-->
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/event/view') ?>';" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                View Event
            </button>
            <!-- button to delete application-->
            <button type="button" onclick="window.location.href='<?= base_url('/index.php/event/edit') ?>';" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                Edit Event
            </button>
        </div>
    </div>
</main>
</body>
</html>