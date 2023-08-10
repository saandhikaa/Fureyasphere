const fileUploadContainer = document.getElementById('file-upload-container');
    
// Function to handle the 'change' event and access file information
function handleFileChange(event) {
    const selectedFiles = event.target.files;
    if (selectedFiles.length > 0) {
        for (let i = 0; i < selectedFiles.length; i++) {
            createStagedFiles(selectedFiles[i].name);
        }
    }
    event.target.style.display = 'none';
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
    cancel.textContent = 'Cancel';
    cancel.addEventListener('click', function() {
        stagedContainer.removeChild(filelist);
    });
    
    filelist.appendChild(filepost);
    filelist.appendChild(filename);
    filelist.appendChild(cancel);
    stagedContainer.appendChild(filelist);
    fileUploadContainer.appendChild(stagedContainer);
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



function updateURL() {
    const form = document.getElementById('searching');
    
    var url = form.getAttribute('action');
    var codename = document.getElementById('codename').value;
    var key = document.getElementById('key').value;
    
    form.action = url + '/' + codename + '/' + key;
    form.submit();
}



function validateInput(inputElement) {
    inputElement.value = inputElement.value.replace(/[^a-zA-Z0-9\-]/g, "");
}