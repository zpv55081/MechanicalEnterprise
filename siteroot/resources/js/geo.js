import { accordion } from '@js/modules/elements/accordion/accordion.js';
import principleOfOperation from '@js/modules/elements/principleOfOperation';
import { Tooltip } from '@js/modules/elements/tooltips/tooltip';
import('@sass/elements/_swiper.scss');

document.addEventListener('DOMContentLoaded', function (event) {
    const tariffsSections = document.querySelectorAll('.tariffs-section');
    let tooltipEquips = new Tooltip('equip-tooltip');

    tariffsSections.forEach(section => {
        new TariffsSliderFilter(section).init();
    });

    if (document.querySelector('.search-settlements')) {
        import('./search').then((module) => {
            module.search();
        });
    }

    accordion();
    principleOfOperation();
    equipsSliderInit();

    tooltipEquips.init();
});
