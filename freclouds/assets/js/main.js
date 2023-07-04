// upload
function handleFileSelection(fileInput) {
    var fileInputContainer = fileInput.parentNode;
    var cancelButton = fileInputContainer.querySelector('.cancel-button');
    
    if (fileInput.files.length > 0 && !cancelButton) {
        cancelButton = document.createElement('button');
        cancelButton.type = 'button';
        cancelButton.className = 'cancel-button';
        cancelButton.textContent = 'Cancel';
        cancelButton.onclick = function() {
            cancelFileInput(this);
        };
        fileInputContainer.appendChild(cancelButton);
        
        // Add a new file input container after file selection
        var container = document.getElementById('file-upload-container');
        var newFileInputContainer = document.createElement('div');
        newFileInputContainer.className = 'file-input-container';
        
        var newFileInput = document.createElement('input');
        newFileInput.type = 'file';
        newFileInput.name = 'file[]';
        newFileInput.className = 'file-input';
        newFileInput.onchange = function() {
            handleFileSelection(this);
        };
        
        newFileInputContainer.appendChild(newFileInput);
        container.appendChild(newFileInputContainer);
        
    } else if (cancelButton) {
        fileInputContainer.parentNode.removeChild(fileInputContainer);
    }
}

function cancelFileInput(cancelButton) {
    var fileInputContainer = cancelButton.parentNode;
    fileInputContainer.parentNode.removeChild(fileInputContainer);
}