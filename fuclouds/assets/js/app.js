const fileUploadContainer = document.getElementById('file-upload-container');
    
// Function to handle the 'change' event and access file information
function handleFileChange(event) {
    const uploadedFiles= event.target.files;
    if (uploadedFiles.length > 0) {
        for (let i = 0; i < uploadedFiles.length; i++) {
            console.log(uploadedFiles[i].name);
        }
    }
    
    createInput();
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