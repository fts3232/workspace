const reducer = (state = { 'data': {}, 'error': {} }, action)=>{
    switch (action.type) {
        case 'SET_DATA':
            const { value, name } = action;
            const obj = {};
            obj[name] = value;
            return { ...state, data: Object.assign(state.data, obj) };
        case 'SET_ERROR':
            return { ...state, error: action.error };
        default:
            return state;
    }
};
export default reducer;