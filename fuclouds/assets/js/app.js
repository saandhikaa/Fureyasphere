function createInput(isRequired = false) {
    const fileUploadContainer = document.getElementById('file-upload-container');
    
    // Create the input element with the specified attributes
    const inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = 'file[]';
    inputFile.classList.add('file-input');
    inputFile.addEventListener('change', createInput);
    inputFile.multiple = true;
     if (isRequired) {
         inputFile.required = true;
     }
     
    // Append the input element to the file input container div
    fileUploadContainer.appendChild(inputFile);
}