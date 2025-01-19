<div class="relative">
<?php
    if (isset($_SESSION['message'])) {
        echo "<div class='absolute success bg-blue-400 text-white left-1/2 translate-x-[-50%]  bottom-full text-lg px-10 py-3 rounded-md bg-opacity-70'>{$_SESSION['message']}</div>";
        echo "<script>setTimeout(function(){document.querySelector('.success').remove();},3000)</script>";
        unset($_SESSION['message']);
    }
    ?>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php if (!empty($courses)) : ?>
            <?php foreach ($courses as $course): ?>
                <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow">
                    <?php if ($course->getThumbnail()): ?>
                        <div class="aspect-w-16 aspect-h-9">
                            <img class="object-cover w-full" src="<?= htmlspecialchars($course->getThumbnail()) ?>" alt="<?= htmlspecialchars($course->getTitle()) ?>">
                        </div>
                        <?php endif; ?>
                        <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($course->getUsername()) ?>&background=random" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($course->getUsername()) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= htmlspecialchars($course->getCategoryName()) ?>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="/course/<?= $course->getId() ?>" class="hover:underline">
                                    <?= htmlspecialchars($course->getTitle()) ?>
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-500">
                                <?= htmlspecialchars(substr($course->getDescription(), 0, 150)) ?>...
                            </p>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <a href="/teacher/modify?id=<?=$course->getId()?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Modify Course
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No courses available at the moment.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>