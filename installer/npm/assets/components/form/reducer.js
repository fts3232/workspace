const themeReducer = (state = { status: 'error' }, action) => {
    switch (action.type) {
        case 'SET_DATA':
            return { ...state, themeColor: action.themeColor };
        default:
            return state;
    }
};
export default themeReducer;