<?php
/** @var array $courses */
/** @var array $categories */
/** @var int $pagesNum */
/** @var int $currPage */
?>

<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Course Catalog</h1>
        <p class="text-gray-600">Explore our wide range of courses</p>
    </div>

    <!-- Categories Section -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-4">
            <?php foreach ($categories as $category): ?>
                <a href="/courses?category=<?= $category->getName() ?>" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-500 transition-colors">
                    <svg class="w-4 h-4 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    <?= htmlspecialchars($category->getName()) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Course Grid -->
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
                            <a href="/course/<?= $course->getId() ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View Course
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

    <!-- Pagination -->
    <div class="mt-6 bg-white px-4 py-3 border border-gray-200 rounded-lg sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 flex justify-between">
                <a href="/courses?<?=isset($cg) ? 'category='.$cg.'&' : ''?><?=isset($query) ? 'q='.$query.'&' : ''?>page=<?=$currPage-1 < 1 ? 1 : $currPage-1?>" 
                   class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?= $currPage <= 1 ? 'opacity-50 cursor-not-allowed' : '' ?>">
                    Previous
                </a>
                <ul class="flex gap-2">
                    <?php foreach(range(1, $pagesNum) as $n): ?>
                        <a href="/courses?<?=isset($cg) ? 'category='.$cg.'&' : ''?><?=isset($query) ? 'q='.$query.'&' : ''?>page=<?=$n?>" 
                           class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 <?=$currPage==$n ? 'bg-indigo-50 text-indigo-600 border-indigo-500' : 'bg-white'?>">
                            <?=$n?>
                        </a>
                    <?php endforeach?>
                </ul>
                <a href="/courses?<?=isset($cg) ? 'category='.$cg.'&' : ''?><?=isset($query) ? 'q='.$query.'&' : ''?>page=<?=$currPage+1 > $pagesNum ? $pagesNum : $currPage+1?>" 
                   class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?= $currPage >= $pagesNum ? 'opacity-50 cursor-not-allowed' : '' ?>">
                    Next
                </a>
            </div>
        </div>
    </div>
</div>