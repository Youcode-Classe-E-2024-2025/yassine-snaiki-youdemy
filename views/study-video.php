<?php
/** @var \app\models\Course $course */
?>

<div class="bg-gray-900 min-h-screen">
    <!-- Course Header -->
    <div class="bg-gray-800 text-white py-4 px-6 mb-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold"><?= htmlspecialchars($course->getTitle()) ?></h1>
            <p class="text-gray-400 mt-2"><?= htmlspecialchars($course->getDescription()) ?></p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Main Content - Video Player -->
            <div class="lg:col-span-8">
                <div class="bg-black rounded-lg overflow-hidden shadow-xl">
                    <!-- Video Player -->
                    <div class="aspect-w-16 aspect-h-9">
                        <video id="courseVideo" class="w-full" controls controlsList="nodownload">
                            <source src="<?= htmlspecialchars($course->getContent()) ?>" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-4 mt-6 lg:mt-0">
                <div class="sticky top-4">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Instructor Info -->
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Instructor</h3>
                            <div class="flex items-center">
                                <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($course->getUsername()) ?>&background=random" alt="">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($course->getUsername()) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= htmlspecialchars($course->getCategoryName()) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">About This Course</h2>
                    <div class="prose prose-indigo max-w-none">
                        <?= htmlspecialchars($course->getDescription()) ?>
                    </div>
                </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>