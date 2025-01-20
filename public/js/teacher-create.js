let simplemde = new SimpleMDE({
    element: document.getElementById("markdown-editor"),
    spellChecker: false,
    autosave: {
        enabled: true,
        unique_id: "course_content"
    }
});
function updateDocumentInput() {
    const documentInput = document.getElementById("content");
    documentInput.value = JSON.stringify(simplemde.value());
}
simplemde.codemirror.on("change", updateDocumentInput);


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

thumbnailInput.addEventListener('change', function (e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            thumbnailImage.src = e.target.result;
            thumbnailPreview.classList.remove('hidden');
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});


const courseForm = document.getElementById('courseForm');
const videoFile = document.getElementById('video-file');

const videoError = document.getElementById('video-error');
const documentError = document.getElementById('document-error');
const titleError = document.getElementById('title-error');
const descriptionError = document.getElementById('description-error');
const categoryError = document.getElementById('category-error');

const title = document.getElementById('title');
const description = document.getElementById('description');
const category = document.getElementById('category');

courseForm.addEventListener('submit', function (e) {
    e.preventDefault();

   

    videoError.classList.add('hidden');
    documentError.classList.add('hidden');
    titleError.classList.add('hidden');
    descriptionError.classList.add('hidden');
    categoryError.classList.add('hidden');
    let isValid = true;
    const selectedType = document.querySelector('input[name="content_type"]:checked').value;
    
    if (selectedType === 'video') {
        simplemde.value('');
        if (!videoFile.files || videoFile.files.length === 0) {
            videoError.classList.remove('hidden');
            isValid = false;
        }
    } else {
        videoFile.value = '';
        if (!simplemde.value().trim()) {
            documentError.classList.remove('hidden');
            isValid = false;
        }
    }
    if(title.value.length < 4 || title.value =='') {
        titleError.classList.remove('hidden');
        isValid = false;
    }
    if(description.value.length < 4 || description.value =='') {
        descriptionError.classList.remove('hidden');
        isValid = false;
    }
    if(category.value == '') {
        categoryError.classList.remove('hidden');
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
});
