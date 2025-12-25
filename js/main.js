


function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const toolsGrid = document.getElementById('toolsGrid');
    const toolCards = toolsGrid.querySelectorAll('.tool-card');
    
    if (!searchInput || !toolsGrid) return;
    
    searchInput.addEventListener('input', (e) => {
        const keyword = e.target.value.toLowerCase().trim();
        
        toolCards.forEach(card => {
            const toolName = card.querySelector('.tool-name')?.textContent || '';
            const toolDesc = card.querySelector('.tool-desc')?.textContent || '';
            
            if (toolName.toLowerCase().includes(keyword) || toolDesc.toLowerCase().includes(keyword)) {
                card.style.display = 'block';
                card.style.animation = 'fadeInUp 0.4s ease forwards';
            } else {
                card.style.display = 'none';
            }
        });
    });
}


function initMenu() {
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(item => {
        const link = item.querySelector('.menu-link');
        if (!link) return;
        
        link.addEventListener('click', (e) => {
            
            menuItems.forEach(menuItem => {
                menuItem.classList.remove('active');
            });
            
            
            item.classList.add('active');
        });
    });
}


function initToolCards() {
    const toolCards = document.querySelectorAll('.tool-card');
    
    toolCards.forEach(card => {
        
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const btn = card.querySelector('.btn-use');
                if (btn) {
                    btn.click();
                }
            }
        });
        
        
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });
}


document.addEventListener('DOMContentLoaded', () => {
    initSearch();
    initMenu();
    initToolCards();
    
    console.log('Toolbox framework loaded');
});


function smoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}


function handleResize() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth <= 768) {
        sidebar.style.transform = 'translateX(-100%)';
    } else {
        sidebar.style.transform = 'translateX(0)';
    }
}


window.addEventListener('resize', handleResize);


window.addEventListener('load', () => {
    smoothScroll();
    handleResize();
});
