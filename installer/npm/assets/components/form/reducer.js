const reducer = (state = { 'data': {}, 'error': {} }, action)=>{
    switch (action.type) {
        case 'SET_DATA':
            const { value, name, multiple } = action;
            const obj = {};
            console.log(name, multiple);
            if (multiple) {
                if (typeof state.data[name] !== 'undefined') {
                    if (value instanceof Array) {
                        obj[name] = value;
                    } else {
                        state.data[name].push(value);
                        obj[name] = state.data[name];
                    }
                } else {
                    obj[name] = value instanceof Array ? value : [value];
                }
            } else {
                obj[name] = value;
            }
            console.log(Object.assign(state.data, obj));
            return { ...state, data: Object.assign(state.data, obj) };
        case 'SET_ERROR':
            return { ...state, error: action.error };
        default:
            return state;
    }
};
export default reducer;