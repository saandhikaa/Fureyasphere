// Function to handle the 'change' event and access file information
function handleFileChange(event) {
    const upSubmit = document.getElementById('up-submit');
    if (upSubmit.disabled) {
        upSubmit.disabled = false;
    }
    
    const selectedFiles = event.target.files;
    if (selectedFiles.length > 0) {
        for (let i = 0; i < selectedFiles.length; i++) {
            createStagedFiles(selectedFiles[i].name);
        }
    }
    event.target.classList.remove('active-input');
    createInput();
}

function createStagedFiles(selectedFile) {
    const stagedContainer = document.getElementById('staged-files');
    const filelist = document.createElement('li');
    
    const filepost = document.createElement('input');
    filepost.type = 'hidden';
    filepost.name = 'post[]';
    filepost.value = selectedFile;
    
    const filename = document.createElement('p');
    filename.textContent = selectedFile;
    
    const cancel = document.createElement('button');
    cancel.type = 'button';
    cancel.textContent = 'Cancel';
    cancel.addEventListener('click', function() {
        stagedContainer.removeChild(filelist);
    });
    
    filelist.appendChild(filepost);
    filelist.appendChild(filename);
    filelist.appendChild(cancel);
    stagedContainer.appendChild(filelist);
}

function createInput(isRequired = false) {
    const fileUploadContainer = document.getElementById('file-upload-container');
    
    // Create the input element with the specified attributes
    const inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = 'file[]';
    inputFile.style.display = 'none';
    inputFile.classList.add('file-input');
    inputFile.classList.add('active-input');
    inputFile.addEventListener('change', handleFileChange);
    inputFile.multiple = true;
     if (isRequired) {
         inputFile.required = true;
     }
     
    // Append the input element to the file input container div
    fileUploadContainer.appendChild(inputFile);
}

function clickActiveInput() {
    var activeInput = document.querySelector('.active-input');
    if (activeInput) {
        activeInput.click();
    }
}



function updateURL() {
    const form = document.getElementById('sr-form');
    
    var url = form.getAttribute('action');
    var codename = document.getElementById('codename').value;
    var key = document.getElementById('key').value;
    
    form.action = url + '/' + codename + '/' + key;
    form.submit();
}



function validateInput(inputElement) {
    inputElement.value = inputElement.value.replace(/[^a-zA-Z0-9\-]/g, "");
}