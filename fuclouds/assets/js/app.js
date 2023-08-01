const fileUploadContainer = document.getElementById('file-upload-container');
    
// Function to handle the 'change' event and access file information
function handleFileChange(event) {
    const selectedFiles= event.target.files;
    if (selectedFiles.length > 0) {
        for (let i = 0; i < selectedFiles.length; i++) {
            createStagedFiles(selectedFiles[i].name);
        }
    }
    event.target.style.display = 'none';
    createInput();
}

function createStagedFiles(selectedFile) {
    const filename = document.createElement('p');
    filename.textContent = selectedFile;
    fileUploadContainer.appendChild(filename);
}

function createInput(isRequired = false) {
    // Create the input element with the specified attributes
    const inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = 'file[]';
    inputFile.classList.add('file-input');
    inputFile.addEventListener('change', handleFileChange);
    inputFile.multiple = true;
     if (isRequired) {
         inputFile.required = true;
     }
     
    // Append the input element to the file input container div
    fileUploadContainer.appendChild(inputFile);
}