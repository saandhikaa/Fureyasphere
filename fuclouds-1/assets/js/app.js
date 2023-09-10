Scanning.prototype.triggerInput = element => {
    element.parentElement.parentElement.querySelector('.active-input').click();
};

Scanning.prototype.cancelInput = element => {
    element.closest('li').remove();
    enablingUpload();
};



const searchKeyword = document.querySelector('#fuclouds-search #keyword');
if (searchKeyword) {
    searchKeyword.addEventListener('input', event => event.target.value = event.target.value.replace(/[^a-zA-Z0-9/-]/g, ""));
    groupInput(searchKeyword, event);
}

const uploadCodename = document.querySelector('#fuclouds-upload #codename');
if (uploadCodename) {
    uploadCodename.addEventListener('input', event => {
        event.target.value = event.target.value.replace(/[^a-zA-Z0-9-]/g, "");
        enablingUpload();
    });
    groupInput(uploadCodename, event);
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
     
    // Append the input element to the file input container
    fileUploadContainer.appendChild(inputFile);
}

// Function to handle the 'change' event and access file information
function handleFileChange(element) {
    const listed = element.target.parentElement.parentElement.querySelectorAll('#filtered-file p.fileSize');
    const selectedFiles = element.target.files;
    const newFileSize = Array.from(selectedFiles).reduce((total, file) => total + file.size, 0);
    const uploadLimit = 40;    // config: upload limit in MB
    
    let listedFileSize = 0;
    if (listed.length > 0) {
        const sizes = Array.from(listed).map(size => size.textContent);
        
        for (const sizeString of sizes) {
            if (sizeString.includes(" KB")) {
                listedFileSize += Math.ceil(parseFloat(sizeString.replace(" KB", "")) * 1024);
            } else if (sizeString.includes(" MB")) {
                listedFileSize += Math.ceil(parseFloat(sizeString.replace(" MB", "")) * 1024 * 1024);
            }
        }
    }
    
    if (newFileSize + listedFileSize <= uploadLimit * 1024 * 1024) {
        Array.from(selectedFiles).forEach(file => {createFilteredFile(file.name, file.size)});
    } else {
        alert(`You chose a file that exceeds the ${uploadLimit}MB limit.`);
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
    fileText.classList.add('fileName');
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
    
    upSubmit.disabled = filteredFile.length === 0 || uploadCodename.value === '';
}

function formatBytes(numBytes) {
    const suffixes = ["B", "KB", "MB"];

    let index = 0;
    while (numBytes >= 1024 && index < suffixes.length - 1) {
        numBytes /= 1024;
        index++;
    }
    return numBytes.toFixed(2) + " " + suffixes[index];
}

function groupInput(element, event) {
    element.addEventListener('focus', event => {
        event.target.parentElement.style.border = '2px solid dodgerblue';
        event.target.parentElement.style.padding = '9px';
    });
    element.addEventListener('blur', event => {
        event.target.parentElement.style.border = '1px solid #999999';
        event.target.parentElement.style.padding = '10px';
    });
}