const navContainer = document.querySelector('.navigation-container');
const navigation = document.querySelector('.navigation-container nav.navigation');
const navGroup = Array.from(navigation.children);
navGroup[1].style.top = navGroup[0].offsetHeight + 'px';
navGroup[1].style.bottom = navGroup[2].offsetHeight + 'px';



function Scanning(){}
const scan = new Scanning();

document.body.addEventListener('click', element => {
    const classes = element.target.className.split(' ');
    
    classes.forEach(className => {
        if (className in scan) {
            scan[className](element.target);
        }
    });
    
    element.stopPropagation();
});

Scanning.prototype.openNav = () => {
    navigation.style.width = navGroup[0].offsetWidth + 'px';
    navContainer.style.width = '100vw';
    document.body.style.overflow = 'hidden';
};

Scanning.prototype.closeNav = () => {
    navigation.style.width = '0';
    navContainer.style.width = '0';
    document.body.style.overflow = 'auto';
};

Scanning.prototype.feedbackList = (element) => {
    const container = document.querySelector('.feedback-list');
    const closing = document.querySelector('.navigation-container');
    
    if (container.offsetHeight == 0) {
        element.querySelector('svg').setAttribute('transform', 'rotate(180)');
        container.style.height = 'auto';
    } else {
        element.querySelector('svg').setAttribute('transform', 'rotate(0)');
        container.style.height = '0';
    }
};

(async function() {
    const buttonSTTContainer = document.querySelector('button.scrollToTop');
    if (buttonSTTContainer) {
        const bottomPosition = buttonSTTContainer.getAttribute('data-mb');
        buttonSTTContainer.style.bottom = bottomPosition ? bottomPosition + 'px' : '20px' ;
        
        let arrowUp = await fetch(document.querySelector('.image-path').textContent + 'icons/arrow_upward_FILL0_wght400_GRAD0_opsz24.svg').then(response => response.text());
        arrowUp = arrowUp.replace('<path', `<path fill="white"`);
        buttonSTTContainer.innerHTML = '<button class="scrollUp">' + arrowUp + '</button>';
        
        window.onscroll = function() { buttonSTTContainer.querySelector('button.scrollUp').style.display = document.body.scrollTop > 200 || document.documentElement.scrollTop > 200 ? "block" : "none" ; };
    }
})();

Scanning.prototype.scrollUp = () => {
    window.scrollTo({top: 0, behavior: 'smooth'});
};




const greetings = document.querySelectorAll('h1.nav-greeting');
greetings.forEach(greeting => {
    const hour = new Date().getHours();
    if (hour < 12) {
        greeting.textContent = 'Good morning!';
    } else if (hour < 18) {
        greeting.textContent = 'Good afternoon!';
    } else {
        greeting.textContent = 'Good evening!';
    }
});

const mainListSVG = Array.from(document.querySelectorAll('nav.navigation .main-list path'));
mainListSVG.forEach(path => {
    path.setAttribute('stroke', 'white' );
    path.setAttribute('stroke-width', '20' );
    path.setAttribute('fill', '#333333');
});

document.querySelector('.copyright span').innerHTML = `${new Date().getFullYear()}`;



function groupInput(element, event, padding = 10) {
    element.addEventListener('focus', event => {
        event.target.parentElement.style.border = '2px solid dodgerblue';
        event.target.parentElement.style.padding = `${padding-1}px`;
    });
    element.addEventListener('blur', event => {
        event.target.parentElement.style.border = '1px solid #999999';
        event.target.parentElement.style.padding = `${padding}px`;
    });
}

function thicknessSVG(selector, thickness) {
    const paths = Array.from(document.querySelectorAll(selector));
    paths.forEach(path => {
        path.setAttribute('stroke', 'white');
        path.setAttribute('stroke-width', thickness);
        path.setAttribute('fill', '#333333');
    });
}

async function loadReadme() {
    const baseURL = document.querySelector('.root-path').textContent;
    const section = Array.from(document.querySelectorAll('.readme'));
    
    section.forEach(async element => {
        const appDir = element.className.split(' ')[1];
        if (appDir != 'shared') {
            const content = await fetch(baseURL + '/' + appDir + '/README.md').then(response => response.text());
            element.innerHTML = marked.parse(content);
        } else {
            const content = await fetch(baseURL + '/README.md').then(response => response.text());
            element.innerHTML = marked.parse(content);
        }
    });
}
