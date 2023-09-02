Scanning.prototype.triggerInput = element => {
    element.parentElement.parentElement.querySelector('.active-input').click();
};

Scanning.prototype.cancelInput = element => {
    element.closest('li').remove();
    enablingUpload();
};

function enablingUpload() {
    const upSubmit = document.querySelector('#fuclouds-upload #up-submit');
    const filteredFile = document.querySelectorAll('#fuclouds-upload #filtered-file li');
    
    upSubmit.disabled = filteredFile.length === 0 ? true : false;
}

function createInput() {
    const fileUploadContainer = document.querySelector('#fuclouds-upload #file-input-container');
    
    // Create the input element with the specified attributes
    const inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = 'file[]';
    inputFile.classList.add('active-input');
    inputFile.multiple = true;
    inputFile.addEventListener('change', handleFileChange);
     
    // Append the input element to the file input container div
    fileUploadContainer.appendChild(inputFile);
}

// Function to handle the 'change' event and access file information
function handleFileChange(element) {
    const selectedFiles = element.target.files;
    if (selectedFiles.length > 0) {
        for (let i = 0; i < selectedFiles.length; i++) {
            createFilteredFile(selectedFiles[i].name, selectedFiles[i].size);
            enablingUpload();
        }
    }
    element.target.removeAttribute('class');
    createInput();
}

function createFilteredFile(filename, filesize) {
    const filteredFileContainer = document.querySelector('#fuclouds-upload #filtered-file');
    const filteredFile = document.createElement('li');
    const fileInfo = document.createElement('section');
    
    const fileText = document.createElement('p');
    fileText.textContent = filename;
    
    const fileSize = document.createElement('p');
    fileSize.textContent = filesize;
    
    const fileInput = document.createElement('input');
    fileInput.type = 'hidden';
    fileInput.name = 'filteredFiles[]';
    fileInput.value = filename;
    
    const cancel = document.createElement('button');
    cancel.type = 'button';
    cancel.classList.add('cancelInput');
    cancel.textContent = 'Cancel';
    
    fileInfo.append(fileText, fileSize, fileInput);
    filteredFile.append(fileInfo, cancel);
    filteredFileContainer.appendChild(filteredFile);
}



const searchKeyword = document.querySelector('#fuclouds-search #keyword');
if (searchKeyword) {
    searchKeyword.addEventListener('input', element => element.target.value = element.target.value.replace(/[^a-zA-Z0-9/-]/g, ""));
}

const uploadCodename = document.querySelector('#fuclouds-upload #codename');
if (uploadCodename) {
    uploadCodename.addEventListener('input', element => element.target.value = element.target.value.replace(/[^a-zA-Z0-9-]/g, ""));
}