<?php
/** @var \app\models\Course $course */
?>

<!-- Course Header with Background Image -->

<div class="relative">
    <?php 
    if(isset($_SESSION['success'])){
        echo "<div class='absolute success bg-green-400 text-white left-1/2 translate-x-[-50%]  bottom-full text-lg px-10 py-3 rounded-md bg-opacity-70'>Enrolled successfully</div>";
        echo "<script>setTimeout(function(){document.querySelector('.success').remove();},3000)</script>";
        unset($_SESSION['success']);
      }
    ?> 
    <div class="h-96 w-full overflow-hidden">
        <?php if ($course->getThumbnail()): ?>
            <img src="<?= htmlspecialchars($course->getThumbnail()) ?>" alt="<?= htmlspecialchars($course->getTitle()) ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-r from-indigo-500 to-purple-600"></div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-3xl">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        <?= htmlspecialchars($course->getTitle()) ?>
                    </h1>
                    <p class="mt-6 text-xl text-gray-300">
                        <?= htmlspecialchars($course->getDescription()) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="w-full">
            <div class="sticky top-4">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6">
                        <!-- Instructor Info -->
                        <div class="flex items-center space-x-4 mb-6">
                            <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($course->getUsername()) ?>&background=random" alt="">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    <?= htmlspecialchars($course->getUsername()) ?>
                                </h3>
                                <p class="text-sm text-gray-500">Instructor</p>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="space-y-4 mb-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Category</h4>
                                <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($course->getCategoryName()) ?></p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Content type</h4>
                                <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($course->getContentType()) ?></p>
                            </div>
                        </div>

                        <!-- Enroll Button -->
                        <form action="/enroll" method="POST">
                            <input type="hidden" class="hidden" name="course_id" value="<?= $course->getId() ?>">
                            <input type="hidden" class="hidden" name="user_id" value="<?=isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '' ?>">
                        <button <?=$isEnrolled ? 'disabled' : ''?> class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white <?=$isEnrolled ? ' bg-green-600 ': ' bg-indigo-600 hover:bg-indigo-700'?> focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                             <?=$isEnrolled ? 'Enrolled' : 'Enroll in Course'?>
                        </button>
                        </form>
                        <a href="/study/course?id=<?=$course->getId()?>" class="<?=$isEnrolled?'':'hidden'?> mt-5 w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white  bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                             <?=$isEnrolled ? 'Study Course' : ''?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
</div>