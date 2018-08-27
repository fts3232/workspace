const formData = (state = {}, action) => {
    switch (action.type) {
        case 'SET_FORM_DATA':
            const obj = {};
            obj[action.name] = action.value;
            return { ...state, ...obj };
        default:
            return state;
    }
};

const formErrorMsg = (state = {}, action) => {
    switch (action.type) {
        case 'SET_FORM_ERROR':
            return { ...state, ...action.error };
        default:
            return state;
    }
};

const dataPicker = (state = {}, action) => {
    switch (action.type) {
        case 'SET_DATE_PICKER_VISIBLE':
            const obj = {};
            obj[action.name] = typeof state[action.name] === 'undefined' ? {} : state[action.name];
            obj[action.name].visible = action.visible;
            return { ...state, ...obj };
        default:
            return state;
    }
};


export { formData, dataPicker, formErrorMsg };