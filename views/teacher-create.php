
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Create New Course</h2>
                
                <form id="courseForm" action="/create-course" method="POST" enctype="multipart/form-data" class="space-y-6">
             
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Course Title</label>
                        <input type="text" name="title" id="title" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                 
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_name" id="category" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category->getName()) ?>">
                                    <?= htmlspecialchars($category->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

           
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700">Course Thumbnail</label>
                        <div class="mt-1 flex items-center">
                            <div class="w-full">
                                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <div id="thumbnail-preview" class="mt-2 hidden">
                                    <img src="" alt="Thumbnail preview" class="h-32 w-auto">
                                </div>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Upload a course thumbnail image (recommended size: 960x540)</p>
                    </div>

                    <!-- Content Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Content Type</label>
                        <div class="mt-2 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="content_type" value="video" class="form-radio text-indigo-600" checked>
                                <span class="ml-2">Video</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="content_type" value="document" class="form-radio text-indigo-600">
                                <span class="ml-2">Document</span>
                            </label>
                        </div>
                    </div>

                    <!-- Dynamic Content Field -->
                    <div id="content-container">
                        <!-- Video Upload -->
                        <div id="video-content" class="space-y-2">
                            <label for="video-file" class="block text-sm font-medium text-gray-700">Upload Video</label>
                            <input type="file" name="video" id="video-file" accept="video/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-sm text-gray-500">Maximum file size: 500MB</p>
                            <p id="video-error" class="mt-1 text-sm text-red-600 hidden">Please upload a video file</p>
                        </div>
                        
                        <!-- Document Editor -->
                        <div id="document-content" class="hidden">
                            <label for="document-content" class="block text-sm font-medium text-gray-700 mb-2">Document Content</label>
                            <input type="hidden" id="content" name="content" class="hidden">
                            <textarea id="markdown-editor" name="document"></textarea>
                            <p id="document-error" class="mt-1 text-sm text-red-600 hidden">Please enter document content</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Create Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

<script>



  
    var simplemde = new SimpleMDE({ 
        element: document.getElementById("markdown-editor"),
        spellChecker: false,
        autosave: {
            enabled: true,
            unique_id: "course_content"
        }
    });

   
    const contentTypeRadios = document.querySelectorAll('input[name="content_type"]');
    const videoContent = document.getElementById('video-content');
    const documentContent = document.getElementById('document-content');

    contentTypeRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            if (e.target.value === 'video') {
                videoContent.classList.remove('hidden');
                documentContent.classList.add('hidden');
            } else {
                videoContent.classList.add('hidden');
                documentContent.classList.remove('hidden');
            }
        });
    });

    const thumbnailInput = document.getElementById('thumbnail');
    const thumbnailPreview = document.getElementById('thumbnail-preview');
    const thumbnailImage = thumbnailPreview.querySelector('img');

    thumbnailInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailImage.src = e.target.result;
                thumbnailPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Form validation
    const courseForm = document.getElementById('courseForm');
    const videoFile = document.getElementById('video-file');
    const videoError = document.getElementById('video-error');
    const documentError = document.getElementById('document-error');

    courseForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset error messages
        videoError.classList.add('hidden');
        documentError.classList.add('hidden');
        
        const selectedType = document.querySelector('input[name="content_type"]:checked').value;
        let isValid = true;

        if (selectedType === 'video') {
            // Clear document content
            simplemde.value('');
            
            // Validate video file
            if (!videoFile.files || videoFile.files.length === 0) {
                videoError.classList.remove('hidden');
                isValid = false;
            }
        } else {
            // Clear video file
            videoFile.value = '';
            
            // Validate document content
            if (!simplemde.value().trim()) {
                documentError.classList.remove('hidden');
                isValid = false;
            }
        }

        if (isValid) {
            this.submit();
        }
    });
    function updatePreview() {
    const desc = document.getElementById("content");
    desc.value = JSON.stringify(simplemde.value());
}
simplemde.codemirror.on("change", updatePreview);
</script>