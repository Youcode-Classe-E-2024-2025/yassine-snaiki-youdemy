<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

<div class="relative">
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='absolute success bg-blue-400 text-white left-1/2 translate-x-[-50%]  bottom-full text-lg px-10 py-3 rounded-md bg-opacity-70'>{$_SESSION['message']}</div>";
        echo "<script>setTimeout(function(){document.querySelector('.success').remove();},3000)</script>";
        unset($_SESSION['message']);
    }
    ?>
    <div class="h-96 w-full overflow-hidden">
        <?php if ($course->getThumbnail()): ?>
            <img src="<?= htmlspecialchars($course->getThumbnail()) ?>" alt="<?= htmlspecialchars($course->getTitle()) ?>"
                class="w-full h-full object-cover">
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
                        <img class="h-12 w-12 rounded-full"
                            src="https://ui-avatars.com/api/?name=<?= urlencode($course->getUsername()) ?>&background=random"
                            alt="">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                <?= htmlspecialchars($course->getUsername()) ?>
                            </h3>
                            <p class="text-sm text-gray-500">Instructor</p>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="space-y-4 mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Title</h4>
                        <form action="/change-title" method="POST" class="flex gap-2 ">
                            <input type="hidden" name="course_id" value="<?= $course->getId() ?>">
                            <input type="text" name="title" class="text-sm text-gray-900"
                                placeholder="<?= htmlspecialchars($course->getTitle()) ?>">
                            <button class="bg-green px-4 py-2">save</button>
                        </form>
                    </div>
                    <div class="space-y-4 mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Description</h4>
                        <form action="/change-description" method="POST" class="flex gap-2 ">
                            <input type="hidden" name="course_id" value="<?= $course->getId() ?>">
                            <input type="text" name="description" class="text-sm text-gray-900"
                                value="<?= htmlspecialchars($course->getDescription()) ?>">
                            <button class="bg-green px-4 py-2">save</button>
                        </form>
                    </div>
                    <div class="space-y-4 mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Category</h4>
                        <form action="/change-category" method="POST" class="flex gap-2 ">
                            <input type="hidden" name="course_id" value="<?= $course->getId() ?>">
                            <select class=" text-sm text-gray-900" name="category">
                                <option class="hidden"><?= htmlspecialchars($course->getCategoryName()) ?></option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->getName() ?>">
                                        <?= htmlspecialchars($category->getName()) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="bg-green px-4 py-2">save</button>
                        </form>
                    </div>
                    <div class="space-y-4 mb-6">
                        <h4 class="text-sm font-medium text-gray-500">Tags</h4>
                        <input type="text" id="tags">
                        <button id="addTagsButton" class="bg-green px-4 py-2">save</button>
                        <div class="bg-white rounded-lg shadow">
                            <div class="p-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-medium text-gray-900">Tags</h2>
                            </div>
                            <div class="p-4 overflow-auto" style="max-height: 400px;">
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($courseTags as $tag): ?>
                                        <div class="inline-flex items-center bg-gray-100 rounded-full px-3 py-1">
                                            <span
                                                class="text-sm text-gray-700"><?= htmlspecialchars($tag->getName()) ?></span>
                                            <form action="/remove-tag-from-course" method="POST">

                                                <input type="hidden" name="tag" value="<?= $tag->getName() ?>">
                                                <input type="hidden" name="course_id" value="<?=$course->getId()?>">
                                                <button class="ml-2 text-gray-500 hover:text-red-600"
                                                    data-tag-id="<?= $tag->getName() ?>">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Content type</h4>
                        <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($course->getContentType()) ?></p>
                    </div>

                 
                    <form action="/delete-course" method="POST" class="mt-10">
                        <input type="hidden" class="hidden" name="course_id" value="<?= $course->getId() ?>">
                        <button
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white  bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Delete course
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var input = document.querySelector('#tags');
    var tagify = new Tagify(input, {
        whitelist: <?= json_encode(array_map(function ($tag) {
            return $tag->getName(); }, $tags)) ?>,
        dropdown: {
            maxItems: 20,
            classname: "tags-look",
            enabled: 0,
            closeOnSelect: false
        }
    });
    document.getElementById('addTagsButton').addEventListener('click', function () {
        const tags = tagify.value.map(tag => tag.value);

        if (tags.length === 0) {
            return;
        }

        fetch('/add-tags-to-course', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ tags: tags, course_id: <?= json_encode($course->getId()) ?> })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert('Error adding tags: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding tags. Please try again.');
            });
    });

</script>