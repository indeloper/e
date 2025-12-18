import Aura from '@primevue/themes/aura';
import { definePreset } from '@primevue/themes';

// Кастомный пресет с первичным цветом #041E42
export const CustomPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{sky.50}',
            100: '{sky.100}',
            200: '{sky.200}',
            300: '{sky.300}',
            400: '{sky.400}',
            500: '{sky.500}',
            600: '{sky.600}',
            700: '{sky.700}',
            800: '{sky.800}',
            900: '{sky.900}',
            950: '{sky.950}'
        },
        colorScheme: {
            light: {
                primary: {
                    color: '#041E42',
                    inverseColor: '#ffffff',
                    hoverColor: '#031838',
                    activeColor: '#02122e'
                }
            },
            dark: {
                primary: {
                    color: '#6b9bd1',
                    inverseColor: '#041E42',
                    hoverColor: '#85aed9',
                    activeColor: '#9fc1e1'
                }
            }
        }
    },
    primitive: {
        sky: {
            50: '#e6eef6',
            100: '#ccdded',
            200: '#99bbdb',
            300: '#6699c9',
            400: '#3377b7',
            500: '#041E42',
            600: '#031838',
            700: '#02122e',
            800: '#020c1f',
            900: '#010615',
            950: '#00030a'
        }
    }
});

// Русская локализация для PrimeVue
export const ruLocale = {
    accept: 'Да',
    reject: 'Нет',
    choose: 'Выбрать',
    upload: 'Загрузить',
    cancel: 'Отмена',
    pending: 'В ожидании',
    fileSizeTypes: ['Б', 'КБ', 'МБ', 'ГБ', 'ТБ', 'ПБ', 'ЭБ', 'ЗБ', 'ЙБ'],
    dayNames: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
    dayNamesShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
    chooseYear: 'Выберите год',
    chooseMonth: 'Выберите месяц',
    chooseDate: 'Выберите дату',
    prevDecade: 'Предыдущее десятилетие',
    nextDecade: 'Следующее десятилетие',
    prevYear: 'Предыдущий год',
    nextYear: 'Следующий год',
    prevMonth: 'Предыдущий месяц',
    nextMonth: 'Следующий месяц',
    prevHour: 'Предыдущий час',
    nextHour: 'Следующий час',
    prevMinute: 'Предыдущая минута',
    nextMinute: 'Следующая минута',
    prevSecond: 'Предыдущая секунда',
    nextSecond: 'Следующая секунда',
    am: 'ДП',
    pm: 'ПП',
    today: 'Сегодня',
    weekHeader: 'Нед',
    firstDayOfWeek: 1,
    showMonthAfterYear: false,
    dateFormat: 'dd.mm.yy',
    weak: 'Слабый',
    medium: 'Средний',
    strong: 'Сильный',
    passwordPrompt: 'Введите пароль',
    emptyFilterMessage: 'Результаты не найдены',
    searchMessage: 'Доступно {0} результатов',
    selectionMessage: 'Выбрано {0} элементов',
    emptySelectionMessage: 'Элемент не выбран',
    emptySearchMessage: 'Результаты не найдены',
    emptyMessage: 'Нет доступных вариантов',
    aria: {
        trueLabel: 'Да',
        falseLabel: 'Нет',
        nullLabel: 'Не выбрано',
        star: '1 звезда',
        stars: '{star} звёзд',
        selectAll: 'Выбраны все элементы',
        unselectAll: 'Все элементы сняты',
        close: 'Закрыть',
        previous: 'Предыдущий',
        next: 'Следующий',
        navigation: 'Навигация',
        scrollTop: 'Прокрутить вверх',
        moveTop: 'Переместить в начало',
        moveUp: 'Переместить вверх',
        moveDown: 'Переместить вниз',
        moveBottom: 'Переместить в конец',
        moveToTarget: 'Переместить в выбранные',
        moveToSource: 'Переместить в доступные',
        moveAllToTarget: 'Переместить все в выбранные',
        moveAllToSource: 'Переместить все в доступные',
        pageLabel: 'Страница {page}',
        firstPageLabel: 'Первая страница',
        lastPageLabel: 'Последняя страница',
        nextPageLabel: 'Следующая страница',
        prevPageLabel: 'Предыдущая страница',
        rowsPerPageLabel: 'Строк на странице',
        jumpToPageDropdownLabel: 'Перейти к странице',
        jumpToPageInputLabel: 'Перейти к странице',
        selectRow: 'Выбрать строку',
        unselectRow: 'Снять выбор строки',
        expandRow: 'Развернуть строку',
        collapseRow: 'Свернуть строку',
        showFilterMenu: 'Показать меню фильтра',
        hideFilterMenu: 'Скрыть меню фильтра',
        filterOperator: 'Оператор фильтра',
        filterConstraint: 'Условие фильтра',
        editRow: 'Редактировать строку',
        saveEdit: 'Сохранить изменения',
        cancelEdit: 'Отменить изменения',
        listView: 'Вид списком',
        gridView: 'Вид сеткой',
        slide: 'Слайд',
        slideNumber: '{slideNumber}',
        zoomImage: 'Увеличить изображение',
        zoomIn: 'Увеличить',
        zoomOut: 'Уменьшить',
        rotateRight: 'Повернуть вправо',
        rotateLeft: 'Повернуть влево'
    }
};

