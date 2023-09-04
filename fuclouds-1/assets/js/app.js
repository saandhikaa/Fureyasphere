Scanning.prototype.triggerInput = element => {
    element.parentElement.parentElement.querySelector('.active-input').click();
};

Scanning.prototype.cancelInput = element => {
    element.closest('li').remove();
    enablingUpload();
};



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
    const listed = element.target.parentElement.parentElement.querySelectorAll('#filtered-file p.fileSize');
    const selectedFiles = element.target.files;
    const newFileSize = Array.from(selectedFiles).reduce((total, file) => total + file.size, 0);
    
    let listedFileSize = 0;
    if (listed.length > 0) {
        const sizes = Array.from(listed).map(size => size.textContent);
        
        for (const sizeString of sizes) {
            if (sizeString.includes(" KB")) {
                // Remove " KB" and convert to a numeric value in bytes
                listedFileSize += Math.ceil(parseFloat(sizeString.replace(" KB", "")) * 1024);
            } else if (sizeString.includes(" MB")) {
                // Remove " MB" and convert to a numeric value in bytes
                listedFileSize += Math.ceil(parseFloat(sizeString.replace(" MB", "")) * 1024 * 1024);
            }
        }
    }
    
    if (newFileSize + listedFileSize <= 40 * 1024 * 1024) {
        Array.from(selectedFiles).forEach(file => {createFilteredFile(file.name, file.size)});
    } else {
        alert('You chose a file that exceeds the 40MB limit.');
    }
    
    element.target.removeAttribute('class');
    createInput();
    enablingUpload();
}

function createFilteredFile(filename, filesize) {
    const filteredFileContainer = document.querySelector('#fuclouds-upload #filtered-file');
    const filteredFile = document.createElement('li');
    const fileInfo = document.createElement('section');

    const fileText = document.createElement('p');
    fileSize.classList.add('fileName');
    fileText.textContent = filename;
    
    const fileSize = document.createElement('p');
    fileSize.classList.add('fileSize');
    fileSize.textContent = formatBytes(filesize);
    
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

function enablingUpload() {
    const upSubmit = document.querySelector('#fuclouds-upload #up-submit');
    const filteredFile = document.querySelectorAll('#fuclouds-upload #filtered-file li');
    
    upSubmit.disabled = filteredFile.length === 0;
}

function formatBytes(numBytes) {
    // Define the suffixes for different units
    const suffixes = ["B", "KB", "MB"];

    // Find the appropriate unit and format the number
    let index = 0;
    while (numBytes >= 1024 && index < suffixes.length - 1) {
        numBytes /= 1024;
        index++;
    }
    return numBytes.toFixed(2) + " " + suffixes[index];
}




const searchKeyword = document.querySelector('#fuclouds-search #keyword');
if (searchKeyword) {
    searchKeyword.addEventListener('input', element => element.target.value = element.target.value.replace(/[^a-zA-Z0-9/-]/g, ""));
}

const uploadCodename = document.querySelector('#fuclouds-upload #codename');
if (uploadCodename) {
    uploadCodename.addEventListener('input', element => element.target.value = element.target.value.replace(/[^a-zA-Z0-9-]/g, ""));
}