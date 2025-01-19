<div class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
        <p class="text-gray-600">Platform overview and statistics</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600">Total Courses</h2>
                    <p class="text-2xl font-semibold text-gray-800"><?= $coursesNum ?></p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600">Total Students</h2>
                    <p class="text-2xl font-semibold text-gray-800"><?= $studentsNum ?></p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600">Total Teachers</h2>
                    <p class="text-2xl font-semibold text-gray-800"><?= $teachersNum ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow p-6 max-h-96 overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Courses per Category</h3>
            <div class="space-y-4">
                <?php foreach ($coursesPerCategory as $category => $count): ?>
                    <div class="relative">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($category) ?></span>
                            <span class="text-sm font-medium text-gray-700"><?= $count ?></span>
                        </div>
                        <div class="overflow-hidden h-2   rounded bg-gray-200">
                            <div style="width: <?= ($count / $coursesNum * 100) ?>%" class="  bg-indigo-500 h-full"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Teachers</h3>
            <div class="space-y-2 divide-y-2 divide-dashed divide-gray-400">
                <?php foreach ($top3Teachers as $index => $teacher): ?>
                    <div class="flex items-center p-4 ">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center <?= $index === 0 ? 'bg-yellow-100 text-yellow-600' : ($index === 1 ? 'bg-gray-100 text-gray-600' : 'bg-orange-100 text-orange-600') ?>">
                                #<?= $index + 1 ?>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900"><?= htmlspecialchars($teacher->getUsername()) ?></h4>
                                    <p class="text-sm text-gray-500"><?= $teacher->courseCount() ?> courses</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-100 text-gray-800' : 'bg-orange-100 text-orange-800') ?>">
                                        Top <?= $index + 1 ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="mt-8 bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Most Enrolled Course</h3>
            <div class="flex items-center">
                <?php if ($mostEnrolled->getThumbnail()): ?>
                    <img src="<?= htmlspecialchars($mostEnrolled->getThumbnail()) ?>" alt="Course thumbnail" class="w-32 h-24 object-cover rounded">
                <?php else: ?>
                    <div class="w-32 h-24 bg-gray-200 rounded flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                <?php endif; ?>
                <div class="ml-6">
                    <h4 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($mostEnrolled->getTitle()) ?></h4>
                    <p class="text-gray-600 mt-1"><?= htmlspecialchars($mostEnrolled->getUsername()) ?></p>
                    <p class="text-gray-500 mt-1"><?= htmlspecialchars($mostEnrolled->getCategoryName()) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>