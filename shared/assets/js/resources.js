const priority = ["google-fonts fonts", "google-fonts icons", "flaticon"];

const container = document.querySelector('#resources');
const groupList = Array.from(container.getElementsByTagName('ul'));

groupList.sort((a, b) => {
    const classNameA = a.className;
    const classNameB = b.className;
    
    const priorityA = priority.indexOf(classNameA) !== -1 ? priority.indexOf(classNameA) : priority.length;
    const priorityB = priority.indexOf(classNameB) !== -1 ? priority.indexOf(classNameB) : priority.length;
    
    return priorityA - priorityB;
});

let prevTitle = "";
groupList.forEach(ul => {
    const title = ul.className
        .split(' ')[0]
        .split('-')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    
    if (prevTitle !== title) {
        const h2title = document.createElement('h2');
        h2title.textContent = prevTitle = title;
        ul.insertBefore(h2title, ul.firstChild);
    }
    
    container.appendChild(ul);
});