Scanning.prototype.triggerInput = element => {
    document.querySelector('.active-input').click();
};

Scanning.prototype.cancelInput = element => {
    element.closest('li').remove();
    inputCheck();
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
        inputCheck();
    });
    groupInput(uploadCodename, event);
}



function createInput() {
    const fileUploadContainer = document.querySelector('#fuclouds-upload #file-input-container');

    const inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = 'file[]';
    inputFile.classList.add('active-input');
    inputFile.multiple = true;
    inputFile.addEventListener('change', handleFileChange);
     
    fileUploadContainer.appendChild(inputFile);
}

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
}

async function createFilteredFile(filename, filesize) {
    const filteredFileContainer = document.querySelector('#fuclouds-upload #filtered-file');
    const filteredFile = document.createElement('li');
    const fileInfo = document.createElement('section');
    const fileDesc = document.createElement('section');
    const imagePath = document.querySelector('.image-path').textContent;
    
    fileInfo.classList.add('file-info');
    fileDesc.classList.add('file-desc');
    
    const fileThumbnail = document.createElement("img");
    fileThumbnail.onerror = () => fileThumbnail.src = imagePath + 'file-type-icon/others.png';
    fileThumbnail.src = imagePath + 'file-type-icon/' + filename.split('.').pop() + '.png';

    const fileText = document.createElement('p');
    fileText.classList.add('file-name');
    fileText.textContent = filename;
    
    const fileSize = document.createElement('p');
    fileSize.classList.add('file-size');
    fileSize.textContent = formatBytes(filesize);
    
    const fileInput = document.createElement('input');
    fileInput.type = 'hidden';
    fileInput.name = 'filteredFiles[]';
    fileInput.value = filename;
    
    const cancel = document.createElement('button');
    const cancelSVG = await fetch(imagePath + 'icons/close_FILL0_wght400_GRAD0_opsz24.svg').then(response => response.text());
    cancel.type = 'button';
    cancel.classList.add('cancelInput');
    cancel.classList.add('file-action');
    cancel.innerHTML = cancelSVG;
    
    fileDesc.append(fileText, fileSize, fileInput);
    fileInfo.append(fileThumbnail, fileDesc);
    filteredFile.append(fileInfo, cancel);
    filteredFileContainer.appendChild(filteredFile);
    
    const frame = document.querySelector('#filtered-file li').offsetWidth - document.querySelector('#filtered-file .cancelInput').offsetWidth - document.querySelector('#filtered-file img').offsetWidth - 20 - 10;
    const filelist = document.querySelectorAll('.file-name');
    insertEllipsis(frame, filelist);
    
    inputCheck();
}

function inputCheck() {
    const filteredFile = document.querySelectorAll('#fuclouds-upload #filtered-file li');
    
    const upSubmit = document.querySelector('#fuclouds-upload #up-submit');
    upSubmit.disabled = filteredFile.length === 0 || uploadCodename.value === '';
    
    const emptyMark = document.querySelector('#fuclouds-upload .empty');
    emptyMark.style.display = filteredFile.length === 0 ? 'block' : 'none';
}

function autorunResult() {
    const frame = document.querySelector('.file-list li').offsetWidth - document.querySelector('.file-list .file-action').offsetWidth - document.querySelector('.file-list img').offsetWidth - 20 - 10;
    const filelist = document.querySelectorAll('.file-name');
    insertEllipsis(frame, filelist);
    
    document.querySelector('.download-all svg').setAttribute('width', '30');
    document.querySelector('.download-all svg').setAttribute('height', '30');
    document.querySelector('.download-all svg path').setAttribute('fill', 'white');
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

function insertEllipsis(frame, list) {
    list.forEach(file => {
        let listSpread = [...file.textContent];
        let ellipsis = listSpread.slice(0, -8);
        let suffix = listSpread.slice(-8);
        
        while (file.offsetWidth > frame) {
            ellipsis.pop();
            file.textContent = ellipsis.join('') + ' . . . ' + suffix.join('');
        }
    });
}