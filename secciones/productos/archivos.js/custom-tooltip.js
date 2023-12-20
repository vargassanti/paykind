elementsWithTooltip.forEach(element => {
    element.addEventListener('mouseenter', (e) => {
        const tooltipText = element.getAttribute('data-tooltip');
        const tooltipElement = createTooltipElement(tooltipText);
        positionTooltip(tooltipElement, e.clientX, e.clientY);
        document.body.appendChild(tooltipElement);
    });

    element.addEventListener('mousemove', (e) => {
        const tooltip = document.querySelector('.custom-tooltip');
        if (tooltip) {
            positionTooltip(tooltip, e.clientX, e.clientY);
        }
    });

    element.addEventListener('mouseleave', () => {
        const tooltip = document.querySelector('.custom-tooltip');
        if (tooltip) {
            tooltip.parentNode.removeChild(tooltip);
        }
    });
});

function createTooltipElement(text) {
    const tooltipElement = document.createElement('div');
    tooltipElement.classList.add('custom-tooltip');
    tooltipElement.textContent = text;
    return tooltipElement;
}

function positionTooltip(tooltip, x, y) {
    const offset = 10; // Ajusta la distancia entre el tooltip y el cursor
    tooltip.style.top = `${y + offset}px`;
    tooltip.style.left = `${x + offset}px`;
}