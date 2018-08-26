const formData = (state = { error: {  }, value: { }, visible: {} }, action) => {
    switch (action.type) {
        case 'SET_ERROR':
            return { ...state, error: action.error };
        case 'SET_VALUE':
            return { ...state, value: Object.assign(state.value, action.value) };
        case 'GET_VALUE':
            return state.value;
        default:
            return state;
    }
};

const formErrorMsg = (state = { error: {  }, value: { }, visible: {} }, action) => {
    switch (action.type) {
        case 'SET_ERROR':
            return { ...state, error: action.error };
        case 'SET_VALUE':
            return { ...state, value: Object.assign(state.value, action.value) };
        case 'GET_VALUE':
            return state.value;
        default:
            return state;
    }
};

const dataPicker = (state = { }, action) => {
    switch (action.type) {
        case 'SET_VISIBLE':
            state[action.name].visible = action.visible;
            console.log(state);
            return { ...state };
        default:
            return state;
    }
};


export { formData, dataPicker, formErrorMsg };